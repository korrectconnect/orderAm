<?php

namespace App\Http\Controllers;

use App\Address;
use App\Coupon;
use App\Menu_category;
use App\Menus;
use App\Order;
use App\Order_item;
use App\User;
use App\Vendor_auth;
use App\Vendors;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class VendorAjaxController extends Controller
{
    //
    public function orders($status, $cancelled, Request $request) {
        if ($request->ajax()) {
            $vendor_id = auth()->guard('vendor')->user()->vendor_id ;
            if ($cancelled == 1) {
                $query = Order::where(['vendor_id' => $vendor_id, 'cancelled' => 1])->get();
            } else {
                $query = Order::where(['vendor_id' => $vendor_id, 'cancelled' => 0, 'status' => $status])->get();
            }

            $data = array(
                'orders' => $query,
                'status' => $status,
                'cancelled' => $cancelled,
            );

            return view('vendor.pages.ajax.orders')->with($data);

        }
    }

    public function order($order_no, Request $request) {
        if ($request->ajax()) {
            $order = Order::where(['order_no' => $order_no])->first();

                if ($order != NULL) {
                    $vendor = Vendors::findOrFail(auth()->guard('vendor')->user()->vendor_id );
                    $address = Address::findOrFail($order->address);
                    $order_items = Order_item::where(['order_no' => $order_no])->get();
                    $user = User::where(['id' => $order->user_id])->first();
                    if($order->coupon_code == NULL) {
                        $coupon = NULL ;
                    }else {
                        $coupon = Coupon::where(['code' => $order->coupon_code])->first();
                    }

                    $data = array(
                        'order' => $order,
                        'vendor' => $vendor,
                        'address' => $address,
                        'order_items' => $order_items,
                        'coupon' => $coupon,
                        'user' => $user,
                    );

                    return view('vendor.pages.ajax.order')->with($data);
                }
        }
    }

    public function confirmOrder($order_no, Request $request) {
        if ($request->ajax()) {
            $vendor_id = auth()->guard('vendor')->user()->vendor_id ;

            $order = Order::where(['order_no' => $order_no, 'vendor_id' => $vendor_id]);
            if ($order->first() != NULL) {
                $update = $order->update([
                    'cancelled' => 0,
                    'status' => 1,
                ]);

                if ($update) {
                    return response()->json(['errors' => NULL, 'message' => 'Order has been confirmed. Pending delivery']);
                }else {
                    return response()->json(['errors' => ['Could not confirm, try again']]);
                }
            }
        }
    }

    public function declineOrder($order_no, Request $request) {
        if ($request->ajax()) {
            $vendor_id = auth()->guard('vendor')->user()->vendor_id ;

            $order = Order::where(['order_no' => $order_no, 'vendor_id' => $vendor_id]);
            if ($order->first() != NULL) {
                $update = $order->update([
                    'cancelled' => 1,
                    'status' => 2,
                ]);

                if ($update) {
                    return response()->json(['errors' => NULL, 'message' => 'Order has been confirmed. Pending delivery']);
                }else {
                    return response()->json(['errors' => ['Could not confirm, try again']]);
                }
            }
        }
    }

    public function getMenuList($category, Request $request) {
        if($request->ajax()) {
            if ($category == 'NULL') {
                $category = NULL ;
            }
            $vendor_id = auth()->guard('vendor')->user()->vendor_id ;
            $menus = Menus::where(['vendor_id' => $vendor_id, 'category' => $category])->orderBy('id', 'desc')->get() ;
            if($request->session()->has('vendor_secret')) {
                if(decrypt($request->session()->get('vendor_secret')) == decrypt(auth()->guard('vendor')->user()->secret)) {
                    $auth = true ;
                }else {
                    $request->session()->forget('vendor_secret');
                    $auth = false ;
                }
            }else {
                $auth = false;
            }

            $data = array(
                'menus' => $menus,
                'vendor_id' => $vendor_id,
                'auth' => $auth,
            );

            return view('vendor.pages.ajax.menu_list')->with($data);
        }
    }

    public function menuForm(Request $request) {
        if($request->ajax()) {
            $vendor_id = auth()->guard('vendor')->user()->vendor_id ;
            $menu_categories = Menu_category::where(['vendor_id' => $vendor_id])->get() ;

            $data = array(
                'menu_categories' => $menu_categories,
            );

            return view('vendor.pages.ajax.add_menu')->with($data);
        }
    }

    public function changePassword(Request $request) {
        if($request->ajax()) {
            $vendor_id = auth()->guard('vendor')->user()->vendor_id ;

            if (!(Hash::check($request->old, auth()->guard('vendor')->user()->password))) {
                return response()->json(['errors'=>['Old Password is incorrect']]);
            }else {
                if(strcmp($request->old, $request->password) == 0) {
                    return response()->json(['errors'=>['New Password cannot be same as your current Password. Please Choose a different Password']]);
                }else {
                    $validatedData = Validator::make($request->all(), [
                        'old' => 'required',
                        'password' => 'required|string|min:6|confirmed',
                    ]);

                    if ($validatedData->fails()) {
                        return response()->json(['errors'=>$validatedData->errors()->all()]);
                    }else {
                        $query = Vendor_auth::where(['vendor_id' => $vendor_id])->update([
                            'password' => bcrypt($request->password),
                        ]);

                        if($query) {
                            return response()->json(['errors'=>null, 'message'=>'Password changed Successfully']);
                        }else {
                            return response()->json(['errors'=>['Error !, try again later']]);
                        }

                    }

                }
            }
        }
    }

    public function addMenu(Request $request) {
        if($request->ajax()) {
            $vendor_id = auth()->guard('vendor')->user()->vendor_id ;
            $validatedData = Validator::make($request->all(), [
                'name' => 'max:55|required',
                'cover' => 'required|image|max:1999',
                'description' => 'max:250|required',
                'price' => 'max:250|required',
                'category' => 'max:250|required',
            ]);

            if ($validatedData->fails())
            {
                return response()->json(['errors'=>$validatedData->errors()->all()]);
            }else {
                if ($request->hasFile('cover')) {

                    $extension = $request->file('cover')->getClientOriginalExtension();
                    $filename = $request->name.'_'.$vendor_id.'_'.time().'.'.$extension ;
                    $path = $request->file('cover')->storeAs('public/menu', $filename) ;

                    $category = Menu_category::where(['vendor_id' => $vendor_id, 'category' => $request->category])->first();

                    if($path) {
                        $query = Menus::insert([
                            'vendor_id' => $vendor_id,
                            'menu' => $request->name,
                            'description' => $request->description,
                            'category' => $request->category,
                            'price' => $request->price,
                            'image' => asset('storage/menu/'.$filename),
                            'stock' => 1,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]) ;
                        if($query) {
                            return response()->json(['errors'=>null, 'message'=>'Uploaded Successfully', 'category' => $category->id]);
                        }
                        return response()->json(['errors'=>['Server error try again']]);
                    }
                    return response()->json(['errors'=>'Error uploading file']);

                }else {

                    return response()->json(['errors'=>'No file Selected']);

                }
            }

        }
    }

    public function menuCategoryForm(Request $request) {
        if($request->ajax()) {
            $vendor_id = auth()->guard('vendor')->user()->vendor_id ;

            return view('vendor.pages.ajax.add_category_form');
        }
    }

    public function addMenuCategory(Request $request) {
        if($request->ajax()) {
            $vendor_id = auth()->guard('vendor')->user()->vendor_id ;
            $validatedData = Validator::make($request->all(), [
                'category' => 'max:20|required',
            ]);

            if ($validatedData->fails())
            {
                return response()->json(['errors'=>$validatedData->errors()->all()]);
            }else {

                $get = Menu_category::where(['vendor_id' => $vendor_id, 'category' => $request->category])->first() ;

                if ($get == NULL) {
                    $query = Menu_category::insert([
                        'vendor_id' => $vendor_id,
                        'category' => $request->category,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]) ;
                    if($query) {
                        return response()->json(['errors'=>null, 'message'=>'Menu Category added Successfully']);
                    }
                    return response()->json(['errors'=>['Server error try again']]);
                }
                return response()->json(['errors'=>['Menu category already exist']]);

            }

        }
    }

    public function editMenuCategoryForm($id, Request $request) {
        if ($request->ajax()) {
            $vendor_id = auth()->guard('vendor')->user()->vendor_id ;
            $category = Menu_category::where(['vendor_id' => $vendor_id, 'id' => $id ])->first();

            $data = array(
                'category' => $category,
            );

            return view('vendor.pages.ajax.edit_category_form')->with($data);
        }
    }

    public function editMenuCategory(Request $request) {
        if($request->ajax()) {
            $vendor_id = auth()->guard('vendor')->user()->vendor_id ;
            $validatedData = Validator::make($request->all(), [
                'category' => 'max:20|required',
            ]);

            if ($validatedData->fails())
            {
                return response()->json(['errors'=>$validatedData->errors()->all()]);
            }else {

                $get = Menu_category::where(['vendor_id' => $vendor_id, 'category' => $request->category])->first() ;

                if ($get == NULL) {
                    $query = Menu_category::where(['id' => $request->id])->update([
                        'category' => $request->category,
                        'updated_at' => now(),
                    ]) ;
                    if($query) {
                        return response()->json(['errors'=>null, 'message'=>'Menu Category updated Successfully']);
                    }
                    return response()->json(['errors'=>['Server error try again']]);
                }
                return response()->json(['errors'=>['Menu category already exist']]);

            }

        }
    }

    public function deleteMenuCategory($id, Request $request) {
        if ($request->ajax()) {
            $vendor_id = auth()->guard('vendor')->user()->vendor_id ;
            $category = Menu_category::where(['id' => $id, 'vendor_id' => $vendor_id]);
            if ($category->first() != NULL) {

                $name = $category->first()->category ;
                $delete = $category->delete();
                if ($delete) {
                    $menu = Menus::where(['vendor_id' => $vendor_id, 'category' => $name]);
                    $countMenu = $menu->count();
                    $menu->update([
                        'category' => NULL,
                    ]);

                    return response()->json(['errors'=>null, 'message'=>'Menu Category deleted Successfully and ('.$countMenu.') menu items has been moved to the UNSORTED list']);

                } else {
                    return response()->json(['errors'=>['Error, could not delete Menu category']]);
                }

            }else {
                return response()->json(['errors'=>['Invalid Menu category']]);
            }
        }
    }

    public function toggleMenuStock($id, Request $request) {
        if ($request->ajax()) {
            $vendor_id = auth()->guard('vendor')->user()->vendor_id ;

            $get = Menus::where(['id' => $id, 'vendor_id' => $vendor_id]);
            if ($get->first() != NULL) {
                $category = Menu_category::where(['vendor_id' => $vendor_id, 'category' => $get->first()->category])->first();

                $getStock = $get->first()->stock ;
                if ($getStock == 0) {
                    $stock = 1 ;
                } elseif($getStock == 1) {
                    $stock = 0 ;
                }

                $update = $get->update([
                    'stock' => $stock,
                ]);

                if($update) {
                    return response()->json(['errors'=>null, 'message'=>'Menu updated Successfully', 'category' => $category->id]);
                }
                return response()->json(['errors'=>['Server error try again']]);

            }
            return response()->json(['errors'=>['Invalid Menu selected']]);
        }
    }

    public function editMenuForm($id, Request $request) {
        if ($request->ajax()) {
            $vendor_id = auth()->guard('vendor')->user()->vendor_id ;

            $menu = Menus::where(['vendor_id' => $vendor_id, 'id' => $id ])->first();
            $category = Menu_category::where(['vendor_id' => $vendor_id])->get();

            $data = array(
                'menu' => $menu,
                'menu_categories' => $category,
            );

            return view('vendor.pages.ajax.edit_menu')->with($data);
        }
    }

    public function editMenu(Request $request) {
        if ($request->ajax()) {
            $vendor_id = auth()->guard('vendor')->user()->vendor_id ;
            $validatedData = Validator::make($request->all(), [
                'name' => 'max:55|required',
                'cover' => 'image|max:1999',
                'description' => 'max:250|required',
                'price' => 'max:10|required',
                'category' => 'max:250|required',
            ]);

            if ($validatedData->fails())
            {
                return response()->json(['errors'=>$validatedData->errors()->all()]);
            }else {
                $category = Menu_category::where(['vendor_id' => $vendor_id, 'category' => $request->category])->first();
                if ($request->hasFile('cover')) {

                    $extension = $request->file('cover')->getClientOriginalExtension();
                    $filename = $request->name.'_'.$vendor_id.'_'.time().'.'.$extension ;
                    $path = $request->file('cover')->storeAs('public/menu', $filename) ;

                    if($path) {
                        $query = Menus::where(['vendor_id' => $vendor_id, 'id' => $request->id])->update([
                            'menu' => $request->name,
                            'description' => $request->description,
                            'category' => $request->category,
                            'price' => $request->price,
                            'image' => asset('storage/menu/'.$filename),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]) ;
                    }else {
                        return response()->json(['errors'=>['Error uploading file']]);
                    }


                }else {

                    $query = Menus::where(['vendor_id' => $vendor_id, 'id' => $request->id])->update([
                        'menu' => $request->name,
                        'description' => $request->description,
                        'category' => $request->category,
                        'price' => $request->price,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]) ;

                }

                if($query) {
                    return response()->json(['errors'=>null, 'message'=>'Uploaded Successfully', 'category' => $category->id]);
                }
                return response()->json(['errors'=>['Server error try again']]);
            }
        }
    }

    public function deleteMenu($id, Request $request) {
        if ($request->ajax()) {
            $vendor_id = auth()->guard('vendor')->user()->vendor_id ;

            $delete = Menus::where(['vendor_id' => $vendor_id, 'id' => $id])->delete();
            if ($delete) {
                return response()->json(['errors'=>null, 'message'=>'Menu deleted Successfully']);
            }
            return response()->json(['errors'=>['Server error try again']]);
        }
    }

    public function transactionToday(Request $request) {
        if ($request->ajax()) {
            $vendor_id = auth()->guard('vendor')->user()->vendor_id ;

            $orders = Order::where(['vendor_id' => $vendor_id, 'cancelled' => 0, 'status' => 2])
                                ->whereDate('updated_at', Carbon::today())->get();
            if ($orders->count() >= 1) {
                $t = 0 ;
                $c = 0;
                foreach ($orders as $order) {
                    $t += ($order->total - $order->delivery_charge) ;
                    $c += (($order->total - $order->delivery_charge)  * $order->commission)/100;
                }
                $total = $t ;
            } else {
                $total = 0.00;
                $t = 0 ;
                $c = 0;
            }


            $data = array(
                'orders' => $orders,
                'total' => $total,
                'commission' => $c,
                'profit' => $total - $c,
            );

            return view('vendor.pages.ajax.transaction_today')->with($data);
        }
    }

    public function transactionFilter(Request $request) {
        if ($request->ajax()) {
            $vendor_id = auth()->guard('vendor')->user()->vendor_id ;

            return view('vendor.pages.ajax.filter');
        }
    }

    public function transactionFiltered(Request $request) {
        if ($request->ajax()) {
            $vendor_id = auth()->guard('vendor')->user()->vendor_id ;

            if ($request->start == NULL || $request->end == NULL) {
                return response()->json(['errors' => ['At least one filled was left undefined']]);
            }else {
                $end = Carbon::createFromFormat('Y-m-d', $request->end);

                $orders = Order::where(['vendor_id' => $vendor_id, 'cancelled' => 0, 'status' => 2])->whereBetween('updated_at', [$request->start, $end])->get();
                if ($orders->count() >= 1) {
                    $t = 0 ;
                    $c = 0 ;
                    foreach ($orders as $order) {
                        $t += ($order->total - $order->delivery_charge) ;
                        $c += (($order->total - $order->delivery_charge)  * $order->commission)/100;
                    }
                    $total = $t ;
                } else {
                    $total = 0.00;
                    $c = 0;
                }


                $data = array(
                    'orders' => $orders,
                    'total' => $total,
                    'start' => $request->start,
                    'end' => $request->end,
                    'commission' => $c,
                    'profit' => $total - $c,
                );

                return view('vendor.pages.ajax.filtered')->with($data);
            }
        }
    }
}
