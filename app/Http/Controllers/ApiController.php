<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ApiModel ;
use App\Http\Resources\AppResource;
use App\Vendors;
use App\Menus;
use App\User;
use App\Menu_category;

class ApiController extends Controller
{
    //
    public function editUser($id, Request $request) {
        $user = User::findOrFail($id);

        $user->firstname = $request->firstname ;
        $user->lastname = $request->lastname ;
        $user->phone = $request->phone ;
        $user->address = $request->address ;

        if($user->save()) {
            return new AppResource($user);
        }
    }

    public function vendor($id) {
        $vendor = Vendors::findOrFail($id);

        return new AppResource($vendor);
    }

    public function vendors() {
        $vendors = Vendors::orderBy('id', 'desc')->get();

        return AppResource::collection($vendors);
    }

    public function getMenus($id) {
        $query = Menus::join('vendors', 'menus.vendor_id', '=', 'vendors.id')->select('menus.*', 'vendors.name')->where([['menus.vendor_id','=',$id]])->orderBy('created_at','desc')->get() ;

        return AppResource::collection($query);
    }

    public function getMenusByCategory($id,$category = null) {
        $query = Menus::join('vendors', 'menus.vendor_id', '=', 'vendors.id')->select('menus.*', 'vendors.name')->where([['menus.category','=',$category],['menus.vendor_id','=',$id]])->orderBy('created_at','desc')->get() ;

        return AppResource::collection($query);
    }

    public function getMenusCategory($id) {
        $query =  Menu_category::where('vendor_id','=',"$id")->get() ;

        return AppResource::collection($query);
    }

    public function searchVendors($key) {
        $search = Vendors::where('name','LIKE',"%$key%")->orderBy('id','desc')->get();

        return AppResource::collection($search);
    }
}
