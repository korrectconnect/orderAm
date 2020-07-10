<?php

namespace App\Http\Controllers;

use App\User;
use App\Messages;
use App\FCMNotification;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessagesController extends Controller
{
    public function sendMessage(Request $request)
    {
        $message = Messages::create([
            'from' => auth()->user()->id,
            'to' => $request->recipient_id,
            'body' => $request->body
        ]);

        broadcast(new MessageSent($message))->toOthers();
        $from = User::find(request()->user()->id);

        $notification = new FCMNotification();
        $notification->toSingleDeviceChat($from->remember_token, $from->name, $request->body, $from);

        return response()->json($message);
    }

    public function privateMessages($user_id)
    {
        $user = User::find($user_id);
        $privateMessages = Messages::with('user')
        ->where(['from'=> auth()->id(), 'to'=> $user->id])
        ->orWhere(function($query) use($user){
            $query->where(['from' => $user->id, 'to' => auth()->id()]);
        })
        ->get();

        return response()->json($privateMessages);
    }
}
