<?php

namespace App\Http\Controllers;

use App\Customer;
use App\User;
use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rider;
use App\Rider_order;
use App\Services\GoogleMaps;
use Illuminate\Support\Facades\DB;
use Stevebauman\Location\Facades\Location;

class RidersController extends Controller
{
    public function getRiderProfile()
    {
        $rider = auth()->user()->rider;
        return response()->json($rider);
    }

    public function getClientInfo($order_id)
    {
        $order = Order::find($order_id);
        $client = Customer::find($order->user_id);

        return response()->json($client);
    }

    public function getOrderInfo($order_id)
    {
        $order = Order::find($order_id);
        
        return response()->json($order);
    }

    public function getRiderOrder($order_no, $rider_id)
    {
        $order = Rider_order::where('order_id', $order_no)->where('rider_id', $rider_id)->first();

        return response()->json($order);
    }

    public function getRiderConfirmedOrder($order_no, $rider_id)
    {
        $order = Rider_order::where('order_id', $order_no)->where('rider_id', $rider_id)->where('confirm', 1)->first();

        return response()->json($order);
    }

    public function getAllRiderOrders($rider_id)
    {
        $orders = DB::table('rider_orders')->where('rider_id', $rider_id)->get();
        return response()->json($orders);
    }

    public function getAllRiderConfirmedOrders($rider_id)
    {
        $orders = Rider_order::where('rider_id', $rider_id)->where('confirm', 1)->get();

        return response()->json($orders);
    }
}
