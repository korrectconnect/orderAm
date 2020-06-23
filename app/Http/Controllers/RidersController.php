<?php

namespace App\Http\Controllers;

use App\User;
use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $user = User::find($order->user_id);

        return response()->json($user);
    }

    public function getOrderInfo($order_id)
    {
        $order = Order::find($order_id);
        
        return response()->json($order);
    }
}
