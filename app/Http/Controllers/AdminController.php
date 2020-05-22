<?php

namespace App\Http\Controllers;

use App\AdminModel;
use App\Location;
use App\Vendor_category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function __construct()
    {
       // $this->middleware('admin');
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

    public function vendors() {
        $query = AdminModel::allVendors();
        $data = array(
            'query' => $query
        );
        return view('admin.pages.vendor.view')->with($data);
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

}
