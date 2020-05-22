<?php

namespace App\Http\Controllers;

use App\Address;
use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\AppResource;
use App\Location;
use App\Vendors;
use App\Menus;
use App\User;
use App\Menu_category;
use App\Order;
use App\Order_item;
use App\Order_status;
use App\Vendor_category;

class ApiController extends Controller
{
    //
    public function editUser(Request $request) {
        $user = User::findOrFail(auth()->user()->id);

        $user->firstname = $request->firstname ;
        $user->lastname = $request->lastname ;
        $user->phone = $request->phone ;

        if($user->save()) {
            return new AppResource($user);
        }else {
            return response()->json(['status' => '400']);
        }
    }

    public function vendor($id) {
        $vendor = Vendors::findOrFail($id);

        return new AppResource($vendor);
    }

    public function vendors() {
        $vendors = Vendors::orderBy('id', 'desc')->get();

        return AppResource::collection($vendors);
    }

    public function getMenus($id) {
        $query = Menus::join('vendors', 'menus.vendor_id', '=', 'vendors.id')->select('menus.*', 'vendors.name')->where([['menus.vendor_id','=',$id]])->orderBy('created_at','desc')->get() ;

        return AppResource::collection($query);
    }

    public function getMenusByCategory($id,$category = null) {
        $query = Menus::join('vendors', 'menus.vendor_id', '=', 'vendors.id')->select('menus.*', 'vendors.name')->where([['menus.category','=',$category],['menus.vendor_id','=',$id]])->orderBy('created_at','desc')->get() ;

        return AppResource::collection($query);
    }

    public function getMenusCategory($id) {
        $query =  Menu_category::where('vendor_id','=',"$id")->get() ;

        return AppResource::collection($query);
    }

    public function searchVendors($key) {
        $search = Vendors::where('name','LIKE',"%$key%")->orderBy('id','desc')->get();

        return AppResource::collection($search);
    }

    public function searchVendorsByLocation(Request $request) {
        $search = Vendors::where([
            ['state','=',$request->state],
            ['lga','=',$request->lga],
            ['area','=',$request->area],
            ['type','=',$request->category],
        ])->get();

        return AppResource::collection($search);
    }

    public function makeOrder(Request $request) {
        $order = new Order;
        $order_no = auth()->user()->id.time().rand(0,100);

        $order->user_id = auth()->user()->id;
        $order->order_no = $order_no;
        $order->vendor_id = $request->vendor_id;
        $order->transaction_id = $request->transaction_id;
        $order->coupon_code = $request->coupon_code;
        $order->address = $request->address;
        $order->payment_mode = $request->payment_mode;
        $order->delivery_charge = $request->delivery_charge;
        $order->vendor_charge = $request->vendor_charge;
        $order->total = $request->total;
        $order->tax = $request->tax;
        $order->comment = $request->comment;
        $order->balance = $request->balance;
        $order->status = 0;
        $order->cancelled = 0;

        if($order->save()) {
            return new AppResource($order);
        }else {
            return response()->json(['status' => '400']);
        }
    }

    public function allOrder() {
        $order = Order::where('user_id',auth()->user()->id)->get();
        return AppResource::collection($order);
    }

    public function runningOrder() {
        $order = Order::where([['user_id','=',auth()->user()->id],['status','=',0]])->get();
        return AppResource::collection($order);
    }

    public function completedOrder() {
        $order = Order::where([['user_id','=',auth()->user()->id],['status','=',1]])->get();
        return AppResource::collection($order);
    }

    public function cancelOrder(Request $request) {
        $order = Order::where('order_no', $request->order_no)->update(['cancelled' => 1,'status' => 1]);
        $get = Order::where('order_no', $request->order_no)->first();

        return new AppResource($get);
    }

    public function insertOrderItem(Request $request) {
        $order_item = new Order_item;

        $order_item->order_no = $request->order_no ;
        $order_item->menu_id = $request->menu_id ;
        $order_item->quantity = $request->quantity ;
        $order_item->name = $request->name ;
        $order_item->price = $request->price ;

        if($order_item->save()) {
            return new AppResource($order_item);
        }else {
            return response()->json(['status' => '400']);
        }
    }

    public function insertOrderStatus(Request $request) {
        $order_status = new Order_status;

        $order_status->order_no = $request->order_no ;
        $order_status->status = $request->status ;

        if($order_status->save()) {
            return new AppResource($order_status);
        }else {
            return response()->json(['status' => '400']);
        }
    }

    public function saveAddress(Request $request) {
        $address = new Address ;

        $address->user_id = auth()->user()->id;
        $address->state = $request->state;
        $address->lga = $request->lga;
        $address->address = $request->address;
        $address->default = NULL ;

        if($address->save()) {
            return new AppResource($address);
        }else {
            return response()->json(['status' => '400']);
        }
    }

    public function setDefaultAddress(Request $request) {
        $updateAddressToNULL = DB::table('address')->update(['default' => NULL]);
        $user = DB::table('users')->where('id',auth()->user()->id)->update(['address_id' => $request->address_id]);
        $updateAddressDefault = Address::findOrFail($request->address_id);
        $updateAddressDefault->update(['default' => 1]);
        return new AppResource($updateAddressDefault);
    }

    public function getDefaultAddress() {
        $address = Address::where([['user_id','=',auth()->user()->id],['default','=',1]])->firstOrFail();

        return new AppResource($address);
    }

    public function getAddress() {
        $address = Address::where('user_id',auth()->user()->id)->get();
        return AppResource::collection($address);
    }

    public function deleteAddress(Request $request) {
        $address = Address::where([['user_id','=',auth()->user()->id],['id','=',$request->address_id]])->firstOrFail() ;
        $user = DB::table('users')->where('id',auth()->user()->id)->first();

        if ($address->delete()) {
            if($user->address_id == $address->id) {
                $updateUser = DB::table('users')->where('id',auth()->user()->id)->update(['address_id' => NULL]);
                return new AppResource($address);
            }


        }
    }

    public function test($id,$name) {
        $users =DB::table('users')->where('id',$id)->update(['firstname' => $name]);
        $user =DB::table('users')->where('id',$id)->first();
        echo $user->firstname." ".$user->lastname ;
    }

    public function addToCart(Request $request) {
        $get = Cart::where([['user_id','=',auth()->user()->id],['menu_id','=',$request->menu_id]])->first();

        if($get != null) {
            $quantity = $get->quantity + 1;
            $update = Cart::where([['menu_id','=',$request->menu_id],['user_id','=',auth()->user()->id]])->update(['quantity' => $quantity]);
            $getCart = Cart::where([['user_id','=',auth()->user()->id],['menu_id','=',$request->menu_id]])->first();
            return new AppResource($getCart);
        }else {
            $cart = new Cart ;
            $cart->user_id = auth()->user()->id;
            $cart->menu_id = $request->menu_id;
            $cart->quantity = 1;
            $cart->name = $request->name;
            $cart->price = $request->price;

            if ($cart->save()) {
                return new AppResource($cart);
            }else {
                return response()->json(['status' => '400']);
            }
        }
    }

    public function vendorsCategory() {
        $query = Vendor_category::all();

        return AppResource::collection($query);
    }

    public function cart() {
        $query = Cart::where('user_id','=',auth()->user()->id)->get();

        return AppResource::collection($query);
    }

    public function deleteCart($id) {
        $delete = Cart::where([['user_id','=',auth()->user()->id],['menu_id','=',$id]])->firstOrFail() ;

        if ($delete->delete()) {
            return new AppResource($delete);
        }else {
            return response()->json(['status' => '400']);
        }
    }

    public function clearCart() {
        $delete = Cart::where([['user_id','=',auth()->user()->id]])->delete() ;

        if ($delete) {
            return response()->json(['status' => '200']);
        }else {
            return response()->json(['status' => '400']);
        }
    }

    public function vendorsFeatured($limit) {
        $vendors = Vendors::all()->random($limit) ;

        return AppResource::collection($vendors);
    }

    public function state() {
        $query = Location::where('type','=','state')->get();

        return AppResource::collection($query);
    }

    public function lga() {
        $query = Location::where('type','=','lga')->get();

        return AppResource::collection($query);
    }

    public function area() {
        $query = Location::where('type','=','area')->get();

        return AppResource::collection($query);
    }

}
