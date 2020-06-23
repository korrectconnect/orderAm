<?php

namespace App\Http\Controllers;

use App\User;
use App\Menus;
use App\Order;
use App\Vendors;
use App\ApiModel ;
use App\Order_item;
use App\Order_status;
use App\Menu_category;
use Illuminate\Http\Request;
use App\OrderLocationDetails;
use App\Http\Resources\AppResource;

class ApiController extends Controller
{
    //
    public function editUser($id, Request $request) {
        $user = User::findOrFail($id);

        $user->firstname = $request->firstname ;
        $user->lastname = $request->lastname ;
        $user->phone = $request->phone ;
        $user->address = $request->address ;

        if($user->save()) {
            return new AppResource($user);
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
        $order->status = $request->status;
        $order->cancelled = 0;

        $user_address = DB::table('address')->where('user_id', auth()->user()->id)->first();
        $vendor = DB::table('vendors')->find($request->vendor_id);

        $vendor_coordinates = GoogleMaps::getAddress($vendor->address);
        $user_coordinates = GoogleMaps::getAddress($user_address->address.' '.$user_address->lga.' '.$user_address->state);

        OrderLocationDetails::create([
            'order_id' => $order->id,
            'user_lat' => $user_coordinates['lat'],
            'user_long' => $user_coordinates['long'],
            'vendor_lat' => $vendor_coordinates['lat'],
            'vendor_long' => $vendor_coordinates['long'],
        ]);
        
        if($order->save()) {
            return new AppResource($order);
        }
    }

    public function cancelOrder(Request $request) {
        $order = Order::where('order_no', $request->order_no)->update(['cancelled' => 1]);
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
        }
    }

    public function insertOrderStatus(Request $request) {
        $order_status = new Order_status;

        $order_status->order_no = $request->order_no ;
        $order_status->status = $request->status ;

        if($order_status->save()) {
            return new AppResource($order_status);
        }
    }

    public function getDistance($order_id)
    {
        $order_details = OrderLocationDetails::find($order_id);
        
        $distance = GoogleMaps::getDistance($order_details->user_lat, $order_details->user_long, $order_details->vendor_lat, $order_details->vendor_long);

        return new AppResource($distance);
    }

    public function getDistanceRider($order_id)
    {
        $order_details = OrderLocationDetails::find($order_id);
        $rider_location = Location::get(request()->ip());
        $getUserDistance = GoogleMaps::getDistance($order_details->user_lat, $order_details->user_long, $order_details->vendor_lat, $order_details->vendor_long);
        $getVendorDistance = GoogleMaps::getDistance($order_details->vendor_lat, $order_details->vendor_long, $rider_location->latitude, $rider_location->longitude);

        $total_time = $getUserDistance['duration'] + $getVendorDistance;

        return response()->json(['total_time' => $total_time, 'getUserDistance' => $getUserDistance, 'getVendorDistance' => $getVendorDistance]);
    }
}
