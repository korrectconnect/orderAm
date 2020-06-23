<?php

namespace App\Http\Controllers;

use App\AdminModel;
use GuzzleHttp\Client;
use App\Services\GoogleMaps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Location\Facades\Location;

class AjaxController extends Controller
{
    //

    // public function testing()
    // {
    //     $ip = '129.18.181.170';
    //     $rider_location = Location::get($ip);
    //     dd($rider_location->latitude);
    //     // $address = '33 jalupon surulere lagos';
    //     // $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&key='.env( 'GOOGLE_MAPS_KEY' );

    //     // $client = new Client();

    //     // $response = $client->get($url)->getBody();
    //     // $decoded_response = json_decode( $response );
    //     // dd($decoded_response);

    //     $user_origin_lat = "6.4943891";
    //     $user_origin_long = "3.355245";
    //     $order_lat = "6.4902331";
    //     $order_long = "3.3573441";

    //     // $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins='.urlencode($user_origin_lat.','.$user_origin_long).'&destinations='.urlencode($order_lat.','.$order_long).'&key='.env('GOOGLE_MAPS_KEY');

    //     // $client = new Client();

    //     // $response = $client->get($url)->getBody();

    //     // $decoded_response = \json_decode($response);

    //     // // dd($decoded_response);
    //     // $coordinates['distance'] = null;
    //     // $coordinates['duration'] = null;

    //     // if(!empty($decoded_response) && isset($decoded_response->rows[0])){
    //     //     $coordinates['distance'] = $decoded_response->rows[0]->elements[0]->distance->text;
    //     //     $coordinates['duration'] = $decoded_response->rows[0]->elements[0]->duration->text;
    //     // }
    //     // dd($coordinates['distance']);

    //     $map = GoogleMaps::getDistance($user_origin_lat, $user_origin_long, $order_lat, $order_long);
    //     dd($map['distance']);
    //     return response()->json($map);
    // }
    public function addVendor(Request $request) {

        if($request->ajax()) {

            $validatedData = Validator::make($request->all(), [
                'name' => 'max:55|required',
                'email' => 'email|required',
                'cover' => 'required|image|max:1999',
                'address' => 'max:250|required',
                'contact' => 'max:250|required',
                'state' => 'max:250|required',
                'lga' => 'max:250|required',
                'country' => 'max:250|required',
                'zip' => 'max:250|required',
                'type' => 'max:250|required',
                'open' => 'max:250|required',
                'close' => 'max:250|required',
            ]);

            if ($validatedData->fails())
            {
                return response()->json(['errors'=>$validatedData->errors()->all()]);
            }else {

                if ($request->hasFile('cover')) {

                    $filenameExt = $request->file('cover')->getClientOriginalName();
                    $file = pathinfo($filenameExt, PATHINFO_FILENAME);
                    $extension = $request->file('cover')->getClientOriginalExtension();
                    $filename = $request->name.'_'.time().'.'.$extension ;
                    $path = $request->file('cover')->storeAs('public/vendor', $filename) ;

                    if($path) {
                        $query = AdminModel::addVendor($request, $filename);
                        if($query) {
                            return response()->json(['errors'=>null, 'message'=>'Uploaded Successfully']);
                        }
                        return response()->json(['errors'=>'Server error try again']);
                    }
                    return response()->json(['errors'=>'Error uploading file']);

                }else {

                    return response()->json(['errors'=>'No file Selected']);

                }
            }
        }
    }

    public function addMenu(Request $request) {
        if($request->ajax()) {
            $validatedData = Validator::make($request->all(), [
                'name' => 'max:55|required',
                'cover' => 'required|image|max:1999',
                'description' => 'max:250|required',
                'price' => 'max:250|required',
                'category' => 'max:250|required',
                'vendor_id' => 'max:250|required',
            ]);

            if ($validatedData->fails())
            {
                return response()->json(['errors'=>$validatedData->errors()->all()]);
            }else {
                if ($request->hasFile('cover')) {

                    $filenameExt = $request->file('cover')->getClientOriginalName();
                    $file = pathinfo($filenameExt, PATHINFO_FILENAME);
                    $extension = $request->file('cover')->getClientOriginalExtension();
                    $filename = $request->name.'_'.$request->vendor_id.'_'.time().'.'.$extension ;
                    $path = $request->file('cover')->storeAs('public/menu', $filename) ;

                    if($path) {
                        $query = AdminModel::addMenu($request, $filename);
                        if($query) {
                            return response()->json(['errors'=>null, 'message'=>'Uploaded Successfully']);
                        }
                        return response()->json(['errors'=>'Server error try again']);
                    }
                    return response()->json(['errors'=>'Error uploading file']);

                }else {

                    return response()->json(['errors'=>'No file Selected']);

                }
            }

        }
    }

    public function viewVendor($id) {
        $query = AdminModel::getVendor($id);
        $data = array(
            'query' => $query
        );
        return view('admin.ajax.view_vendor')->with($data) ;
    }

    public function addMenuFrom($id) {
        $vendor = AdminModel::getVendor($id);
        $data = array(
            'vendor' => $vendor
        );

        return view('admin.ajax.add_menu_form')->with($data);
    }

    public function refreshMenus() {
        $menus = AdminModel::getAllMenus();

        $data = array(
            'menus' => $menus
        );
        return view('admin.ajax.viewQuickMenus')->with($data);
    }

    public function refreshMenu($id) {
        $menus = AdminModel::getMenus($id);

        $data = array(
            'menus' => $menus
        );
        return view('admin.ajax.viewQuickMenus')->with($data);
    }

    public function addMenuCategory(Request $request) {
        if($request->ajax()) {
            $validatedData = Validator::make($request->all(), [
                'category' => 'max:55|required',
            ]);

            if ($validatedData->fails())
            {
                return response()->json(['errors'=>$validatedData->errors()->all()]);
            }else {
                $query = AdminModel::addMenuCategory($request);

                if($query) {
                    return response()->json(['errors'=>null, 'message'=>'Added Successfully']);
                }
                return response()->json(['errors'=>'Server error try again']);
            }
        }
    }

    public function deleteMenuCategory(Request $request) {
        if($request->ajax()) {
            $query = AdminModel::deleteMenuCategory($request->category_id);
            if($query) {
                return response()->json(['errors'=>null, 'message'=>'Deleted Successfully']);
            }else {
                return response()->json(['errors'=>'Server error try again']);
            }
        }
    }

    public function getMenuCategoryList($id) {
        $query = AdminModel::getMenuCategory($id);
        $list = "";

        if($query->count() >= 1) {
            foreach ($query as $e) {
                $list .= "<option>".$e->category."</option>" ;
            }

            return $list;
        }else {
            return "false" ;
        }
    }

    public function deleteMenu($id) {
            $query = AdminModel::deleteMenu($id);
            if($query) {
                return response()->json(['errors'=>null, 'message'=>'Deleted Successfully']);
            }else {
                return response()->json(['errors'=>'Server error try again']);
            }
    }

    public function deleteVendor($id) {
        $query = AdminModel::deleteVendor($id);
            if($query) {
                return response()->json(['errors'=>null, 'message'=>'Deleted Successfully']);
            }else {
                return response()->json(['errors'=>'Server error try again']);
            }
    }

    public function searchVendor($key) {
        $vendors = AdminModel::searchVendor($key);

        $data = array(
            'vendors' => $vendors
        );
        return view('admin.ajax.searchVendors')->with($data);
    }

}
