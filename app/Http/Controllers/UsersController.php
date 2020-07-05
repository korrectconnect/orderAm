<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Vendor_category;
use App\Location;
use App\Menu_category;
use App\Vendors;
use App\Menus;
use App\Order;
use App\Address;
use App\Cart;
use App\Coupon;
use App\Customer;
use App\Favourite_vendor;
use App\Order_item;
use App\Slider;
use Carbon\Carbon;

class UsersController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('admin');
    }

    public function logout(Request $request) {
        if(Auth::check()) {
            Auth::logout();
            //$request->session()->invalidate();
            return redirect()->back();
        }
    }

    public function home() {

        $all = Vendors::all() ;
        if ($all->count() >= 2) {
            $randoms = Vendors::leftJoin('menus', 'menus.vendor_id', '=', 'vendors.id')
            ->select('vendors.*',DB::raw('min(menus.price) as price'))
            ->groupBy('vendors.id')->inRandomOrder()->limit($all->count())->get();
        } else {
            $randoms = Vendors::all();
        }


        $tops = Vendors::leftJoin('order','order.vendor_id','=','vendors.id')
                    ->select('vendors.*',DB::raw('count(order.order_no) as order_no'))
                    ->groupBy('vendors.id')->orderBy('order_no','desc')->get() ;

        $states = Location::where('type','=','State')->get() ;
        $lgas = Location::where('type','=','lga')->limit(5)->get() ;
        $categories = Vendor_category::all();
        $sliders = Slider::orderBy('id','desc')->limit(5)->get();

        $data = array(
            'randoms' => $randoms,
            'tops' => $tops,
            'states' => $states,
            'lgas' => $lgas,
            'categories' => $categories,
            'sliders' => $sliders
        );
        return view('user.pages.home')->with($data);
    }


    public function vendors($name, Request $request) {

        $category = Vendor_category::where('name','=',$name)->first() ;
        //$request->session()->forget('location');

        if($category == null) {
            return view('user.pages.404');
        }else {
            $states = Location::where('type','=','State')->get() ;
            $lgas = Location::where('type','=','lga')->limit(5)->get() ;
            $categories = Vendor_category::all();

            if($request->session()->has('location')) {
                //$vendors = Vendors::where([['state','=',$request->session()->get('location')['state']],['lga','=',$request->session()->get('location')['area']]])->get();

                $vendors = Vendors::leftJoin('menus', 'menus.vendor_id', '=', 'vendors.id')
                    ->select('vendors.*',DB::raw('min(menus.price) as price'))
                    ->where([['vendors.type','=',$name],['vendors.state','=',$request->session()->get('location')['state']],['vendors.lga','=',$request->session()->get('location')['area']]])
                    ->groupBy('vendors.id')->get() ;

                $data = array(
                    'vendors' => $vendors,
                    'type' => $name,
                    'state' => $request->session()->get('location')['state'],
                    'area' => $request->session()->get('location')['area'],
                    'states' => $states,
                    'lgas' => $lgas,
                    'categories' => $categories,
                );
                return view('user.pages.vendors')->with($data);
            }
            return redirect()->route('user.vendors.home');
        }
    }

    public function vendorsHome() {

        $category = Vendor_category::all() ;
        $state = Location::where('type','=','State')->get() ;
        $lga = Location::where('type','=','lga')->get() ;

        $states = Location::where('type','=','State')->get() ;
        $lgas = Location::where('type','=','lga')->limit(5)->get() ;
        $categories = Vendor_category::all();

        $data = array(
            'categories' => $category,
            'states' => $state,
            'lgas' => $lga,
            'states' => $states,
            'lgas' => $lgas,
            'categories' => $categories,
        );

        return view('user.pages.vendors_home')->with($data);
    }

    public function vendorSingle($id, $name, Request $request) {

        if($request->session()->has('location')) {

            $states = Location::where('type','=','State')->get() ;
            $lgas = Location::where('type','=','lga')->limit(5)->get() ;
            $categories = Vendor_category::all();

            $vendor = Vendors::where(['id' => $id, 'type' => $name])->first() ;


            if($vendor != null) {

                $single = Menus::select(DB::raw('min(menus.price) as price'))->where('menus.vendor_id','=',$vendor->id)->first();
                $menus = Menus::where('vendor_id','=',$vendor->id)->get();
                $menu_categories = Menu_category::where('vendor_id','=',$vendor->id)->get() ;

                if(Auth::check()) {
                    $carts = Cart::where(['user_id' => auth()->user()->id, 'vendor_id' => $vendor->id])->orderBy('id', 'desc')->get();

                    if($carts->count() >= 1) {
                        $order_total = 0 ;
                        foreach ($carts as $cart) {
                            $order_total = $order_total + ($cart->price * $cart->quantity);
                        }
                    }else {
                        $order_total = 0 ;
                    }

                    $total = $vendor->delivery_charge + $vendor->tax + $vendor->vendor_charge + $order_total ;

                    $fav = Favourite_vendor::where(['user_id' => auth()->user()->id, 'vendor_id' => $vendor->id])->first();

                    $data = array(
                        'vendor' => $vendor,
                        'type' => $name,
                        'menus' => $menus,
                        'single' => $single,
                        'menu_categories' => $menu_categories,
                        'carts' => $carts,
                        'order_total' => $order_total,
                        'total' => $total,
                        'fav' => $fav,
                        'states' => $states,
                        'lgas' => $lgas,
                        'categories' => $categories,
                    );
                }else {
                    $data = array(
                        'vendor' => $vendor,
                        'type' => $name,
                        'menus' => $menus,
                        'single' => $single,
                        'menu_categories' => $menu_categories,
                        'states' => $states,
                        'lgas' => $lgas,
                        'categories' => $categories,
                    );
                }

                return view('user.pages.vendor')->with($data);
            }
            return view('user.pages.404');

        }
        return redirect()->route('user.vendors.home');
    }


    public function orderProcess($id) {

            $vendor = Vendors::where(['id' => $id])->first() ;
            $states = Location::where('type','=','State')->get() ;
            $lgas = Location::where('type','=','lga')->limit(5)->get() ;
            $categories = Vendor_category::all();
            $user = Customer::where(['user_id' => auth()->user()->id])->first() ;

            if($vendor != null) {

                if(Auth::check()) {
                    $carts = Cart::where(['user_id' => auth()->user()->id, 'vendor_id' => $vendor->id])->orderBy('id', 'desc')->get();
                    $addresses = Address::where(['user_id' => auth()->user()->id, 'default' => NULL])->orderBy('id', 'desc')->get();
                    $defaultAddress = Address::where(['user_id' => auth()->user()->id, 'default' => 1, 'id' => $user->address_id])->first();

                    if($carts->count() >= 1) {
                        $order_total = 0 ;
                        foreach ($carts as $cart) {
                            $order_total = $order_total + ($cart->price * $cart->quantity);
                        }

                        $total = $vendor->delivery_charge + $vendor->tax + $vendor->vendor_charge + $order_total ;

                        $data = array(
                            'vendor' => $vendor,
                            'carts' => $carts,
                            'order_total' => $order_total,
                            'total' => $total,
                            'addresses' => $addresses,
                            'defaultAddress' => $defaultAddress,
                            'states' => $states,
                            'lgas' => $lgas,
                            'categories' => $categories,
                        );

                        return view('user.pages.order')->with($data);

                    }else {
                        return redirect()->route('user.vendors.home');
                    }

                }else {
                    return redirect()->route('user.vendors.home');
                }

            }
            return view('user.pages.404');

    }

    public function placeOrder(Request $request) {
        if(Auth::check()) {
            $vendor = Vendors::findOrFail($request->vendor);
            $vendorC = Vendor_category::where(['name' => $vendor->type])->first();
            if((date("H.i") < $vendor->opening) || (date("H.i") >= $vendor->closing)) {
                return redirect()->route('user.vendors.home');
            }
            if($request->coupon == "null") {
                $coupon = NULL ;
                $coupon_amount = 0 ;
            }else {
                $coupon = $request->coupon ;
                $date = Carbon::today();
                $getCoupon = Coupon::where('code','=',$coupon)->whereDate('expire', '>=', $date)->first();

                if ($getCoupon != NULL) {
                    if(($getCoupon->vendor_id != NULL) && ($getCoupon->vendor_id != $vendor->id)) {
                        $coupon_amount = 0 ;
                    }else {
                        $checkUser = Order::where(['user_id' => auth()->user()->id])->get();
                        if ($getCoupon->count == 0) {
                            if ($checkUser->count() >= 1) {
                                $coupon_amount = 0 ;
                            }
                            $coupon_amount = $getCoupon->amount ;
                        } else {
                            if ($checkUser->count() >= $getCoupon->count) {
                                $coupon_amount = 0 ;
                            }
                            $coupon_amount = $getCoupon->amount ;
                        }
                    }

                }else {
                    $coupon_amount = 0 ;
                }
            }

            $carts = Cart::where(['user_id' => auth()->user()->id, 'vendor_id' => $vendor->id])->orderBy('id', 'desc')->get() ;
            $order_no = auth()->user()->id.time().rand(0,100);

            if($carts->count() >= 1) {
                $order_total = 0 ;
                foreach ($carts as $cart) {
                    $order_total = $order_total + ($cart->price * $cart->quantity);

                    Order_item::insert([
                        'order_no' => $order_no,
                        'menu_id' => $cart->menu_id,
                        'quantity' => $cart->quantity,
                        'name' => $cart->name,
                        'price' => $cart->price,
                    ]);
                }
            }else {
                $order_total = 0 ;
            }

            $getTotal = $vendor->delivery_charge + $vendor->tax + $vendor->vendor_charge + $order_total - $coupon_amount ;
            if ($getTotal < 0) {
                $total = 0;
            }else {
                $total = $getTotal ;
            }

            $order = new Order;

            $order->user_id = auth()->user()->id;
            $order->order_no = $order_no;
            $order->vendor_id = $vendor->id;
            $order->transaction_id = $request->transaction;
            $order->coupon_code = $coupon;
            $order->address = $request->address;
            $order->payment_mode = $request->payment_type;
            $order->delivery_charge = $vendor->delivery_charge;
            $order->vendor_charge = $vendor->vendor_charge;
            $order->total = $total;
            $order->tax = $vendor->tax;
            $order->balance = 0;
            $order->Commission = $vendorC->Commission;
            $order->status = 0;
            $order->cancelled = 0;

            if($order->save()) {
                Cart::where(['vendor_id' => $request->vendor])->delete();
                $request->session()->flash('order', [
                    'vendor' => $vendor->id,
                    'number' => $order_no,
                ]);

                return redirect()->route('user.order.success');
            }else {
                return redirect()->route('user.vendors.home');
            }
        }else {
            return redirect()->route('user.vendors.home');
        }
    }

    public function orderSuccess(Request $request) {
        if($request->session()->has('order')) {
            $states = Location::where('type','=','State')->get() ;
            $lgas = Location::where('type','=','lga')->limit(5)->get() ;
            $categories = Vendor_category::all();
            $vendor = Vendors::findOrFail($request->session()->get('order')['vendor']);
            $order = $request->session()->get('order')['number'];

            $data = array(
                'vendor' => $vendor,
                'order' => $order,
                'states' => $states,
                'lgas' => $lgas,
                'categories' => $categories,
            );

            return view('user.pages.order_success')->with($data);
        }else {
            return redirect()->route('user.vendors.home');
        }
    }

    public function profile() {
        if(Auth::check()) {
            $states = Location::where('type','=','State')->get() ;
            $lgas = Location::where('type','=','lga')->limit(5)->get() ;
            $categories = Vendor_category::all();
            $user = Customer::where(['user_id' => auth()->user()->id])->first() ;
            $data = array(
                'states' => $states,
                'lgas' => $lgas,
                'categories' => $categories,
                'user' => $user,
            );
            return view('user.pages.profile')->with($data);
        }else {
            return redirect()->route('user.home');
        }
    }

    public function orders() {
        if(Auth::check()) {
            $states = Location::where('type','=','State')->get() ;
            $lgas = Location::where('type','=','lga')->limit(5)->get() ;
            $categories = Vendor_category::all();
            $orders = Order::where(['user_id' => auth()->user()->id])->orderBy('id','desc')->get();
            $user = Customer::where(['user_id' => auth()->user()->id])->first() ;

            $data = array(
                'orders' => $orders,
                'states' => $states,
                'lgas' => $lgas,
                'categories' => $categories,
                'user' => $user,
            );

            return view('user.pages.myorders')->with($data);
        }else {
            return redirect()->route('user.home');
        }
    }

    public function address() {
        if(Auth::check()) {
            $states = Location::where('type','=','State')->get() ;
            $lgas = Location::where('type','=','lga')->limit(5)->get() ;
            $categories = Vendor_category::all();
            $addresses = Address::where(['user_id' => auth()->user()->id, 'default' => NULL])->orderBy('id', 'desc')->get();
            $user = Customer::where(['user_id' => auth()->user()->id])->first() ;
            $defaultAddress = Address::where(['user_id' => auth()->user()->id, 'default' => 1, 'id' => $user->address_id])->first();
            $user = Customer::where(['user_id' => auth()->user()->id])->first() ;

            $data = array(
                'addresses' => $addresses,
                'defaultAddress' => $defaultAddress,
                'states' => $states,
                'lgas' => $lgas,
                'categories' => $categories,
                'user' => $user,
            );

            return view('user.pages.address')->with($data);
        }else {
            return redirect()->route('user.home');
        }
    }

    public function favouriteVendors() {
        if(Auth::check()) {
            $states = Location::where('type','=','State')->get() ;
            $lgas = Location::where('type','=','lga')->limit(5)->get() ;
            $categories = Vendor_category::all();
            $vendors = Vendors::join('menus', 'menus.vendor_id', '=', 'vendors.id')
                        ->join('favourite_vendors', 'favourite_vendors.vendor_id', '=', 'vendors.id')
                        ->select('vendors.*',DB::raw('min(menus.price) as price'))
                        ->where(['favourite_vendors.user_id' => auth()->user()->id])
                        ->groupBy('favourite_vendors.id')->orderBy('favourite_vendors.id', 'desc')->get() ;

            $user = Customer::where(['user_id' => auth()->user()->id])->first() ;

            $data = array(
                'vendors' => $vendors,
                'states' => $states,
                'lgas' => $lgas,
                'categories' => $categories,
                'user' => $user,
            );

            return view('user.pages.fav_vendors')->with($data);
        }else {
            return redirect()->route('user.home');
        }
    }

    public function changePassword() {
        if(Auth::check()) {
            $states = Location::where('type','=','State')->get() ;
            $lgas = Location::where('type','=','lga')->limit(5)->get() ;
            $categories = Vendor_category::all();
            $user = Customer::where(['user_id' => auth()->user()->id])->first() ;

            $data = array(
                'states' => $states,
                'lgas' => $lgas,
                'categories' => $categories,
                'user' => $user,
            );
            return view('user.pages.password')->with($data);
        }else {
            return redirect()->route('user.home');
        }
    }

}
