<?php

namespace App\Http\Controllers;

use App\AdminModel;
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

        return view('admin.homepage')->with($data);
    }

    public function addVendorForm() {
        return view('admin.vendor.add');
    }

    public function vendors() {
        $query = AdminModel::allVendors();
        $data = array(
            'query' => $query
        );
        return view('admin.vendor.view')->with($data);
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

        return view('admin.vendor.single')->with($data);
    }

    public function menus() {
        //
        $vendors = AdminModel::allVendors();
        $menus = AdminModel::getAllMenus();

        $data = array(
            'vendors' => $vendors,
            'menus' => $menus
        );
        return view('admin.menus.home')->with($data);
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
        return view('admin.menus.view')->with($data);
    }

}
