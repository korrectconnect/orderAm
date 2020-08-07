<?php

namespace App\Http\Controllers;

use App\AdminModel;
use App\Customer;
use App\Location;
use App\Order;
use App\Rider;
use App\Rider_category;
use App\Slider;
use App\User;
use App\Vendor_auth;
use App\Vendor_category;
use App\Vendor_transaction;
use App\Vendors;
use Carbon\Carbon;
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
        $pending = Order::Join('rider_orders', 'rider_orders.order_no', 'order.order_no')
                            ->select('order.*')
                            ->where([['order.status', '=', 1], ['order.cancelled', '=', 0], ['rider_orders.rider_id', '=', NULL]])
                            ->get()->count();
        $delivery = Order::Join('rider_orders', 'rider_orders.order_no', 'order.order_no')
                            ->select('order.*')
                            ->where([['order.status', '=', 1], ['order.cancelled', '=', 0], ['rider_orders.rider_id', '!=', NULL]])
                            ->get()->count();
        $customers = Customer::all()->count();

        $data = array(
            'vendors' => $vendors,
            'menus' => $menus,
            'pending' => $pending,
            'delivery' => $delivery,
            'customers' => $customers,
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

    public function vendorFinance($id) {

        $vendor = Vendors::where(['id' => $id])->first();
        $auth = Vendor_auth::where(['user_id' => $vendor->user_id])->first();

        return view('admin.pages.vendor.finance')->with(['vendor' => $vendor, 'auth' => $auth]);
    }

    public function vendorAuth(Request $request) {
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $account_id = substr(str_shuffle($str_result), 0, 3).$request->id.substr(str_shuffle($str_result), 0, 3);
        $secret = substr(str_shuffle($str_result), 0, 8);
        $get = Vendor_auth::where(['vendor_id' => $request->id]);
        if ($get->count() >= 1) {
            $query = $get->update([
                'account_id' => $account_id,
                'secret' => encrypt($secret),
                'password' => bcrypt($account_id),
            ]);
        }else {
            $query = Vendor_auth::insert([
                'vendor_id' => $request->id,
                'account_id' => $account_id,
                'secret' => encrypt($secret),
                'password' => bcrypt($account_id),
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
        $auth = Vendor_auth::where(['user_id' => $vendor->user_id])->first();
        $user = User::where(['id' => $vendor->user_id])->first();

        $data = array(
            'vendor' => $vendor,
            'menus' => $menus,
            'categories' => $categories,
            'auth' => $auth,
            'user' => $user,
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

    public function transactions() {
        $transactions = Order::join('vendors','vendors.id','=','order.vendor_id')->select('order.*','vendors.name','vendors.lga')->where(['order.status' => 2])->orderBy('updated_at', 'desc')->get() ;
        $orders = Order::join('vendors','vendors.id','=','order.vendor_id')->select('order.*','vendors.name','vendors.lga')->where(['order.status' => 2, 'cancelled' => 0])->orderBy('updated_at', 'desc')->get() ;

        if ($orders->count() >= 1) {
            $profit = 0;
            $total = 0;

            foreach($orders as $order) {
                $commission = (($order->total - $order->delivery_charge) * $order->commission)/100 ;
                $profit += $commission;
                $total += ($order->total - $order->delivery_charge);
            }
        }else {
            $profit = 0;
            $total = 0;
        }

        $data = array(
            'transactions' => $transactions,
            'profit' => $profit,
            'total' => $total,
            'delivered' => $orders->count(),
        );

        return view('admin.pages.transactions')->with($data);
    }

    public function pending() {
        $orders = Order::join('vendors','vendors.id','=','order.vendor_id')
                        ->join('rider_orders','rider_orders.order_no','order.order_no')
                        ->select('order.*','vendors.name','vendors.lga','rider_orders.confirm')
                        ->where([['order.cancelled', '=', 0], ['order.status', '=', 1], ['rider_orders.rider_id','!=',NULL]])
                        ->orderBy('updated_at', 'desc')
                        ->get() ;

        $data = array(
            'orders' => $orders,
        );

        return view('admin.pages.pending')->with($data);
    }

    public function slider() {
        $sliders = Slider::orderBy('id','desc')->get() ;

        $data = array(
            'sliders' => $sliders,
        );

        return view('admin.pages.sliders')->with($data);
    }

    public function orders() {
        $orders = DB::table('order')
                    ->join('vendors','vendors.id','=','order.vendor_id')
                    ->join('rider_orders','rider_orders.order_no','order.order_no')
                    ->select('order.*','vendors.name','vendors.lga')
                    ->where([['order.cancelled', '=', 0], ['order.status', '=', 1], ['rider_orders.rider_id','=',NULL]])
                    ->orderBy('order.created_at', 'desc')->get() ;

        $data = array(
            'orders' => $orders,
        );

        return view('admin.pages.orders')->with($data);
    }

    public function riders() {
        $riders = Rider::join('users','users.id','=','riders.user_id')
                    ->select('riders.*','users.email','users.username')
                    ->get();

        $data = array(
            'riders' => $riders,
        );

        return view('admin.pages.rider.view')->with($data);
    }

    public function vendorFunding() {
        $funds = Vendor_transaction::join('vendors','vendors.id','vendor_transactions.vendor_id')
                                    ->select('vendor_transactions.*', 'vendors.name')
                                    ->orderBy('vendors.created_at')
                                    ->get() ;

        $data = array(
            'funds' => $funds,
        );

        return view('admin.pages.vendor.funding')->with($data);
    }

    public function singleRider($id) {
        $rider = Rider::join('users','users.id','=','riders.user_id')
                            ->select('riders.*','users.email','users.username')
                            ->where(['riders.id' => $id])
                            ->first();

        if ($rider != NULL) {
            $data = array(
                'rider' => $rider,
            );

            return view('admin.pages.rider.single')->with($data);
        }
    }

    public function editRiderForm($id) {
        $rider = Rider::join('users','users.id','=','riders.user_id')
                            ->select('riders.*','users.email','users.username')
                            ->where(['riders.id' => $id])
                            ->first();
        $categories = Rider_category::all();

        $data = array(
            'rider' => $rider,
            'categories' => $categories
        );

        return view('admin.pages.rider.edit')->with($data);
    }

    public function editVendorForm($id) {
        $vendor = Vendors::where(['id' => $id])->first();
        $categories = Vendor_category::all();
        $states = Location::where('type','=','state')->get();
        $countries = Location::where('type','=','country')->get();
        $lgas = Location::where('type','=','lga')->get();
        $areas = Location::where('type','=','area')->get();

        $data = array(
            'vendor' => $vendor,
            'categories' => $categories,
            'states' => $states,
            'countries' => $countries,
            'lgas' => $lgas,
            'areas' => $areas,
        );

        return view('admin.pages.vendor.edit')->with($data);
    }

}
