<?php

namespace App\Http\Controllers;

use App\Menu_category;
use App\Menus;
use App\Order;
use App\Vendors;
use Illuminate\Http\Request;

class VendorController extends Controller
{

    // private $vendor ;
    // private $id ;

    // public function __construct()
    // {
    //     $this->id = auth()->guard('vendor')->user()->vendor_id;
    //     $this->vendor = Vendors::where(['id' => $this->id])->first();
    // }

    public function dashboard(Request $request) {
        if($request->session()->has('vendor_secret')) {
            if(decrypt($request->session()->get('vendor_secret')) == decrypt(auth()->guard('vendor')->user()->secret)) {
                $auth = true ;
            }else {
                $request->session()->forget('vendor_secret');
                $auth = false ;
            }
        }else {
            $auth = false;
        }
        $vendor_id = auth()->guard('vendor')->user()->vendor_id ;
        $vendor = Vendors::where(['id' => $vendor_id])->first();
        $orders = Order::where(['vendor_id' => $vendor_id, 'status' => 0, 'cancelled' => 0])->get();

        $data = array(
            'vendor' => $vendor,
            'orders' => $orders,
            'auth' => $auth,
        );

        return view('vendor.pages.index')->with($data);
    }

    public function menus(Request $request) {
        if($request->session()->has('vendor_secret')) {
            if(decrypt($request->session()->get('vendor_secret')) == decrypt(auth()->guard('vendor')->user()->secret)) {
                $auth = true ;
            }else {
                $request->session()->forget('vendor_secret');
                $auth = false ;
            }
        }else {
            $auth = false;
        }

        $vendor_id = auth()->guard('vendor')->user()->vendor_id ;
        $vendor = Vendors::where(['id' => $vendor_id])->first();
        $menus = Menus::where(['vendor_id' => $vendor_id])->get();
        $menu_categories = Menu_category::where(['vendor_id' => $vendor_id])->get();

        $data = array(
            'vendor' => $vendor,
            'menus' => $menus,
            'menu_categories' => $menu_categories,
            'auth' => $auth,
        );

        return view('vendor.pages.menus')->with($data);
    }

    public function profile(Request $request) {
        if($request->session()->has('vendor_secret')) {
            if(decrypt($request->session()->get('vendor_secret')) == decrypt(auth()->guard('vendor')->user()->secret)) {
                $auth = true ;
            }else {
                $request->session()->forget('vendor_secret');
                $auth = false ;
            }
        }else {
            $auth = false;
        }
        $vendor_id = auth()->guard('vendor')->user()->vendor_id ;
        $vendor = Vendors::where(['id' => $vendor_id])->first();

        $data = array(
            'vendor' => $vendor,
            'auth' => $auth,
        );

        return view('vendor.pages.profile')->with($data);
    }

    public function password(Request $request) {
        if($request->session()->has('vendor_secret')) {
            if(decrypt($request->session()->get('vendor_secret')) == decrypt(auth()->guard('vendor')->user()->secret)) {
                $auth = true ;
            }else {
                $request->session()->forget('vendor_secret');
                return redirect()->route('vendor.authAdmin');
            }
        }else {
            return redirect()->route('vendor.authAdmin');
        }
        $vendor_id = auth()->guard('vendor')->user()->vendor_id ;
        $vendor = Vendors::where(['id' => $vendor_id])->first();

        $data = array(
            'auth' => $auth,
            'vendor' => $vendor,
        );

        return view('vendor.pages.password')->with($data);
    }

    public function finances(Request $request) {
        if($request->session()->has('vendor_secret')) {
            if(decrypt($request->session()->get('vendor_secret')) == decrypt(auth()->guard('vendor')->user()->secret)) {
                $auth = true ;
            }else {
                $request->session()->forget('vendor_secret');
                return redirect()->route('vendor.authAdmin');
            }
        }else {
            return redirect()->route('vendor.authAdmin');
        }
        $vendor_id = auth()->guard('vendor')->user()->vendor_id ;
        $vendor = Vendors::where(['id' => $vendor_id])->first();

        $data = array(
            'auth' => $auth,
            'vendor' => $vendor,
        );

        return view('vendor.pages.finances')->with($data);
    }

    public function authAdmin(Request $request) {
        if($request->session()->has('vendor_secret')) {
            if(decrypt($request->session()->get('vendor_secret')) == decrypt(auth()->guard('vendor')->user()->secret)) {
                $auth = true ;
            }else {
                $request->session()->forget('vendor_secret');
                $auth = false ;
            }
        }else {
            $auth = false;
        }
        $vendor_id = auth()->guard('vendor')->user()->vendor_id ;
        $vendor = Vendors::where(['id' => $vendor_id])->first();

        $data = array(
            'vendor' => $vendor,
            'auth' => $auth,
        );

        return view('vendor.pages.auth')->with($data);
    }

    public function authenticateAdmin(Request $request) {
        $vendor_id = auth()->guard('vendor')->user()->vendor_id ;
        $secret = auth()->guard('vendor')->user()->secret ;

        if ($request->secret == decrypt($secret)) {
            $request->session()->put('vendor_secret',encrypt($request->secret));
            return redirect()->back();
        }else {
            $request->session()->flash('errors', 'Pin Incorrect');
            $request->session()->flash('alert-type', 'error');
            return redirect()->back();
        }
    }

    public function authenticateAdminLogout(Request $request) {
        $vendor_id = auth()->guard('vendor')->user()->vendor_id ;

        $request->session()->forget('vendor_secret');
        return redirect()->back();
    }
}
