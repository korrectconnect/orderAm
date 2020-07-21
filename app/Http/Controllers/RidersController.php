<?php

namespace App\Http\Controllers;

use App\Customer;
use App\User;
use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\GoogleMaps;
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
}
