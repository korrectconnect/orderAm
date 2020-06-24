<?php

namespace App\Http\Controllers;

use App\AdminModel;
use App\Location;
use App\Order;
use App\Rider;
use App\Rider_category;
use App\Vendor_auth;
use App\Vendor_category;
use App\Vendors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //
    public function __construct()
    {
       $this->middleware('admin');
    }

    public function dashboard() {
        $vendors = AdminModel::allVendors();
        $menus = AdminModel::getAllMenus();

        $data = array(
            'vendors' => $vendors,
            'menus' => $menus
        );

        return view('admin.pages.homepage')->with($data);
    }

    public function addVendorForm() {
        $categories = Vendor_category::all() ;
        $states = Location::where('type','=','state')->get();
        $countries = Location::where('type','=','country')->get();
        $lgas = Location::where('type','=','lga')->get();
        $areas = Location::where('type','=','area')->get();

        $data = array(
            'categories' => $categories,
            'states' => $states,
            'countries' => $countries,
            'lgas' => $lgas,
            'areas' => $areas,
        );

        return view('admin.pages.vendor.add')->with($data);
    }

    public function addRiderForm() {
        $categories = Rider_category::all() ;

        $data = array(
            'categories' => $categories,
        );

        return view('admin.pages.rider.add')->with($data);
    }

    public function ridersLocation() {
        $states = Location::where('type','=','state')->get();
        $lgas = Location::where('type','=','lga')->get();

        $locations = Location::leftJoin('riders','riders.location_assigned','=','location.name')
                    ->select('location.*',DB::raw('count(riders.location_assigned) as location_assigned'))
                    ->where([['location.type','=','Lga']])
                    ->groupBy('location.name')->orderBy('location_assigned','desc')->get() ;

        $data = array(
            'states' => $states,
            'lgas' => $lgas,
            'locations' => $locations,
        );

        return view('admin.pages.rider.location')->with($data);
    }

    public function riderCategory() {
        $categories = Rider_category::all() ;

        $data = array(
            'categories' => $categories,
        );

        return view('admin.pages.rider.category')->with($data);
    }

    public function vendors() {
        $query = AdminModel::allVendors();
        $data = array(
            'query' => $query
        );
        return view('admin.pages.vendor.view')->with($data);
    }

    public function vendorAuth($id) {
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $account_id = substr(str_shuffle($str_result), 0, 6);
        $secret = substr(str_shuffle($str_result), 0, 6);
        $get = Vendor_auth::where(['vendor_id' => $id]);
        if ($get->first() >= 1) {
            $query = $get->update([
                'account_id' => $account_id,
                'secret' => encrypt($secret),
                'password' => bcrypt(123456),
            ]);
        }else {
            $query = Vendor_auth::insert([
                'vendor_id' => $id,
                'account_id' => $account_id,
                'secret' => encrypt($secret),
                'password' => bcrypt(123456),
            ]);
        }

        if ($query) {
            return redirect()->back();
        }
    }

    public function vendor($id) {
        $vendor = AdminModel::getVendor($id);
        $menus = AdminModel::getMenus($id);
        $categories = AdminModel::getMenuCategory($id);

        $data = array(
            'vendor' => $vendor,
            'menus' => $menus,
            'categories' => $categories
        );

        return view('admin.pages.vendor.single')->with($data);
    }

    public function menus() {
        //
        $vendors = AdminModel::allVendors();
        $menus = AdminModel::getAllMenus();

        $data = array(
            'vendors' => $vendors,
            'menus' => $menus
        );
        return view('admin.pages.menus.home')->with($data);
    }

    public function menu($id) {
        //
        $vendor = AdminModel::getVendor($id);
        $menus = AdminModel::getMenus($id);
        $categories = AdminModel::getMenuCategory($id);

        $data = array(
            'vendor' => $vendor,
            'menus' => $menus,
            'categories' => $categories
        );
        return view('admin.pages.menus.view')->with($data);
    }

    public function vendorCategory() {
        $categories = Vendor_category::all() ;

        $data = array(
            'categories' => $categories,
        );
        return view('admin.pages.vendor.category')->with($data);
    }

    public function location() {
        $locations = Location::all() ;

        $data = array(
            'locations' => $locations,
        );

        return view('admin.pages.vendor.location')->with($data);
    }

    public function orders() {
        $orders = DB::table('order')->join('vendors','vendors.id','=','order.vendor_id')->select('order.*','vendors.name','vendors.lga')->where('order.cancelled','=','0')->orderBy('order.created_at', 'desc')->get() ;

        $data = array(
            'orders' => $orders,
        );

        return view('admin.pages.orders')->with($data);
    }

    public function riders() {
        $riders = Rider::orderBy('firstname', 'asc')->get();

        $data = array(
            'riders' => $riders,
        );

        return view('admin.pages.rider.view')->with($data);
    }

    public function singleRider($id) {
        $rider = Rider::where(['id' => $id])->first();

        if ($rider != NULL) {
            $data = array(
                'rider' => $rider,
            );

            return view('admin.pages.rider.single')->with($data);
        }
    }

}
