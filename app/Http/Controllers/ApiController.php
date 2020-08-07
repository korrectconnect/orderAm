<?php

namespace App\Http\Controllers;

use App\Address;
use App\Cart;
use App\Coupon;
use App\Customer;
use App\Favourite_vendor;
use Carbon\CarbonInterval;
use App\Services\GoogleMaps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\AppResource;
use App\Location;
use App\Vendors;
use App\Menus;
use App\User;
use App\Menu_category;
use App\Order;
use App\Order_item;
use App\Order_status;
use App\Rider_order;
use App\Vendor_category;
use App\Vendor_rating;
use Carbon\Carbon;

class ApiController extends Controller
{
    //
    public function editUser(Request $request) {
        $user = Customer::where(['user_id' => auth()->user()->id]);

        if ($request->hasFile('file')) {

            $extension = $request->file('file')->getClientOriginalExtension();
            $filename = auth()->user()->id.'_image_'.time().'.'.$extension ;
            $image_path = $request->file('file')->storeAs('public/user', $filename) ;
            if($image_path) {
                $edit = Customer::insert([
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'phone' => $request->phone,
                    'image' => asset('storage/user/'.$filename),
                ]);
            }else {
                return response()->json(['message' => 'Could not upload image'], 400);
            }
        }else {
            $edit = Customer::insert([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'phone' => $request->phone,
            ]);
        }

        if($edit) {
            return new AppResource($user);
        }else {
            return response()->json(['message' => 'Could not update profile'], 400);
        }
    }

    public function vendor($id) {
        $vendor = Vendors::leftJoin('menus', 'menus.vendor_id', '=', 'vendors.id')
                    ->select('vendors.*',DB::raw('min(menus.price) as price'))
                    ->where(['vendors.id' => $id])
                    ->first() ;

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
        $query =  Menu_category::where('vendor_id','=',$id)->get() ;

        return AppResource::collection($query);
    }

    public function searchVendors($key) {
        $search = Vendors::where('name','LIKE',"%$key%")->orderBy('id','desc')->get();

        return AppResource::collection($search);
    }

    public function searchVendorsByLocation(Request $request) {

        $search = Vendors::leftJoin('menus', 'menus.vendor_id', '=', 'vendors.id')
                    ->select('vendors.*',DB::raw('min(menus.price) as price'))
                    ->where([['vendors.type','=',$request->category],['vendors.state','=',$request->state],['vendors.lga','=',$request->lga]])
                    ->groupBy('vendors.id')->get() ;

                    if ($search->count() < 1) {
                        $search = Vendors::leftJoin('menus', 'menus.vendor_id', '=', 'vendors.id')
                                ->select('vendors.*',DB::raw('min(menus.price) as price'))
                                ->where([['vendors.type','=',$request->category],['vendors.state','=',$request->state]])
                                ->groupBy('vendors.id')->get() ;
                    }

        return AppResource::collection($search);
    }

    public function vendorsByLocation($category,$state,$lga) {

        $search = Vendors::leftJoin('menus', 'menus.vendor_id', '=', 'vendors.id')
                    ->select('vendors.*',DB::raw('min(menus.price) as price'))
                    ->where([['vendors.type','=',$category],['vendors.state','=',$state],['vendors.lga','=',$lga]])
                    ->groupBy('vendors.id')->get() ;
        if ($search->count() < 1) {
            $search = Vendors::leftJoin('menus', 'menus.vendor_id', '=', 'vendors.id')
                    ->select('vendors.*',DB::raw('min(menus.price) as price'))
                    ->where([['vendors.type','=',$category],['vendors.state','=',$state]])
                    ->groupBy('vendors.id')->get() ;
        }

        return AppResource::collection($search);
    }

    public function makeOrder(Request $request) {
        $vendor = Vendors::findOrFail($request->vendor_id);
        $vendorC = Vendor_category::where(['name' => $vendor->type])->first();
            if((date("H.i") < $vendor->opening) || (date("H.i") >= $vendor->closing)) {
                return response()->json(['message'=>'Vendor is closed'], 400);
            }
            if($request->coupon == "") {
                $coupon = NULL ;
                $coupon_amount = 0 ;
            }else {
                $date = Carbon::today();
                $getCoupon = Coupon::where('code','=',$request->coupon)->whereDate('expire', '>=', $date)->first();

                if ($getCoupon != NULL) {
                    if(($getCoupon->vendor_id != NULL) && ($getCoupon->vendor_id != $vendor->id)) {
                        $coupon = NULL ;
                        $coupon_amount = 0 ;
                    }else {
                        $checkUser = Order::where(['user_id' => auth()->user()->id])->get();
                        if ($getCoupon->count == 0) {
                            if ($checkUser->count() >= 1) {
                                $coupon = NULL ;
                                $coupon_amount = 0 ;
                            }else {
                                $coupon = $request->coupon ;
                                $coupon_amount = $getCoupon->amount ;
                            }
                        } else {
                            if ($checkUser->count() >= $getCoupon->count) {
                                $coupon = NULL ;
                                $coupon_amount = 0 ;
                            }else {
                                $coupon = $request->coupon ;
                                $coupon_amount = $getCoupon->amount ;
                            }
                        }
                    }

                }else {
                    $coupon = NULL ;
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
                return response()->json(['message'=>'Cart is empty'], 400);
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
            $order->transaction_id = $request->transaction_id;
            $order->coupon_code = $coupon;
            $order->address = $request->address_id;
            $order->payment_mode = $request->payment_type;
            $order->delivery_charge = $vendor->delivery_charge;
            $order->vendor_charge = $vendor->vendor_charge;
            $order->total = $total;
            $order->tax = $vendor->tax;
            $order->delivery_time = $request->delivery_time;
            $order->balance = 0;
            $order->Commission = $vendorC->Commission;
            $order->status = 0;
            $order->cancelled = 0;

            if($order->save()) {
                Cart::where(['vendor_id' => $request->vendor_id])->delete();
                Rider_order::insert([
                    'order_no' => $order_no,
                ]);
                return new AppResource($order);
            }else {
                Order_item::where(['order_no' => $order_no])->delete();
                return response()->json(['message'=>'Could not place order'], 400);
            }
    }

    public function allOrder() {
        $order = Order::where('user_id',auth()->user()->id)->get();
        if ($order->count() >= 1) {
            return AppResource::collection($order);
        } else {
            return response()->json(['message'=>'Order list is empty']);
        }

    }

    public function runningOrder() {
        $order = Order::where(['status' => 0, 'cancelled' => 0])->orWhere(['status' => 1, 'cancelled' => 0])->get();
        if ($order->count() >= 1) {
            return AppResource::collection($order);
        } else {
            return response()->json(['message'=>'Order list is empty']);
        }

    }

    public function completedOrder() {
        $order = Order::where(['status' => 2, 'cancelled' => 0])->get();
        if ($order->count() >= 1) {
            return AppResource::collection($order);
        } else {
            return response()->json(['message'=>'Order list is empty']);
        }

    }

    public function favouriteVendor(Request $request) {
        $fav = Favourite_vendor::where(['user_id' => auth()->user()->id, 'vendor_id' => $request->vendor_id]);

        if($fav->first() == NULL) {
             $query = Favourite_vendor::insert([
                 'user_id' => auth()->user()->id,
                 'vendor_id' => $request->vendor_id,
             ]);
             return response()->json(['message' => 'Vendor has been added to favourites']);
        }else {
             $query = $fav->delete();
             return response()->json(['message' => 'Vendor has been removed from favourites']);
        }
    }

    public function getFavouriteVendors() {
        $fav = Favourite_vendor::join('vendors','vendors.id','=','favourite_vendors.vendor_id')
                                ->select('vendors.*')
                                ->where(['favourite_vendors.user_id' => auth()->user()->id])
                                ->get();

        if ($fav->count() >= 1) {
            return AppResource::collection($fav);
        } else {
            return response()->json(['message'=>'You have not added any vendor to favourites']);
        }

    }

    public function rateVendor(Request $request) {
        $rating = Vendor_rating::where(['user_id' => auth()->user()->id, 'order_no' => $request->order_no])->first() ;

        if($rating == NULL) {
            $rate = new Vendor_rating ;
            $rate->user_id = auth()->user()->id;
            $rate->vendor_id = $request->vendor_id;
            $rate->rating = $request->rating;
            $rate->order_no = $request->order_no;
            $rate->comment = $request->comment;

            if ($rate->save()) {
                return response()->json(['message'=>'Thank you for your rating'], 200);
            }else {
                return response()->json(['message'=>'Could not rate vendor'], 400);
            }
        }else {
            return response()->json(['message'=>'You have already rated vendor on this order']);
        }
    }

    public function checkUserRating($order) {
        $rate = Vendor_rating::where(['user_id' => auth()->user()->id, 'order_no' => $order])->first();

        if ($rate != NULL) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 201]);
        }

    }

    public function checkVendorRating($id) {
        $rating = Vendor_rating::where('vendor_id', $id)->get() ;
        if ($rating->count() >= 1) {
            $r = 0 ;

            foreach($rating as $rate) {
                $r = $r + $rate->rating ;
            }

            $vendor_rating = $r/$rating->count() ;
            return response()->json(['rating' => $vendor_rating], 200);
        } else {
            return response()->json(['rating' => 0], 200);
        }

    }

    public function saveAddress(Request $request) {
        $address = new Address ;

        $address->user_id = auth()->user()->id;
        $address->state = $request->state;
        $address->lga = $request->lga;
        $address->address = $request->address;
        $address->phone = $request->phone;
        $address->description = $request->description;
        $address->default = NULL ;

        if ($address->save()) {
            if (Address::where(['user_id' => auth()->user()->id])->get()->count() == 1) {
                $getAddress = Address::where(['user_id' => auth()->user()->id])->firstOrFail();
                $updateUser = Customer::where(['user_id' => auth()->user()->id])->update([
                    'address_id' => $getAddress->id,
                ]);
                $updateAddress = $getAddress->update([
                    'default' => 1,
                ]) ;

                return new AppResource($address);
            }else {
                return new AppResource($address);
            }
        }else {
            return response()->json(['status' => 400]);
        }
    }

    public function editAddress(Request $request) {
        $get = Address::where(['user_id' => auth()->user()->id, 'id' => $request->address_id]);
        if($get->first() == NULL) {
            return response()->json(['message'=>'Invalid Address'], 400);
        }else {
            $edit = $get->update([
                'address' => $request->address,
                'description' => $request->description,
                'phone' => $request->phone,
            ]);

            if($edit) {
                return new AppResource($get->first());
            }else {
                return response()->json(['message'=>'Error editing Address'], 400);
            }
        }
    }

    public function getSingleAddress($id) {
        $get = Address::where(['id' => $id])->first();
        if ($get != NULL) {
            return new AppResource($get);
        }else {
            return response()->json(['message'=>'Invalid Address'], 400);
        }
    }

    public function setDefaultAddress(Request $request) {
        $updateAddressToNULL = DB::table('address')->update(['default' => NULL]);
        $user = Customer::where(['user_id' => auth()->user()->id])->update(['address_id' => $request->address_id]);
        $updateAddressDefault = Address::findOrFail($request->address_id);
        $updateAddressDefault->update(['default' => 1]);
        return new AppResource($updateAddressDefault);
    }

    public function getDefaultAddress() {
        $address = Address::where([['user_id','=',auth()->user()->id],['default','=',1]])->firstOrFail();

        return new AppResource($address);
    }

    public function getAddress() {
        $address = Address::where('user_id',auth()->user()->id)->get();
        return AppResource::collection($address);
    }

    public function deleteAddress($id) {
        $address = Address::where(['id' => $id]) ;
        $get = $address->first();
        $user = Customer::where(['user_id' => auth()->user()->id]);

        if ($address->delete()) {
            if($user->address_id == $id) {
                $updateUser = Customer::where(['user_id' => auth()->user()->id])->update(['address_id' => NULL]);
                return new AppResource($get);
            }
            return new AppResource($get);
        }else {
            return response()->json(['status' => 400]);
        }
    }

    public function addToCart(Request $request) {
        $get = Cart::where([['user_id','=',auth()->user()->id],['menu_id','=',$request->menu_id]])->first();

        $getMenu = Menus::where(['id' => $request->menu_id])->first();
        $vendor = Vendors::findOrFail($getMenu->vendor_id);
        if((date("H.i") < $vendor->opening) || (date("H.i") >= $vendor->closing)) {
            return response()->json(['message' => 'Vendor is closed'], 400);
        }

        if($get != null) {
            $quantity = $get->quantity + 1;
            $update = Cart::where([['menu_id','=',$request->menu_id],['user_id','=',auth()->user()->id]])->update(['quantity' => $quantity]);
            $getCart = Cart::where([['user_id','=',auth()->user()->id],['menu_id','=',$request->menu_id]])->first();
            if ($update) {
                return new AppResource($getCart);
            }else {
                return response()->json(['status' => 400]);
            }
        }else {

            $cart = new Cart ;
            $cart->user_id = auth()->user()->id;
            $cart->menu_id = $request->menu_id;
            $cart->vendor_id = $getMenu->vendor_id;
            $cart->quantity = 1;
            $cart->name = $getMenu->menu;
            $cart->price = $getMenu->price;

            if ($cart->save()) {
                return new AppResource($cart);
            }else {
                return response()->json(['status' => 400]);
            }
        }
    }

    public function vendorsCategory() {
        $query = Vendor_category::all();

        return AppResource::collection($query);
    }

    public function cart($id) {
        $query = Cart::where(['user_id' => auth()->user()->id, 'vendor_id' => $id])->get();

        return AppResource::collection($query);
    }

    public function deleteCart($id) {
        $delete = Cart::where(['id' => $id])->firstOrFail() ;

        if ($delete->delete()) {
            return new AppResource($delete);
        }else {
            return response()->json(['status' => 400]);
        }
    }

    public function clearCart($id) {
        $delete = Cart::where(['user_id' => auth()->user()->id, 'vendor_id' => $id])->delete() ;

        if ($delete) {
            return response()->json(['status' => 200]);
        }else {
            return response()->json(['status' => 400]);
        }
    }

    public function decreaseCart($id, Request $request) {
        $cart = Cart::where(['id' => $id]);
        $getCart = $cart->first();
        $vendor = Vendors::findOrFail($getCart->vendor_id);
        if((date("H.i") < $vendor->opening) || (date("H.i") >= $vendor->closing)) {
            return response()->json(['message' => 'Vendor is closed'], 400);
        }

        if($getCart->quantity > 1) {
            $update = $cart->update(['quantity' => $getCart->quantity - 1]) ;
        }else {
            $update = $cart->delete();
        }

        if($update) {
            return new AppResource($cart->first());
        }else {
            return response()->json(['status'=> 400]);
        }
    }

    public function increaseCart($id, Request $request) {
        $cart = Cart::where(['id' => $id]);
        $getCart = $cart->first();
        $vendor = Vendors::findOrFail($getCart->vendor_id);
        if((date("H.i") < $vendor->opening) || (date("H.i") >= $vendor->closing)) {
            return response()->json(['message' => 'Vendor is closed'], 400);
        }

        $update = $cart->update(['quantity' => $getCart->quantity + 1]) ;

        if($update) {
            return new AppResource($cart->first());
        }else {
            return response()->json(['status' => 400]);
        }
    }

    public function checkCoupon(Request $request) {
        $date = Carbon::today();
        $coupon = Coupon::where('code','=',$request->coupon)->whereDate('expire', '>=', $date)->first();
        if ($coupon != NULL) {
            if(($coupon->vendor_id != NULL) && ($coupon->vendor_id != $request->vendor_id)) {
                return response()->json(['message'=>'Coupon does not apply to this vendor'], 400);
            }else {
                $checkUser = Order::where(['user_id' => auth()->user()->id])->get();
                if ($coupon->count == 0) {
                    if ($checkUser->count() >= 1) {
                        return response()->json(['message'=>'Coupon only applies to first time users'], 400);
                    }
                    return new AppResource($coupon);
                } else {
                    if ($checkUser->count() >= $coupon->count) {
                        return response()->json(['message'=>'Coupon max reached'], 400);
                    }
                    return new AppResource($coupon);
                }
            }
        }else {
            return response()->json(['message'=>'Expired or invalid Coupon'], 400);
        }
    }

    public function vendorsFeatured($category, $state) {
        $vendors = Vendors::where(['type' => $category, 'state' => $state])->inRandomOrder()->limit(5)->get();

        return AppResource::collection($vendors);
    }

    public function state() {
        $query = Location::where('type','=','state')->get();

        return AppResource::collection($query);
    }

    public function lga() {
        $query = Location::where('type','=','lga')->get();

        return AppResource::collection($query);
    }

    public function area() {
        $query = Location::where('type','=','area')->get();

        return AppResource::collection($query);
    }

    public function getDistance($order_id)
    {
        $order_details = OrderLocationDetails::find($order_id);

        $distance = GoogleMaps::getDistance($order_details->user_lat, $order_details->user_long, $order_details->vendor_lat, $order_details->vendor_long);

        return new AppResource($distance);
    }

    public function getDistanceRider($order_id)
    {
        $order_details = OrderLocationDetails::find($order_id);
        $rider_location = CurrentLocation::get('129.205.124.7');//CurrentLocation::get(request()->ip());
        $getUserDistance = GoogleMaps::getDistance($order_details->user_lat, $order_details->user_long, $order_details->vendor_lat, $order_details->vendor_long);
        $getVendorDistance = GoogleMaps::getDistance($order_details->vendor_lat, $order_details->vendor_long, $rider_location->latitude, $rider_location->longitude);

        $total_time = $getUserDistance['duration'] + $getVendorDistance['duration'];

        return response()->json(['total_time' => CarbonInterval::seconds($total_time)->cascade()->forHumans(),
                                'getUserDistance' => $getUserDistance, 'getVendorDistance' => $getVendorDistance]);
    }

}
