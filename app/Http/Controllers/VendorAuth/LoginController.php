<?php

namespace App\Http\Controllers\VendorAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/vendorredirect/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }

    public function username()
    {
        return 'username';
    }

    protected function guard()
    {
        return auth()->guard('vendor');
    }

    public function logout(Request $request)
    {
        $this->guard('vendor')->logout();

        //$request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/vendorredirect/login');
    }

    public function showLoginForm()
    {
        return view('vendor-auth.login');
    }

}
