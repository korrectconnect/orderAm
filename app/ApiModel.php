<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ApiModel extends Model
{
    //
    public static function addVendor($request, $file) {
        $insert = DB::table('vendors')->insert(
            [
                'name' => $request->name,
                'email' => $request->email,
                'contact' => $request->contact,
                'address' => $request->address,
                'state' => $request->state,
                'lga' => $request->lga,
                'country' => $request->country,
                'zip' => $request->zip,
                'type' => $request->type,
                'opening' => $request->open,
                'closing' => $request->close,
                'image' => $file,
                'status' => 1,
                'updated_at' => now(),
                'created_at' => now()
            ]
        );

        if ($insert) {
            return true ;
        }else {
            return false ;
        }
    }

    public static function addMenu($request, $file) {
        $insert = DB::table('menus')->insert(
            [
                'menu' => $request->name,
                'vendor_id' => $request->vendor_id,
                'description' => $request->description,
                'category' => $request->category,
                'price' => $request->price,
                'image' => $file,
                'updated_at' => now(),
                'created_at' => now()
            ]
        );

        if ($insert) {
            return true ;
        }else {
            return false ;
        }
    }


    public static function allVendors() {
        $query = DB::table('vendors')->orderBy('id','desc')->get()->map(function ($item, $key) {
            return (array) $item;
        })->all();
        return $query ;
    }

    public static function getVendor($id) {
        $query = DB::table('vendors')->where('id',$id)->first();
        return $query ;
    }

    public static function getAllMenus($category = null) {
        if($category == null) {
            $query = DB::table('menus')->join('vendors', 'menus.vendor_id', '=', 'vendors.id')->select('menus.*', 'vendors.name')->orderBy('created_at','desc')->skip(0)->take(10)->get() ;
        }else {
            $query = DB::table('menus')->join('vendors', 'menus.vendor_id', '=', 'vendors.id')->select('menus.*', 'vendors.name')->where('menus.category',$category)->orderBy('created_at','desc')->skip(0)->take(10)->get() ;
        }

        return $query ;
    }

    public static function getMenus($id,$category = null) {
        if($category == null) {
            $query = DB::table('menus')->join('vendors', 'menus.vendor_id', '=', 'vendors.id')->select('menus.*', 'vendors.name')->where([['menus.vendor_id','=',$id]])->orderBy('created_at','desc')->get() ;
        }else {
            $query = DB::table('menus')->join('vendors', 'menus.vendor_id', '=', 'vendors.id')->select('menus.*', 'vendors.name')->where([['menus.category','=',$category],['menus.vendor_id','=',$id]])->orderBy('created_at','desc')->get() ;
        }

        return $query ;
    }

    public static function getMenuCategory($id) {
        $query = DB::table('menu_category')->where('vendor_id',$id)->get();

        return $query ;
    }

    public static function addMenuCategory($request) {
        $insert = DB::table('menu_category')->insert(
            [
                'category' => $request->category,
                'vendor_id' => $request->vendor_id,
                'updated_at' => now(),
                'created_at' => now()
            ]
        );

        if ($insert) {
            return true ;
        }else {
            return false ;
        }
    }

    public static function deleteMenuCategory($id) {
        $delete = DB::table('menu_category')->where('id','=',$id)->delete();
        if ($delete) {
            return true ;
        }else {
            return false ;
        }
    }

    public static function deleteMenu($id) {
        $delete = DB::table('menus')->where('id','=',$id)->delete();
        if ($delete) {
            return true ;
        }else {
            return false ;
        }
    }

    public static function deleteVendor($id) {
        $delete = DB::table('vendors')->where('id','=',$id)->delete();
        $delete = DB::table('menus')->where('vendor_id','=',$id)->delete();
        $delete = DB::table('menu_category')->where('vendor_id','=',$id)->delete();
        if ($delete) {
            return true ;
        }else {
            return false ;
        }
    }

    public static function searchVendor($key) {
        $search = DB::table('vendors')->where('name','LIKE',"%$key%")->orderBy('id','desc')->get();

        return $search ;
    }

    public static function order($request) {
        $order_no = auth()->user()->id.time().rand(0,100);
        $query = DB::table('order')->insert([
            'user_id' => auth()->user()->id,
            'order_no' => $order_no,
            'vendor_id' => $request->vendor->id,
            'transaction_id' => $request->transaction_id,
        ]);


    }

}
