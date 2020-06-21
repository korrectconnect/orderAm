<?php

namespace App\Http\Controllers;


use App\AdminModel;
use App\Location;
use App\Order;
use App\Rider;
use App\Rider_category;
use App\Vendor_auth;
use App\Vendor_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminAjaxController extends Controller
{

    public function __construct()
    {
       $this->middleware('admin');
    }

    public function addVendor(Request $request) {

        if($request->ajax()) {

            $validatedData = Validator::make($request->all(), [
                'name' => 'max:55|required',
                'email' => 'email|required',
                'cover' => 'required|image|max:1999',
                'vendor-image' => 'required|image|max:1999',
                'address' => 'max:250|required',
                'contact' => 'max:250|required',
                'state' => 'max:250|required',
                'lga' => 'max:250|required',
                'area' => 'max:250|required',
                'country' => 'max:250|required',
                'zip' => 'max:250|required',
                'type' => 'max:250|required',
                'tax' => 'max:250|required',
                'delivery_charge' => 'max:250|required',
                'vendor_charge' => 'max:250|required',
                'open' => 'max:250|required',
                'close' => 'max:250|required',
            ]);

            if ($validatedData->fails())
            {
                return response()->json(['errors'=>$validatedData->errors()->all()]);
            }else {

                if ($request->hasFile('cover') && $request->hasFile('vendor-image')) {

                    $vendor_image_extension = $request->file('vendor-image')->getClientOriginalExtension();
                    $vendor_image_filename = $request->name.'_image_'.time().'.'.$vendor_image_extension ;
                    $image_path = $request->file('vendor-image')->storeAs('public/vendor', $vendor_image_filename) ;

                    $vendor_cover_extension = $request->file('cover')->getClientOriginalExtension();
                    $cover_filename = $request->name.'_cover_'.time().'.'.$vendor_cover_extension ;
                    $cover_path = $request->file('cover')->storeAs('public/vendor', $cover_filename) ;

                    if($image_path && $cover_path) {
                        $query = AdminModel::addVendor($request, $vendor_image_filename, $cover_filename);
                        if($query) {
                            return response()->json(['errors'=>null, 'message'=>'Uploaded Successfully']);
                        }
                        return response()->json(['errors'=>['Server error try again']]);
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
                        return response()->json(['errors'=>['Server error try again']]);
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
        $auth = Vendor_auth::where(['vendor_id' => $id])->first();
        $data = array(
            'query' => $query,
            'auth' => $auth,
        );
        return view('admin.pages.ajax.view_vendor')->with($data) ;
    }

    public function addMenuFrom($id) {
        $vendor = AdminModel::getVendor($id);
        $data = array(
            'vendor' => $vendor
        );

        return view('admin.pages.ajax.add_menu_form')->with($data);
    }

    public function refreshMenus() {
        $menus = AdminModel::getAllMenus();

        $data = array(
            'menus' => $menus
        );
        return view('admin.pages.ajax.viewQuickMenus')->with($data);
    }

    public function refreshMenu($id) {
        $menus = AdminModel::getMenus($id);

        $data = array(
            'menus' => $menus
        );
        return view('admin.pages.ajax.viewQuickMenus')->with($data);
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
                return response()->json(['errors'=>['Server error try again']]);
            }
        }
    }

    public function deleteMenuCategory(Request $request) {
        if($request->ajax()) {
            $query = AdminModel::deleteMenuCategory($request->category_id);
            if($query) {
                return response()->json(['errors'=>null, 'message'=>'Deleted Successfully']);
            }else {
                return response()->json(['errors'=>['Server error try again']]);
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
                return response()->json(['errors'=>['Server error try again']]);
            }
    }

    public function deleteVendor($id) {
        $query = AdminModel::deleteVendor($id);
            if($query) {
                return response()->json(['errors'=>null, 'message'=>'Deleted Successfully']);
            }else {
                return response()->json(['errors'=>['Server error try again']]);
            }
    }

    public function searchVendor($key) {
        $vendors = AdminModel::searchVendor($key);

        $data = array(
            'vendors' => $vendors
        );
        return view('admin.pages.ajax.searchVendors')->with($data);
    }

    public function addVendorCategory(Request $request) {
        if($request->ajax()) {

            $validatedData = Validator::make($request->all(), [
                'name' => 'max:191|required|unique:vendor_category',
                'cover' => 'required|image|max:1999',
                'description' => 'max:250|required',
            ]);

            if ($validatedData->fails())
            {
                return response()->json(['errors'=>$validatedData->errors()->all()]);
            }else {

                if ($request->hasFile('cover')) {

                    $extension = $request->file('cover')->getClientOriginalExtension();
                    $filename = $request->name.'_cover_'.time().'.'.$extension ;
                    $path = $request->file('cover')->storeAs('public/vendor/category', $filename) ;

                    if($path) {
                        $query = Vendor_category::insert([
                            'name' => $request->name,
                            'description' => $request->description,
                            'image' => asset('storage/vendor/category/'.$filename),
                        ]);
                        if($query) {
                            return response()->json(['errors'=>null, 'message'=>'Uploaded Successfully']);
                        }
                        return response()->json(['errors'=>['Server error try again']]);
                    }
                    return response()->json(['errors'=>['Error uploading file']]);

                }else {

                    return response()->json(['errors'=>['No file Selected']]);

                }
            }
        }
    }

    public function addVendorLocation(Request $request) {
        if($request->ajax()) {
            $validatedData = Validator::make($request->all(), [
                'name' => 'max:191|required',
                'type' => 'max:250|required',
            ]);

            if ($validatedData->fails())
            {
                return response()->json(['errors'=>$validatedData->errors()->all()]);
            }else {
                $query = Location::insert([
                    'name' => $request->name,
                    'type' => $request->type,
                ]);

                if($query) {
                    return response()->json(['errors'=>null, 'message'=>'Location added Successfully']);
                }
                return response()->json(['errors'=>['Error adding location try again']]);
            }
        }
    }

    public function deleteVendorCategory($id) {
        $delete = Vendor_category::where('id','=',$id)->delete() ;

        if($delete) {
            return response()->json(['errors'=>null, 'message'=>'Deleted Successfully']);
        }else {
            return response()->json(['errors'=>['Error deleting category']]);
        }
    }

    public function deleteVendorLocation($id) {
        $delete = Location::where('id','=',$id)->delete() ;

        if($delete) {
            return response()->json(['errors'=>null, 'message'=>'Deleted Successfully']);
        }else {
            return response()->json(['errors'=>['Error deleting category']]);
        }
    }

    public function refreshVendorCategory() {
        $categories = Vendor_category::all() ;

        $data = array(
            'categories' => $categories,
        );
        return view('admin.pages.ajax.vendor_category')->with($data);
    }

    public function refreshVendorLocation() {
        $locations = Location::all() ;

        $data = array(
            'locations' => $locations,
        );
        return view('admin.pages.ajax.vendor_location')->with($data);
    }

    public function cancelOrder($id, Request $request) {
        if ($request->ajax()) {
            $order = Order::where(['id' => $id]);
            $update = $order->update([
                'cancelled' => 1,
            ]);

            if($update) {
                return response()->json(['errors'=>NULL]);
            }else {
                return response()->json(['errors'=>['Error cancelling order']]);
            }
        }
    }

    public function addRiderCategory(Request $request) {
        if ($request->ajax()) {
            $validatedData = Validator::make($request->all(), [
                'category' => 'max:191|required|unique:Rider_category',
            ]);

            if ($validatedData->fails())
            {
                return response()->json(['errors'=>$validatedData->errors()->all()]);
            }else {
                $insert = Rider_category::insert([
                    'category' => $request->category,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]) ;

                if($insert) {
                    return response()->json(['errors'=>NULL, 'message' => 'Added successfully']);
                }else {
                    return response()->json(['errors'=>['Error, try again !']]);
                }
            }
        }
    }

    public function deleteRiderCategory($id, Request $request) {
        if ($request->ajax()) {
            $delete = Rider_category::where(['id' => $id])->delete();

            if($delete) {
                return response()->json(['errors'=>NULL, 'message' => 'Deleted successfully']);
            }else {
                return response()->json(['errors'=>['Error, try again !']]);
            }
        }
    }

    public function addRider(Request $request) {
        if ($request->ajax()) {
            $validatedData = Validator::make($request->all(), [
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required|unique:riders',
                'category' => 'required',
                'company' => 'required',
                'phone' => 'required',
                'state' => 'required',
                'country' => 'required',
                'lga' => 'required',
                'dob' => 'required',
                'address' => 'required',
                'plate' => 'required',
                'photo' => 'required|image|max:1999',
            ]);

            if ($validatedData->fails())
            {
                return response()->json(['errors'=>$validatedData->errors()->all()]);
            }else {

                if ($request->hasFile('photo')) {

                    $extension = $request->file('photo')->getClientOriginalExtension();
                    $filename = $request->firstname.'_image_'.rand(1,100).time().'.'.$extension ;
                    $image_path = $request->file('photo')->storeAs('public/rider', $filename) ;

                    if($image_path) {
                        $insert = Rider::insert([
                            'firstname' => $request->firstname,
                            'lastname' => $request->lastname,
                            'email' => $request->email,
                            'category' => $request->category,
                            'company' => $request->company,
                            'phone' => $request->phone,
                            'state' => $request->state,
                            'country' => $request->country,
                            'lga' => $request->lga,
                            'date_of_birth' => $request->dob,
                            'address' => $request->address,
                            'spouse_name' => $request->spouse_name,
                            'spouse_phone' => $request->spouse_phone,
                            'plate_number' => $request->plate,
                            'image' => asset('storage/rider/'.$filename),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]) ;

                        if($insert) {
                            $ranString = "abcdefghijklmnopqrstuvwxyz" ;
                            $s = "";
                            for ($i=0; $i < 2; $i++) {
                                # code...
                                $s .= $ranString[rand(0, 25)];
                            }

                            $get = Rider::where(['email' => $request->email]) ;

                            $username = strtolower($request->firstname).$get->first()->id.$s;
                            $password = bcrypt($username);

                            $update = $get->update([
                                'username' => $username,
                                'password' => $password,
                            ]);

                            if($update) {
                                return response()->json(['errors'=>NULL, 'message' => 'Rider registered successfully']);
                            }else {
                                return response()->json(['errors'=>['Error, Could not add rider authenticator']]);
                            }

                            //
                        }else {
                            return response()->json(['errors'=>['Error, try again !']]);
                        }
                    }else {
                        return response()->json(['errors'=>['Error, could not upload photo, try again !']]);
                    }
                }
            }
        }
    }

    public function assignRiderForm($id, Request $request) {
        if ($request->ajax()) {

            $rider = Rider::where(['id' => $id])->first();
            $lgas = Location::where('type','=','lga')->get();

            if ($rider != NULL) {
                $data = array(
                    'rider' => $rider,
                    'lgas' => $lgas,
                );

                return view('admin.pages.ajax.assign_rider')->with($data);
            }
        }
    }

    public function assignRider(Request $request) {
        if ($request->ajax()) {
            $validatedData = Validator::make($request->all(), [
                'lga' => 'required',
            ]);

            if ($validatedData->fails())
            {
                return response()->json(['errors'=>$validatedData->errors()->all()]);
            }else {

                $rider = Rider::where(['id' => $request->rider_id]);

                if ($rider->first() != NULL ) {

                    $update = $rider->update([
                        'location_assigned' => $request->lga,
                        'location_description' => $request->description,
                    ]);

                    if($update) {
                        return response()->json(['errors'=>NULL, 'message' => 'Rider assigned successfully']);
                    }else {
                        return response()->json(['errors'=>['Error, Could not assign rider to location']]);
                    }

                } else {
                    return response()->json(['errors'=>['Error, refresh page and try again !']]);
                }
            }
        }
    }

    public function riderByAssignedLocation($location, Request $request) {
        if ($request->ajax()) {
            $riders = Rider::where(['location_assigned' => $location])->get();

            $data = array(
                'riders' => $riders,
                'location' => $location,
            );

            return view('admin.pages.ajax.assigned_riders')->with($data);
        }
    }

    public function unassignRider($id, Request $request) {
        if ($request->ajax()) {
            $rider = Rider::where(['id' => $id]);

            if ($rider->first() != NULL) {
                $update = $rider->update([
                    'location_assigned' => NULL,
                    'location_description' => NULL,
                ]);

                if($update) {
                    return response()->json(['errors'=>NULL, 'message' => 'Rider unassigned successfully']);
                }else {
                    return response()->json(['errors'=>['Error, Could not run request try again']]);
                }

            }
        }
    }


}
