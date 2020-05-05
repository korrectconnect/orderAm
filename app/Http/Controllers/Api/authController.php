<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class authController extends Controller
{

 public function register(Request $request)
 {
     //
     $validatedData = $request->validate([
         'firstname' => 'max:55|required',
         'lastname' => 'max:55|required',
         'email' => 'email|required|unique:users',
         'password' => 'confirmed|required'
     ]);

     $validatedData['password'] = bcrypt($validatedData['password']);

     $user = User::create($validatedData);

     $accessToken = $user->createToken('authToken')->accessToken;

     return response(['user' => $user, 'access_token' => $accessToken ]);
 }

 public function login(Request $request)
 {
     //
     $loginData = $request->validate([
        'password' => 'required',
        'email' => 'email|required'
    ]);

    if(!auth()->attempt($loginData)) {
        return response(['message' => 'Invalid Credentials']);
    };

    $accessToken = auth()->user()->createToken('authToken')->accessToken;

    return response(['user' => auth()->user(), 'access_token' => $accessToken ]);

 }

}
