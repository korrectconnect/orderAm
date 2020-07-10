<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Location;
use App\Menus;
use App\Vendor_category;
use App\Cart;
use App\Coupon;
use App\Favourite_vendor;
use App\Order;
use App\Order_item;
use App\User;
use App\Vendors;
use Carbon\Carbon;
use App\Address;
use App\Customer;

class AjaxController extends Controller
{
    //
    public function storeLocationToSession(Request $request) {
        if($request->ajax()) {

            $insert = $request->session()->put('location',['state' => $request->state, 'area' => $request->area]);

            return response()->json(['errors'=>null, 'status'=>'true']);
        }

    }

    public function register(Request $request) {
        if ($request->ajax()) {
            $validatedData = Validator::make($request->all(), [
                'phone' => 'required|max:15',
                'lastname' => 'required|max:50',
                'firstname' => 'required|max:50',
                'password' => 'required|min:4|confirmed',
                'email' => 'required|email|unique:users',

            ]);

            if ($validatedData->fails())
            {
                return response()->json(['errors'=>$validatedData->errors()->all()]);
            }else {

                $insert = User::insert([
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'role' => 'customer',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                if ($insert) {

                    $getUser = User::where(['email' => $request->email])->first() ;
                    $insert_c = Customer::insert([
                        'firstname' => $request->firstname,
                        'lastname' => $request->lastname,
                        'phone' => $request->phone,
                        'user_id' => $getUser->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                        return response()->json(['errors'=>null, 'message'=>'Sign Up Successful']);
                    }else {
                        return response()->json(['errors'=>['Could not log you in automatically, try login in manually']]);
                    }
                } else {
                    return response()->json(['errors'=>['Sign up error, try again after some time']]);
                }

            }
        }
    }

    public function login(Request $request) {
        if ($request->ajax()) {
            $validatedData = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validatedData->fails())
            {
                return response()->json(['errors'=>$validatedData->errors()->all()]);
            }else {
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                    return response()->json(['errors'=>null, 'message'=>'Sign in Successful']);
                }else {
                    return response()->json(['errors'=>['Invalid email or password']]);
                }
            }
        }
    }

    public function getVendorMenu($vendor, $category, Request $request) {
        if($request->ajax()) {
            $menus = Menus::where(['vendor_id' => $vendor, 'category' => $category])->get() ;

            $data = array(
                'menus' => $menus,
                'vendor_id' => $vendor,
            );

            return view('user.ajax.menu_list')->with($data);
        }
    }

    public function addToCart(Request $request) {
        if($request->ajax()) {
            if (Auth::check()) {
                $get = Cart::where([['user_id','=',auth()->user()->id],['menu_id','=',$request->menu_id]])->first();
                $menu = Menus::findOrFail($request->menu_id);
                $vendor = Vendors::findOrFail($request->vendor_id);
                if((date("H.i") < $vendor->opening) || (date("H.i") >= $vendor->closing)) {
                    return response()->json(['errors'=>['Vendor is closed'], 'auth'=>true, 'menu' => $request->menu_id, 'vendor' => $request->vendor_id]);
                }

                if($get != null) {
                    $quantity = $get->quantity + 1;
                    $update = Cart::where([['menu_id','=',$request->menu_id],['user_id','=',auth()->user()->id]])->update(['quantity' => $quantity]);
                    $count = Cart::where([['user_id','=',auth()->user()->id],['vendor_id','=',$request->vendor_id]])->get();
                    return response()->json(['errors'=>null, 'auth'=>true, 'menu' => $request->menu_id, 'vendor' => $request->vendor_id, 'count' => $count->count()]);
                }else {
                    $cart = new Cart ;
                    $cart->user_id = auth()->user()->id;
                    $cart->menu_id = $request->menu_id;
                    $cart->vendor_id = $request->vendor_id;
                    $cart->quantity = 1;
                    $cart->name = $menu->menu;
                    $cart->price = $menu->price;

                    if ($cart->save()) {
                        $count = Cart::where([['user_id','=',auth()->user()->id],['vendor_id','=',$request->vendor_id]])->get();
                        return response()->json(['errors'=>null, 'auth'=>true, 'menu' => $request->menu_id, 'vendor' => $request->vendor_id, 'count' => $count->count()]);
                    }else {
                        return response()->json(['errors'=>['Could not add to cart'], 'auth'=>true, 'menu' => $request->menu_id, 'vendor' => $request->vendor_id]);
                    }
                }

            }else {
                return response()->json(['errors'=>null, 'auth'=>false, 'menu' => $request->menu_id]);
            }
        }
    }

    public function loginFrom(Request $request) {
        if($request->ajax()) {
            return view('user.ajax.login');
        }
    }

    public function registerFrom(Request $request) {
        if($request->ajax()) {
            return view('user.ajax.register');
        }
    }

    public function recoverFrom(Request $request) {
        if($request->ajax()) {
            return view('user.ajax.recover');
        }
    }

    public function cart($id, Request $request) {
        if ($request->ajax()) {
            if(Auth::check()) {
                $vendor = Vendors::findOrFail($id);

                $carts = Cart::where(['user_id' => auth()->user()->id, 'vendor_id' => $vendor->id])->orderBy('id', 'desc')->get() ;

                if($carts->count() >= 1) {
                    $order_total = 0 ;
                    foreach ($carts as $cart) {
                        $order_total = $order_total + ($cart->price * $cart->quantity);
                    }
                }else {
                    $order_total = 0 ;
                }

                $total = $vendor->delivery_charge + $vendor->tax + $vendor->vendor_charge + $order_total ;

                $data = array(
                    'carts' => $carts,
                    'order_total' => $order_total,
                    'total' => $total,
                    'vendor' => $vendor,
                );

                return view('user.ajax.cart')->with($data);
            }
        }
    }

    public function deleteCart($id, Request $request) {
        if ($request->ajax()) {
            if (Auth::check()) {
                $cart = Cart::where(['id' => $id]);
                $getCart = $cart->first();
                $vendor = $getCart->vendor_id ;
                if($cart->delete()) {
                    $userCart = Cart::where(['vendor_id' => $vendor, 'user_id' => auth()->user()->id])->get();

                    return response()->json(['errors'=>null, 'vendor'=>$vendor, 'count' => $userCart->count()]);
                }else {
                    return response()->json(['errors'=>['Could not delete item']]);
                }
            }
        }
    }

    public function decreaseCart($id, Request $request) {
        if ($request->ajax()) {
            if (Auth::check()) {
                $cart = Cart::where(['id' => $id]);
                $getCart = $cart->first();
                $vendor = $getCart->vendor_id ;

                if($getCart->quantity > 1) {
                    $update = $cart->update(['quantity' => $getCart->quantity - 1]) ;
                }else {
                    $update = $cart->delete();
                }

                if($update) {
                    $userCart = Cart::where(['vendor_id' => $vendor, 'user_id' => auth()->user()->id])->get();

                    return response()->json(['errors'=>null, 'vendor'=>$vendor, 'count' => $userCart->count()]);
                }else {
                    return response()->json(['errors'=>['Could not decrease item quantity']]);
                }
            }
        }
    }

    public function increaseCart($id, Request $request) {
        if ($request->ajax()) {
            if (Auth::check()) {
                $cart = Cart::where(['id' => $id]);
                $getCart = $cart->first();
                $vendor = $getCart->vendor_id ;

                $update = $cart->update(['quantity' => $getCart->quantity + 1]) ;

                if($update) {
                    $userCart = Cart::where(['vendor_id' => $vendor, 'user_id' => auth()->user()->id])->get();

                    return response()->json(['errors'=>null, 'vendor'=>$vendor, 'count' => $userCart->count()]);
                }else {
                    return response()->json(['errors'=>['Could not increase item quantity']]);
                }
            }
        }
    }

    public function addressForm(Request $request) {
        if ($request->ajax()) {
            if (Auth::check()) {
                $states = Location::where('type','=','state')->get();
                $lgas = Location::where('type','=','lga')->get();
                $areas = Location::where('type','=','area')->get();
                $user = Customer::where(['user_id' => auth()->user()->id])->first() ;

                $data = array(
                    'states' => $states,
                    'lgas' => $lgas,
                    'areas' => $areas,
                    'user' => $user,
                );
                return view("user.ajax.address")->with($data);
            }
        }
    }

    public function addAddress(Request $request) {
        if ($request->ajax()) {
            if (Auth::check()) {
                $validatedData = Validator::make($request->all(), [
                    'state' => 'required|max:50',
                    'lga' => 'required',
                    'address' => 'required',
                ]);

                if ($validatedData->fails())
                {
                    return response()->json(['errors'=>$validatedData->errors()->all()]);
                }else {
                    $insert = Address::insert([
                        'user_id' => auth()->user()->id,
                        'state' => $request->state,
                        'lga' => $request->lga,
                        'address' => $request->address,
                        'description' => $request->description,
                        'phone' => $request->phone,
                    ]) ;

                    if ($insert) {
                        if (Address::where(['user_id' => auth()->user()->id])->get()->count() == 1) {
                            $getAddress = Address::where(['user_id' => auth()->user()->id])->firstOrFail();
                            $updateUser = Customer::where(['user_id' => auth()->user()->id])->update([
                                'address_id' => $getAddress->id,
                            ]);
                            $updateAddress = $getAddress->update([
                                'default' => 1,
                            ]) ;

                            return response()->json(['errors'=>NULL, 'message' => 'Address added successfully']);
                        }else {
                            return response()->json(['errors'=>NULL, 'message' => 'Address added successfully']);
                        }
                    }else {
                        return response()->json(['errors'=>['Error adding address, try again']]);
                    }
                }
            }
        }
    }

    public function orderSummary($id, $address, $type, $coupon, Request $request) {
        if ($request->ajax()) {
            if (Auth::check()) {
                $get = Address::where(['user_id' => auth()->user()->id, 'id' => $address])->first() ;

                if ($get == NULL) {
                    return view("user.ajax.404");
                }else {
                    if (($type == 'cash') || ($type == 'card')) {
                        $vendor = Vendors::where(['id' => $id])->first();

                        if ($vendor != null) {
                            if((date("H.i") < $vendor->opening) || (date("H.i") >= $vendor->closing)) {
                                return response()->json(['errors'=>['Vendor is closed'], 'stock' => true, 'vendor' => $vendor->id]);
                            }
                            $carts = Cart::where(['user_id' => auth()->user()->id, 'vendor_id' => $vendor->id])->orderBy('id', 'desc')->get() ;

                            if ($carts->count() >= 1) {
                                $order_total = 0 ;
                                $stock = true ;
                                foreach ($carts as $cart) {
                                    $order_total = $order_total + ($cart->price * $cart->quantity);
                                    $getMenu = Menus::where(['id' => $cart->menu_id, 'stock' => 0])->first();
                                    if($getMenu != NULL) {
                                        Cart::where(['user_id' => auth()->user()->id, 'menu_id' => $cart->menu_id])->delete();
                                        $stock = false;
                                    }
                                }

                                if ($stock == false) {
                                    return response()->json(['errors'=>['At least one item in your cart is out of stock, your cart is being updated please wait'], 'stock' => false, 'vendor' => $vendor->id]);
                                }
                                if($coupon == "null") {
                                    $total = $vendor->delivery_charge + $vendor->tax + $vendor->vendor_charge + $order_total;

                                                $data = array(
                                                    'carts' => $carts,
                                                    'order_total' => $order_total,
                                                    'total' => $total,
                                                    'vendor' => $vendor,
                                                    'address' => $get,
                                                    'type' => $type,
                                                    'coupon' => NULL,
                                                );
                                    return view("user.ajax.order_summary")->with($data);
                                }else {
                                    $date = Carbon::today();
                                    $getCoupon = Coupon::where('code','=',$coupon)->whereDate('expire', '>=', $date)->first();
                                    if ($getCoupon != NULL) {
                                        if(($getCoupon->vendor_id != NULL) && ($getCoupon->vendor_id != $vendor->id)) {
                                            return response()->json(['errors'=>['Coupon does not apply to this vendor'], 'stock' => true, 'vendor' => $vendor->id]);
                                        }
                                        $checkUser = Order::where(['user_id' => auth()->user()->id])->get();
                                        if ($getCoupon->count == 0) {
                                            if ($checkUser->count() >= 1) {
                                                return response()->json(['errors'=>['Coupon only applies to first time users']]);
                                            }
                                            $getTotal = $vendor->delivery_charge + $vendor->tax + $vendor->vendor_charge + $order_total - $getCoupon->amount ;
                                                if($getTotal < 0) {
                                                    $total = 0 ;
                                                }else {
                                                    $total = $getTotal ;
                                                }
                                                $data = array(
                                                    'carts' => $carts,
                                                    'order_total' => $order_total,
                                                    'total' => $total,
                                                    'vendor' => $vendor,
                                                    'address' => $get,
                                                    'type' => $type,
                                                    'coupon' => $getCoupon,
                                                );
                                            return view("user.ajax.order_summary")->with($data);
                                        } else {
                                            if ($checkUser->count() >= $getCoupon->count) {
                                                return response()->json(['errors'=>['Coupon max reached']]);
                                            }

                                            $getTotal = $vendor->delivery_charge + $vendor->tax + $vendor->vendor_charge + $order_total - $getCoupon->amount ;
                                                if($getTotal < 0) {
                                                    $total = 0 ;
                                                }else {
                                                    $total = $getTotal ;
                                                }
                                                $data = array(
                                                    'carts' => $carts,
                                                    'order_total' => $order_total,
                                                    'total' => $total,
                                                    'vendor' => $vendor,
                                                    'address' => $get,
                                                    'type' => $type,
                                                    'coupon' => $getCoupon,
                                                );
                                            return view("user.ajax.order_summary")->with($data);
                                        }
                                    }else {
                                        return response()->json(['errors'=>['Expired or invalid Coupon'], 'stock' => true, 'vendor' => $vendor->id]);
                                    }
                                }
                            } else {
                                return response()->json(['errors'=>['Cart for this vendor is empty'], 'stock' => true, 'vendor' => $vendor->id]);
                            }

                        }else {
                            return view("user.ajax.404");
                        }
                    } else {
                        return view("user.ajax.404");
                    }
                }
            }
        }
    }

    public function checkCoupon(Request $request) {
        if ($request->ajax()) {
            if (Auth::check()) {
                $validatedData = Validator::make($request->all(), [
                    'coupon' => 'required',
                ]);

                if ($validatedData->fails())
                {
                    return response()->json(['errors'=>$validatedData->errors()->all()]);
                }else {
                    $date = Carbon::today();
                    $coupon = Coupon::where('code','=',$request->coupon)->whereDate('expire', '>=', $date)->first();
                    if ($coupon != NULL) {
                        if(($coupon->vendor_id != NULL) && ($coupon->vendor_id != $request->vendor)) {
                            return response()->json(['errors'=>['Coupon does not apply to this vendor']]);
                        }else {
                            $checkUser = Order::where(['user_id' => auth()->user()->id])->get();
                            if ($coupon->count == 0) {
                                if ($checkUser->count() >= 1) {
                                    return response()->json(['errors'=>['Coupon only applies to first time users']]);
                                }
                                return response()->json(['errors'=>NULL, 'amount' => $coupon->amount, 'coupon' => $coupon->code, 'message' => 'Coupon Applied']);
                            } else {
                                if ($checkUser->count() >= $coupon->count) {
                                    return response()->json(['errors'=>['Coupon max reached']]);
                                }
                                return response()->json(['errors'=>NULL, 'amount' => $coupon->amount, 'coupon' => $coupon->code, 'message' => 'Coupon Applied']);
                            }
                        }
                    }else {
                        return response()->json(['errors'=>['Expired or invalid Coupon']]);
                    }
                }
            }
        }

    }

    public function myOrderSummary($no, Request $request) {
        if ($request->ajax()) {
            if (Auth::check()) {

                $order = Order::where(['order_no' => $no])->first();

                if ($order != NULL) {
                    $vendor = Vendors::findOrFail($order->vendor_id);
                    $address = Address::findOrFail($order->address);
                    $order_items = Order_item::where(['order_no' => $no])->get();
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
                    );

                    return view('user.ajax.myorder_summary')->with($data);
                }

            }
        }
    }

    public function editAddresssForm($id, Request $request) {
        if ($request->ajax()) {
            if (Auth::check()) {
                $address = Address::where(['user_id' => auth()->user()->id, 'id' => $id])->first();
                $user = Customer::where(['user_id' => auth()->user()->id])->first() ;
                if($address == NULL) {
                    return response()->json(['errors'=>['Invalid Address']]);
                }else {
                    return view('user.ajax.edit_address')->with(['address' => $address, 'user' => $user]);
                }
            }else {
                return response()->json(['errors'=>['Session Expired, Sign In']]);
            }
        }
    }

    public function editAddresss(Request $request) {
        if ($request->ajax()) {
            if (Auth::check()) {
                $validatedData = Validator::make($request->all(), [
                    'address' => 'required',
                ]);

                if ($validatedData->fails())
                {
                    return response()->json(['errors'=>$validatedData->errors()->all()]);
                }else {
                    $get = Address::where(['user_id' => auth()->user()->id, 'id' => $request->id]);
                    if($get->first() == NULL) {
                        return response()->json(['errors'=>['Invalid Address']]);
                    }else {
                        $edit = $get->update([
                            'address' => $request->address,
                            'description' => $request->description,
                            'phone' => $request->phone,
                        ]);

                        if($edit) {
                            return response()->json(['errors'=>NULL, 'message' => 'Address edited successfully']);
                        }else {
                            return response()->json(['errors'=>['Error editing Address']]);
                        }
                    }
                }
            }else {
                return response()->json(['errors'=>['Session Expired, Sign In']]);
            }
        }
    }

    public function deleteAddresss($id, Request $request) {
        if ($request->ajax()) {
            if (Auth::check()) {

                $get = Address::where(['user_id' => auth()->user()->id, 'id' => $id]);
                if($get->first() == NULL) {
                    return response()->json(['errors'=>['Invalid Address']]);
                }else {
                    $user = Customer::where(['user_id' => auth()->user()->id])->first() ;
                    if ($user->address_id == $id) {
                        Customer::where(['user_id' => auth()->user()->id])->update(['address_id' => NULL]) ;
                        $delete = Address::where(['id' => $id])->delete();
                    }else {
                        $delete = Address::where(['id' => $id])->delete();
                    }

                    if($delete) {
                        return response()->json(['errors'=>NULL, 'message' => 'Address deleted successfully']);
                    }else {
                        return response()->json(['errors'=>['Error deleting Address']]);
                    }
                }

            }else {
                return response()->json(['errors'=>['Session Expired, Sign In']]);
            }
        }
    }

    public function makeDefaultAddresss($id, Request $request) {
        if ($request->ajax()) {
            if (Auth::check()) {

                $get = Address::where(['user_id' => auth()->user()->id, 'id' => $id]);
                if($get->first() == NULL) {
                    return response()->json(['errors'=>['Invalid Address']]);
                }else {
                    Address::where(['user_id' => auth()->user()->id, 'default' => 1])->update([
                        'default' => NULL,
                    ]);
                    Customer::where(['user_id' => auth()->user()->id])->update(['address_id' => $id]) ;
                    $update = Address::where(['user_id' => auth()->user()->id, 'id' => $id])->update([
                        'default' => 1,
                    ]);

                    if($update) {
                        return response()->json(['errors'=>NULL, 'message' => 'Address updated successfully']);
                    }else {
                        return response()->json(['errors'=>['Error updating Address']]);
                    }
                }

            }else {
                return response()->json(['errors'=>['Session Expired, Sign In']]);
            }
        }
    }

    public function favouriteVendor($id, Request $request) {
        if ($request->ajax()) {
            if (Auth::check()) {

                $fav = Favourite_vendor::where(['user_id' => auth()->user()->id, 'vendor_id' => $id]);

                if($fav->first() == NULL) {
                    $query = Favourite_vendor::insert([
                        'user_id' => auth()->user()->id,
                        'vendor_id' => $id,
                    ]);
                    return response()->json(['errors'=>NULL, 'message' => 'Vendor has been added to favourites', 'status' => true]);
                }else {
                    $query = $fav->delete();
                    return response()->json(['errors'=>NULL, 'message' => 'Vendor has been removed from favourites', 'status' => false]);
                }

            }
        }
    }

    public function editProfile(Request $request) {
        if ($request->ajax()) {
            if (Auth::check()) {
                $validatedData = Validator::make($request->all(), [
                    'file' => 'image|max:1999',
                    'firstname' => 'required',
                    'lastname' => 'required',
                    'phone' => 'required',
                ]);

                if ($validatedData->fails())
                {
                    return response()->json(['errors'=>$validatedData->errors()->all()]);
                }else {
                    if ($request->hasFile('file')) {

                        $extension = $request->file('file')->getClientOriginalExtension();
                        $filename = auth()->user()->id.'_image_'.time().'.'.$extension ;
                        $image_path = $request->file('file')->storeAs('public/user', $filename) ;
                        if($image_path) {
                            $update = Customer::where(['user_id' => auth()->user()->id])->update([
                                'firstname' => $request->firstname,
                                'lastname' => $request->lastname,
                                'phone' => $request->phone,
                                'image' => asset('storage/user/'.$filename),
                            ]);
                        }else {
                            $update = false ;
                        }
                    }else {
                        $update = Customer::where(['user_id' => auth()->user()->id])->update([
                            'firstname' => $request->firstname,
                            'lastname' => $request->lastname,
                            'phone' => $request->phone,
                        ]);
                    }

                    if ($update) {
                        return response()->json(['errors'=>NULL, 'message' => 'Profile has been updated']);
                    }else {
                        return response()->json(['errors'=>['Could not update profile']]);
                    }
                }
            }
        }
    }

    public function changePassword(Request $request) {
        if ($request->ajax()) {
            if (Auth::check()) {
                if (!(Hash::check($request->old, auth()->user()->password))) {
                    return response()->json(['errors'=>['Old Password is incorrect']]);
                }else {
                    if(strcmp($request->old, $request->password) == 0) {
                        return response()->json(['errors'=>['New Password cannot be same as your current Password. Please Choose a different Password']]);
                    }else {
                        $validatedData = Validator::make($request->all(), [
                            'old' => 'required',
                            'password' => 'required|string|min:4|confirmed',
                        ]);

                        if ($validatedData->fails()) {
                            return response()->json(['errors'=>$validatedData->errors()->all()]);
                        }else {
                            $query = User::where('id','=',auth()->user()->id)->update(['password' => bcrypt($request->password)]);

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
    }

}
