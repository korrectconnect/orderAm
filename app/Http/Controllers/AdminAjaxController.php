<?php

namespace App\Http\Controllers;


use App\AdminModel;
use App\Location;
use App\Order;
use App\Rider;
use App\Rider_category;
use App\Rider_order;
use App\Slider;
use App\User;
use App\Vendor_auth;
use App\Vendor_category;
use App\Vendor_transaction;
use App\Vendors;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                'email' => 'email|required|unique:users',
                'username' => 'max:55|required|unique:users',
                'description' => 'required',
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

    public function editVendor(Request $request) {

        if($request->ajax()) {

            $validatedData = Validator::make($request->all(), [
                'name' => 'max:55|required',
                'email' => 'email|required',
                'description' => 'required',
                'cover' => 'image|max:1999',
                'vendor-image' => 'image|max:1999',
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

                if ($request->hasFile('cover')) {

                    $vendor_cover_extension = $request->file('cover')->getClientOriginalExtension();
                    $cover_filename = $request->name.'_cover_'.time().'.'.$vendor_cover_extension ;
                    $cover_path = $request->file('cover')->storeAs('public/vendor', $cover_filename) ;

                    if($cover_path) {
                        Vendors::where(['id' => $request->id])->update([
                            'cover' => asset('storage/vendor/'.$cover_filename),
                        ]);
                    }else {
                        return response()->json(['errors'=>'Error uploading file']);
                    }
                }else {
                    $cover_path = true ;
                }

                if ($request->hasFile('vendor-image')) {

                    $vendor_image_extension = $request->file('vendor-image')->getClientOriginalExtension();
                    $vendor_image_filename = $request->name.'_image_'.time().'.'.$vendor_image_extension ;
                    $image_path = $request->file('vendor-image')->storeAs('public/vendor', $vendor_image_filename) ;

                    if($image_path) {
                        Vendors::where(['id' => $request->id])->update([
                            'image' => asset('storage/vendor/'.$vendor_image_filename),
                        ]);
                    }else {
                        return response()->json(['errors'=>'Error uploading file']);
                    }
                }else {
                    $image_path = true ;
                }

                if($image_path == true && $cover_path = true) {
                    $update = Vendors::where(['id' => $request->id])->update(
                        [
                            'name' => $request->name,
                            'email' => $request->email,
                            'description' => $request->description,
                            'contact' => $request->contact,
                            'address' => $request->address,
                            'state' => $request->state,
                            'lga' => $request->lga,
                            'country' => $request->country,
                            'zip' => $request->zip,
                            'area' => $request->area,
                            'type' => $request->type,
                            'tax' => $request->tax,
                            'delivery_charge' => $request->delivery_charge,
                            'vendor_charge' => $request->vendor_charge,
                            'opening' => $request->open,
                            'closing' => $request->close,
                            'updated_at' => now(),
                        ]
                    );

                    return response()->json(['errors'=>null, 'message'=>'Vendor edit Uploaded Successfully']);
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
        $data = array(
            'query' => $query,
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

    public function fundVendor(Request $request) {
        if($request->ajax()) {
            $validatedData = Validator::make($request->all(), [
                'amount' => 'required',
                'description' => 'required',
            ]);

            if ($validatedData->fails())
            {
                return response()->json(['errors'=>$validatedData->errors()->all()]);
            }else {
                $query = Vendor_auth::where(['user_id' => $request->user_id]) ;
                $amount = $query->first()->account + $request->amount;

                $fund = $query->update([
                    'account' => $amount,
                ]);

                $fund = Vendor_transaction::insert([
                    'vendor_id' => $request->id,
                    'amount' => $request->amount,
                    'description' => $request->description,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                if ($fund) {

                    return response()->json(['errors'=>null, 'message'=>'Account funded Successfully']);
                }
                return response()->json(['errors'=>['Error funding account']]);
            }
        }
    }

    public function refreshMenus() {
        $menus = AdminModel::getAllMenus();

        $data = array(
            'menus' => $menus
        );
        return view('admin.pages.ajax.viewQuickMenus')->with($data);
    }

    public function fundVendorHistory($id) {
        $vendor = AdminModel::getVendor($id);
        $auth = Vendor_auth::where(['user_id' => $vendor->user_id])->first();
        $funds = Vendor_transaction::join('vendors','vendors.id','vendor_transactions.vendor_id')
                                    ->select('vendor_transactions.*', 'vendors.name')
                                    ->where(['vendor_transactions.vendor_id' => $id])
                                    ->orderBy('vendors.created_at')
                                    ->get() ;

        $data = array(
            'auth' => $auth,
            'funds' => $funds,
        );

        return view('admin.pages.ajax.vendor_fund_history')->with($data);
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

    public function deleteMenuCategory($id ,Request $request) {
        if($request->ajax()) {
            $query = AdminModel::deleteMenuCategory($id);
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
                'commission' => 'required',
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
                            'commission' => $request->commission,
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

    public function riderPendingOrders($id) {
        $rider = Rider::where(['id' => $id])->first();

        $orders = Order::leftJoin('address', 'address.id', 'order.address')
                            ->leftJoin('vendors', 'vendors.id', '=', 'order.vendor_id' )
                            ->leftJoin('customers', 'customers.user_id', '=', 'order.user_id')
                            ->join('rider_orders', 'rider_orders.order_no', 'order.order_no')
                            ->select('order.*', DB::raw('customers.phone as user_phone'), DB::raw('vendors.state as vendor_state'), DB::raw('vendors.lga as vendor_lga'), 'vendors.name', 'customers.firstname', 'customers.lastname', 'address.lga','address.address','address.description','address.phone','address.state')
                            ->where(['rider_orders.rider_id' => $id])
                            ->get();

        $data = array(
            'orders' => $orders,
            'rider' => $rider,
        );

        return view('admin.pages.ajax.rider_orders')->with($data);
    }

    public function pendingDelivery($id) {
        $order = Order::leftJoin('address', 'address.id', 'order.address')
                            ->leftJoin('vendors', 'vendors.id', 'order.vendor_id' )
                            ->leftJoin('customers', 'customers.user_id', 'order.user_id')
                            ->select('order.*', DB::raw('customers.phone as user_phone'), DB::raw('vendors.state as vendor_state'), DB::raw('vendors.lga as vendor_lga'), 'vendors.name', 'customers.firstname', 'customers.lastname', 'address.lga','address.address','address.description','address.phone','address.state')
                            ->where(['order.id' => $id])
                            ->first();

        $rider = Rider_order::join('riders', 'riders.id', 'rider_orders.rider_id')
                                ->select('riders.*')
                                ->where(['rider_orders.order_no' => $order->order_no])
                                ->first();

        $data = array(
            'order' => $order,
            'rider' => $rider,
        );

        return view('admin.pages.ajax.pending_deliveries')->with($data);
    }

    public function viewOrder($id) {
        $order = Order::leftJoin('address', 'address.id', 'order.address')
                            ->leftJoin('vendors', 'vendors.id', 'order.vendor_id' )
                            ->leftJoin('customers', 'customers.user_id', 'order.user_id')
                            ->select('order.*', DB::raw('customers.phone as user_phone'), DB::raw('vendors.state as vendor_state'), DB::raw('vendors.lga as vendor_lga'), 'vendors.name', 'customers.firstname', 'customers.lastname', 'address.lga','address.address','address.description','address.phone','address.state')
                            ->where(['order.id' => $id])
                            ->first();

        $data = array(
            'order' => $order,
        );

        return view('admin.pages.ajax.orders_view')->with($data);
    }

    public function addSlider(Request $request) {

        if($request->ajax()) {

            $validatedData = Validator::make($request->all(), [
                'image' => 'required|image|max:1999',
            ]);

            if ($validatedData->fails())
            {
                return response()->json(['errors'=>$validatedData->errors()->all()]);
            }else {

                if ($request->hasFile('image')) {

                    $extension = $request->file('image')->getClientOriginalExtension();
                    $filename = 'slider_'.time().'.'.$extension ;
                    $path = $request->file('image')->storeAs('public/site/slider', $filename) ;

                    if($path) {
                        $query = Slider::insert([
                            'image' => asset('storage/site/slider/'.$filename),
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

    public function deleteSlider($id) {
        $query = Slider::where(['id' => $id])->delete() ;

        if($query) {
            return response()->json(['errors'=>null, 'message'=>'Deleted Successfully']);
        }
        return response()->json(['errors'=>['Server error try again']]);
    }

    public function assignRiderToOrderPage($id) {
        $order = Order::join('vendors','vendors.id','=','order.vendor_id')->select('order.*','vendors.name','vendors.state','vendors.lga')->where(['order.id' => $id])->first() ;

        $riders = Rider::leftJoin('rider_orders', 'rider_orders.rider_id', 'riders.id')
                            ->select('riders.*', DB::raw('count(rider_orders.order_no) as order_no'))
                            ->where(['riders.location_assigned' => $order->lga, 'riders.state' => $order->state])
                            ->get();
        $other_riders = Rider::leftJoin('rider_orders', 'rider_orders.rider_id', 'riders.id')
                                ->select('riders.*', DB::raw('count(rider_orders.order_no) as order_no'))
                                ->where(['riders.state' => $order->state])
                                ->get();

        $data = array(
            'riders' => $riders,
            'other_riders' => $other_riders,
            'order' => $order,
        );

        return view('admin.pages.ajax.order_assign')->with($data);
    }

    public function confirmAssignOrder($id, $order_id, Request $request) {
        if ($request->ajax()) {
            $order = Order::where(['id' => $order_id])->first();

            $query = Rider_order::where(['order_no' => $order->order_no])->update([
                'rider_id' => $id,
                'updated_at' => now(),
            ]);

            if ($query) {
                return response()->json(['errors' => NULL, 'message' => 'Rider assigned successfully', 'location' => route('admin.orders') ]);
            }else {
                return response()->json(['errors'=>['Error, try again !']]);
            }

        }
    }

    public function addRiderCategory(Request $request) {
        if ($request->ajax()) {
            $validatedData = Validator::make($request->all(), [
                'category' => 'max:191|required|unique:rider_category',
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
                'email' => 'required|unique:users',
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
                        $addUser = User::insert([
                            'email' => $request->email,
                            'role' => 'rider',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        $get = User::where(['email' => $request->email]) ;

                        $insert = Rider::insert([
                            'firstname' => $request->firstname,
                            'lastname' => $request->lastname,
                            'user_id' => $get->first()->id,
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

    public function editRider(Request $request) {
        if ($request->ajax()) {
            $validatedData = Validator::make($request->all(), [
                'firstname' => 'required',
                'lastname' => 'required',
                'category' => 'required',
                'company' => 'required',
                'phone' => 'required',
                'state' => 'required',
                'country' => 'required',
                'lga' => 'required',
                'dob' => 'required',
                'address' => 'required',
                'plate' => 'required',
                'photo' => 'image|max:1999',
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
                        $update = Rider::where(['id' => $request->id])->update([
                            'firstname' => $request->firstname,
                            'lastname' => $request->lastname,
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
                            'updated_at' => now(),
                        ]) ;

                        if($update) {
                            return response()->json(['errors'=>NULL, 'message' => 'Rider edited successfully']);
                        }else {
                            return response()->json(['errors'=>['Error, try again !']]);
                        }
                    }else {
                        return response()->json(['errors'=>['Error, could not upload photo, try again !']]);
                    }
                }else {
                    $update = Rider::where(['id' => $request->id])->update([
                        'firstname' => $request->firstname,
                        'lastname' => $request->lastname,
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
                        'updated_at' => now(),
                    ]) ;

                    if($update) {
                        return response()->json(['errors'=>NULL, 'message' => 'Rider edited successfully']);
                    }else {
                        return response()->json(['errors'=>['Error, try again !']]);
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


    public function transactionToday($vendor_id, Request $request) {
        if ($request->ajax()) {

            $orders = Order::where(['vendor_id' => $vendor_id, 'cancelled' => 0, 'status' => 2])
                                ->whereDate('updated_at', Carbon::today())->get();
            if ($orders->count() >= 1) {
                $t = 0 ;
                $c = 0;
                $d = 0;
                foreach ($orders as $order) {
                    $t += ($order->total - $order->delivery_charge) ;
                    $c += (($order->total - $order->delivery_charge)  * $order->commission)/100;
                    $d += $order->delivery_charge ;
                }
                $total = $t ;
            } else {
                $total = 0.00;
                $t = 0 ;
                $c = 0;
                $d = 0;
            }


            $data = array(
                'orders' => $orders,
                'total' => $total,
                'commission' => $c,
                'profit' => $total - $c,
                'delivery' => $d,
            );

            return view('admin.pages.ajax.vendor_transaction_today')->with($data);
        }
    }

    public function transactionFilter($vendor_id, Request $request) {
        if ($request->ajax()) {

            return view('admin.pages.ajax.filter')->with(['vendor_id' => $vendor_id]);
        }
    }

    public function transactionFiltered(Request $request) {
        if ($request->ajax()) {
            $vendor_id = $request->vendor_id;

            if ($request->start == NULL || $request->end == NULL) {
                return response()->json(['errors' => ['At least one filled was left undefined']]);
            }else {
                $end = Carbon::createFromFormat('Y-m-d', $request->end);

                $orders = Order::where(['vendor_id' => $vendor_id, 'cancelled' => 0, 'status' => 2])->whereBetween('updated_at', [$request->start, $end])->get();
                if ($orders->count() >= 1) {
                    $t = 0 ;
                    $c = 0 ;
                    $d = 0 ;
                    foreach ($orders as $order) {
                        $t += ($order->total - $order->delivery_charge) ;
                        $c += (($order->total - $order->delivery_charge)  * $order->commission)/100;
                        $d += $order->delivery_charge ;
                    }
                    $total = $t ;
                } else {
                    $total = 0.00;
                    $c = 0;
                    $d = 0 ;
                }


                $data = array(
                    'orders' => $orders,
                    'total' => $total,
                    'start' => $request->start,
                    'end' => $request->end,
                    'commission' => $c,
                    'profit' => $total - $c,
                    'delivery' => $d,
                );

                return view('admin.pages.ajax.filtered')->with($data);
            }
        }
    }


}
