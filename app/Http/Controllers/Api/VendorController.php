<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppResource;
use App\Menu_category;
use App\Menus;
use App\Order;
use App\User;
use App\Vendors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{

    public function addMenu(Request $request)
    {
        $vendor = Vendors::where(['user_id' => auth()->user()->id])->first();
        $validatedData = Validator::make($request->all(), [
            'name' => 'max:55|required',
            'cover' => 'required|image|max:1999',
            'description' => 'max:250|required',
            'price' => 'max:250|required',
            'category' => 'max:250|required',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()->all()], 400);
        } else {
            if ($request->hasFile('cover')) {

                $extension = $request->file('cover')->getClientOriginalExtension();
                $filename = $request->name . '_' . $vendor->id . '_' . time() . '.' . $extension;
                $path = $request->file('cover')->storeAs('public/menu', $filename);

                $category = Menu_category::where(['vendor_id' => $vendor->id, 'category' => $request->category])->first();

                if ($path) {
                    $query = Menus::insert([
                        'vendor_id' => $vendor->id,
                        'menu' => $request->name,
                        'description' => $request->description,
                        'category' => $request->category,
                        'price' => $request->price,
                        'image' => asset('storage/menu/' . $filename),
                        'stock' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    if ($query) {
                        return response()->json(['message' => 'Uploaded Successfully'], 200);
                    }
                    return response()->json(['errors' => ['Server error try again']], 400);
                }
                return response()->json(['errors' => 'Error uploading file'], 400);
            } else {

                return response()->json(['errors' => 'No file Selected'], 400);
            }
        }
    }


    public function addMenuCategory(Request $request)
    {
        $vendor = Vendors::where(['user_id' => auth()->user()->id])->first();
        $validatedData = Validator::make($request->all(), [
            'category' => 'max:20|required',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()->all()], 400);
        } else {

            $get = Menu_category::where(['vendor_id' => $vendor->id, 'category' => $request->category])->first();

            if ($get == NULL) {
                $query = Menu_category::insert([
                    'vendor_id' => $vendor->id,
                    'category' => $request->category,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                if ($query) {
                    return response()->json(['message' => 'Menu Category added Successfully'], 200);
                }
                return response()->json(['errors' => ['Server error try again']], 400);
            }
            return response()->json(['errors' => ['Menu category already exist']], 400);
        }
    }


    public function editMenuCategory(Request $request)
    {
        $vendor = Vendors::where(['user_id' => auth()->user()->id])->first();
        $validatedData = Validator::make($request->all(), [
            'category' => 'max:20|required',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()->all()], 400);
        } else {

            $get = Menu_category::where(['vendor_id' => $vendor->id, 'category' => $request->category])->first();

            if ($get == NULL) {
                $query = Menu_category::where(['id' => $request->id])->update([
                    'category' => $request->category,
                    'updated_at' => now(),
                ]);
                if ($query) {
                    return response()->json(['message' => 'Menu Category updated Successfully'], 200);
                }
                return response()->json(['errors' => ['Server error try again']], 400);
            }
            return response()->json(['errors' => ['Menu category already exist']], 400);
        }
    }

    public function editMenu(Request $request)
    {
        $vendor = Vendors::where(['user_id' => auth()->user()->id])->first();
        $validatedData = Validator::make($request->all(), [
            'name' => 'max:55|required',
            'cover' => 'image|max:1999',
            'description' => 'max:250|required',
            'price' => 'max:10|required',
            'category' => 'max:250|required',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()->all()], 400);
        } else {
            $category = Menu_category::where(['vendor_id' => $vendor->id, 'category' => $request->category])->first();
            if ($request->hasFile('cover')) {

                $extension = $request->file('cover')->getClientOriginalExtension();
                $filename = $request->name . '_' . $vendor->id . '_' . time() . '.' . $extension;
                $path = $request->file('cover')->storeAs('public/menu', $filename);

                if ($path) {
                    $query = Menus::where(['vendor_id' => $vendor->id, 'id' => $request->id])->update([
                        'menu' => $request->name,
                        'description' => $request->description,
                        'category' => $request->category,
                        'price' => $request->price,
                        'image' => asset('storage/menu/' . $filename),
                        'updated_at' => now(),
                    ]);
                } else {
                    return response()->json(['errors' => ['Error uploading file']], 400);
                }
            } else {

                $query = Menus::where(['vendor_id' => $vendor->id, 'id' => $request->id])->update([
                    'menu' => $request->name,
                    'description' => $request->description,
                    'category' => $request->category,
                    'price' => $request->price,
                    'updated_at' => now(),
                ]);
            }

            if ($query) {
                return response()->json(['message' => 'Edited Successfully'], 200);
            }
            return response()->json(['errors' => ['Server error try again']], 400);
        }
    }

    public function getMenu()
    {
        $vendor = Vendors::where(['user_id' => auth()->user()->id])->first();
        $query = Menus::join('vendors', 'menus.vendor_id', '=', 'vendors.id')->select('menus.*', 'vendors.name')->where([['menus.vendor_id', '=', $vendor->id]])->orderBy('created_at', 'desc')->get();

        return AppResource::collection($query);
    }

    public function getMenuByCategory($category)
    {
        if ($category == 'NULL' || $category == 'null') {
            $category = NULL ;
        }

        $vendor = Vendors::where(['user_id' => auth()->user()->id])->first();
        $query = Menus::join('vendors', 'menus.vendor_id', '=', 'vendors.id')->select('menus.*', 'vendors.name')->where([['menus.category', '=', $category], ['menus.vendor_id', '=', $vendor->id]])->orderBy('created_at', 'desc')->get();

        return AppResource::collection($query);
    }

    public function getMenuCategory()
    {
        $vendor = Vendors::where(['user_id' => auth()->user()->id])->first();
        $query =  Menu_category::where('vendor_id', '=', $vendor->id)->get();

        return AppResource::collection($query);
    }

    public function deleteMenu($id)
    {
        $delete = Menus::where(['id' => $id])->delete();
        if ($delete) {
            return response()->json(['message' => 'Menu deleted Successfully'], 200);
        }
        return response()->json(['errors' => ['Server error try again']], 400);
    }

    public function deleteMenuCategory($id)
    {
        $vendor = Vendors::where(['user_id' => auth()->user()->id])->first();
        $category = Menu_category::where(['id' => $id, 'vendor_id' => $vendor->id]);
        if ($category->first() != NULL) {

            $name = $category->first()->category;
            $delete = $category->delete();
            if ($delete) {
                $menu = Menus::where(['vendor_id' => $vendor->id, 'category' => $name]);
                $countMenu = $menu->count();
                $menu->update([
                    'category' => NULL,
                ]);

                return response()->json(['message' => 'Menu Category deleted Successfully and (' . $countMenu . ') menu items has been moved to the UNSORTED list'], 200);
            } else {
                return response()->json(['errors' => ['Error, could not delete Menu category']], 400);
            }
        } else {
            return response()->json(['errors' => ['Invalid Menu category']], 400);
        }
    }

    public function getOrders()
    {
        $vendor = Vendors::where(['user_id' => auth()->user()->id])->first();

        $query = Order::where(['vendor_id' => $vendor->id])->get();
        return AppResource::collection($query);
    }

    public function getIncomingOrders()
    {
        $vendor = Vendors::where(['user_id' => auth()->user()->id])->first();

        $query = Order::where(['vendor_id' => $vendor->id, 'cancelled' => 0, 'status' => 0])->get();
        return AppResource::collection($query);
    }

    public function getPendingOrders()
    {
        $vendor = Vendors::where(['user_id' => auth()->user()->id])->first();

        $query = Order::where(['vendor_id' => $vendor->id, 'cancelled' => 0, 'status' => 1])->get();
        return AppResource::collection($query);
    }

    public function getDeliveredOrders()
    {
        $vendor = Vendors::where(['user_id' => auth()->user()->id])->first();

        $query = Order::where(['vendor_id' => $vendor->id, 'cancelled' => 0, 'status' => 2])->get();
        return AppResource::collection($query);
    }

    public function getCancelledOrders()
    {
        $vendor = Vendors::where(['user_id' => auth()->user()->id])->first();

        $query = Order::where(['vendor_id' => $vendor->id, 'cancelled' => 1])->get();
        return AppResource::collection($query);
    }

    public function getOrder($id)
    {
        $vendor = Vendors::where(['user_id' => auth()->user()->id])->first();

        $query = Order::where(['id' => $id])->get();
        return response()->json([$query], 200);
    }

    public function confirmOrders($id)
    {
        $vendor = Vendors::where(['user_id' => auth()->user()->id])->first();
        $order = Order::where(['id' => $id, 'vendor_id' => $vendor->id]);
        if ($order->first() != NULL) {
            $update = $order->update([
                'cancelled' => 0,
                'status' => 1,
            ]);

            if ($update) {
                return response()->json(['errors' => NULL, 'message' => 'Order has been confirmed. Pending delivery'], 200);
            } else {
                return response()->json(['errors' => ['Could not confirm, try again']], 400);
            }
        }
    }

    public function declineOrders($id)
    {
        $vendor = Vendors::where(['user_id' => auth()->user()->id])->first();
        $order = Order::where(['id' => $id, 'vendor_id' => $vendor->id]);
        if ($order->first() != NULL) {
            $update = $order->update([
                'cancelled' => 1,
                'status' => 2,
            ]);

            if ($update) {
                return response()->json(['errors' => NULL, 'message' => 'Order has been declined'], 200);
            } else {
                return response()->json(['errors' => ['Could not confirm, try again']], 400);
            }
        }
    }


    public function changePassword(Request $request)
    {
        $vendor = Vendors::where(['user_id' => auth()->user()->id])->first();

        if (!(Hash::check($request->old, auth()->user()->password))) {
            return response()->json(['errors' => ['Old Password is incorrect']]);
        } else {
            if (strcmp($request->old, $request->password) == 0) {
                return response()->json(['errors' => ['New Password cannot be same as your current Password. Please Choose a different Password']], 400);
            } else {
                $validatedData = Validator::make($request->all(), [
                    'old' => 'required',
                    'password' => 'required|string|min:6|confirmed',
                ]);

                if ($validatedData->fails()) {
                    return response()->json(['errors' => $validatedData->errors()->all()]);
                } else {
                    $query = User::where(['id' => auth()->user()->id, 'role' => 'vendor'])->update([
                        'password' => bcrypt($request->password),
                    ]);

                    if ($query) {
                        return response()->json(['errors' => null, 'message' => 'Password changed Successfully'], 200);
                    } else {
                        return response()->json(['errors' => ['Error !, try again later']], 400);
                    }
                }
            }
        }
    }
}
