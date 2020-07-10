<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Rider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class authController extends Controller
{

 public function register(Request $request)
 {
     //
     $validatedData = Validator::make($request->all(), [
         'firstname' => 'max:55|required',
         'lastname' => 'max:55|required',
         'phone' => 'required',
         'email' => 'email|required|unique:users',
         'password' => 'required|string|min:6|confirmed'
     ]);

    if ($validatedData->fails()) {
        return response()->json(['status' => 400, 'errors'=>$validatedData->errors()->all()]);
    }else {

        $insert = User::insert([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'customer',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $getUser = User::where(['email' => $request->email])->first();
        $insert_c = Customer::insert([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'phone' => $request->phone,
            'user_id' => $getUser->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            //$user = User::create($validatedData);

            $accessToken = auth()->user()->createToken('authToken')->accessToken;

            $user = User::join('customers','customers.user_id','=','users.id')
                            ->select('users.*','customers.firstname','customers.lastname','customers.address_id','customers.image')
                            ->where(['users.id' => auth()->user()->id])
                            ->first();
            return response(['user' => $user, 'access_token' => $accessToken ]);
        }else {
            return response()->json(['errors'=>['Could not log you in automatically, try login in manually']]);
        }

    }
 }

 public function login(Request $request)
 {
     //
     $loginData = $request->validate([
        'password' => 'required',
        'email' => 'email|required'
    ]);

    $getUser = User::where(['email' => $request->email])->first();
    if($getUser != NULL) {
        if ($getUser->role != 'customer') {
            return response(['message' => 'Invalid Credentials']);
        }
    }

    if(!auth()->attempt($loginData)) {
        return response(['message' => 'Invalid Credentials']);
    };

    $accessToken = auth()->user()->createToken('authToken')->accessToken;

    $user = User::join('customers','customers.user_id','=','users.id')
                            ->select('users.*','customers.firstname','customers.lastname','customers.address_id','customers.image')
                            ->where(['users.id' => auth()->user()->id])
                            ->first();
    return response(['user' => $user, 'access_token' => $accessToken ]);

 }


 public function loginRider(Request $request)
 {
    $loginData = $request->validate([
        'password' => 'required',
        'username' => 'required'
    ]);

    $getUser = User::where(['username' => $request->username])->first();
    if($getUser != NULL) {
        if ($getUser->role != 'rider') {
            return response(['message' => 'Invalid Credentials']);
        }
    }

    if(!auth()->attempt($loginData)) {
        return response(['message' => 'Invalid Credentials']);
    };

    $accessToken = auth()->user()->createToken('authToken')->accessToken;

    $rider = Rider::join('users','users.id','=','riders.user_id')
                            ->select('riders.*','users.email','users.username')
                            ->where(['riders.user_id' => auth()->user()->id])
                            ->first();
    return response(['rider' => $rider, 'access_token' => $accessToken ]);

 }

}
