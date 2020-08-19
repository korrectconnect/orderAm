<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
//use Illuminate\Routing\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', 'Api\authController@register');
Route::post('/login', 'Api\authController@login');
Route::post('/rider/login', 'Api\authController@loginRider');
Route::post('/vendor/login', 'Api\authController@loginVendor');


Route::group(['middleware' => ['auth:api']], function() {

    //ABEG NO DEY DELETE THESE THINGS. I USE GOD BEG YOU
    Route::get('/order/distance/{order_id}', 'ApiController@getDistance'); //ABEG NO DEY DELETE THESE THINGS. I USE GOD BEG YOU
    Route::get('/rider/distance/{order_id}', 'ApiController@getDistanceRider'); //ABEG NO DEY DELETE THESE THINGS. I USE GOD BEG YOU
    Route::get('/messages/{admin_rider_id}', 'MessagesController@privateMessages'); //ABEG NO DEY DELETE THESE THINGS. I USE GOD BEG YOU
    Route::post('/messages/{admin_rider_id}', 'MessagesController@sendMessage'); //ABEG NO DEY DELETE THESE THINGS. I USE GOD BEG YOU
    Route::get('/rider/profile', 'RidersController@getRiderProfile'); //ABEG NO DEY DELETE THESE THINGS. I USE GOD BEG YOU
    Route::get('/rider/client-info/{order_id}', 'RidersController@getClientInfo'); //ABEG NO DEY DELETE THESE THINGS. I USE GOD BEG YOU
    Route::get('/rider/order-info/{order_id}', 'RidersController@getOrderInfo'); //ABEG NO DEY DELETE THESE THINGS. I USE GOD BEG YOU
    Route::get('/rider/current-location', 'RidersController@getRidersLocation'); //ABEG NO DEY DELETE THESE THINGS. I USE GOD BEG YOU
    Route::get('/rider-order/{rider_id}/all', 'RidersController@getAllRiderOrders');
    Route::get('/rider-order/{rider_id}/all', 'RidersController@getAllRiderOrders');
    Route::get('/rider-order/{rider_id}/all/confirmed', 'RidersController@getAllRiderConfirmedOrders'); 
    Route::get('/rider-order/{order_no}/{rider_id}', 'RidersController@getRiderOrder'); //ABEG NO DEY DELETE THESE THINGS. I USE GOD BEG YOU
    Route::get('/rider-order/{order_no}/{rider_id}/confirmed', 'RidersController@getRiderConfirmedOrder');
    //ABEG NO DEY DELETE THESE THINGS. I USE GOD BEG YOU
    //ABEG NO DEY DELETE THESE THINGS. I USE GOD BEG YOU

    Route::post('/users/update', 'ApiController@editUser'); // firstname|lastname|phone
    Route::post('/makeOrder', 'ApiController@makeOrder'); // vendor_id|coupon|address_id|payment_type(card or cash)|transaction_id
    Route::post('/address', 'ApiController@saveAddress'); // state|lga|address|phone|description
    Route::post('/address/edit', 'ApiController@editAddress'); // address_id|address|phone|description
    Route::post('/address/default', 'ApiController@setDefaultAddress'); // address_id
    Route::post('/vendors/search', 'ApiController@searchVendorsByLocation'); // category(vendor category)|state|lga
    Route::post('/cart', 'ApiController@addToCart'); // menu_id
    Route::post('/rate/vendor', 'ApiController@rateVendor'); // vendor_id|rating|order_no|comment
    Route::post('/coupon', 'ApiController@checkCoupon'); // coupon|vendor_id
    Route::post('/favourite/vendor', 'ApiController@favouriteVendor'); // vendor_id

    Route::delete('/cart/{id}', 'ApiController@deleteCart'); // id(cart_id)
    Route::delete('/address/{id}', 'ApiController@deleteAddress'); // id(address_id)

    Route::get('/address', 'ApiController@getAddress');
    Route::get('/vendors/search/{category}/{state}/{lga}', 'ApiController@vendorsByLocation'); // category(vendor category)|state|lga
    Route::get('/address/{id}', 'ApiController@getSingleAddress'); // id(address_id)
    Route::get('/cart/{id}', 'ApiController@cart'); // id(Vendor_id)
    Route::get('/state', 'ApiController@state');
    Route::get('/lga', 'ApiController@lga');
    Route::get('/area', 'ApiController@area');
    Route::get('/cart/clear/{id}', 'ApiController@clearCart'); // id(Vendor_id)
    Route::get('/cart/decrease/{id}', 'ApiController@decreaseCart'); // id(cart_id)
    Route::get('/cart/increase/{id}', 'ApiController@increaseCart'); // id(cart_id)
    Route::get('/address/default', 'ApiController@getDefaultAddress');
    Route::get('/vendor/{id}', 'ApiController@vendor'); // id(Vendor_id)
    Route::get('/vendors/category', 'ApiController@vendorsCategory');
    Route::get('/favourite/vendor', 'ApiController@getFavouriteVendors');
    Route::get('/vendors/featured/{category}/{state}', 'ApiController@vendorsFeatured'); // limit
    Route::get('/vendors', 'ApiController@vendors');
    Route::get('/menu/{id}', 'ApiController@getMenus'); // id(Vendor_id)
    Route::get('/menu/c/{id}', 'ApiController@getMenusCategory'); // id(Vendor_id)
    Route::get('/menu/{id}/c/{category}', 'ApiController@getMenusByCategory'); // id(Vendor_id)|category(menu category)
    Route::get('/vendors/search/{key}', 'ApiController@searchVendors'); // key(search key)
    Route::get('/order', 'ApiController@allOrder');
    Route::get('/rate/check/{order}', 'ApiController@checkUserRating'); // order(order number)
    Route::get('/rate/vendor/{id}', 'ApiController@checkVendorRating'); // id(vendor_id)
    Route::get('/order/running', 'ApiController@runningOrder');
    Route::get('/order/completed', 'ApiController@completedOrder');




    Route::post('/vendor/auth/menu', 'Api\VendorController@addMenu');
    Route::post('/vendor/auth/menu/edit', 'Api\VendorController@editMenu');
    Route::delete('/vendor/auth/menu/{id}', 'Api\VendorController@deleteMenu');
    Route::get('/vendor/auth/menu', 'Api\VendorController@getMenu');
    Route::get('/vendor/auth/menu/unsorted', 'Api\VendorController@getUnsortedMenu');
    Route::get('/vendor/auth/menu/c/{category}', 'Api\VendorController@getMenuByCategory');

    Route::post('/vendor/auth/menu/category', 'Api\VendorController@addMenuCategory');
    Route::post('/vendor/auth/menu/category/edit', 'Api\VendorController@editMenuCategory');
    Route::delete('/vendor/auth/menu/category/{id}', 'Api\VendorController@deleteMenuCategory');
    Route::get('/vendor/auth/menu/category', 'Api\VendorController@getMenuCategory');

    Route::get('/vendor/auth/order/{id}', 'Api\VendorController@getOrder');
    Route::get('/vendor/auth/orders', 'Api\VendorController@getOrders');
    Route::get('/vendor/auth/orders/incoming', 'Api\VendorController@getIncomingOrders');
    Route::get('/vendor/auth/orders/pending', 'Api\VendorController@getPendingOrders');
    Route::get('/vendor/auth/orders/delivered', 'Api\VendorController@getDeliveredOrders');
    Route::get('/vendor/auth/orders/cancelled', 'Api\VendorController@getCancelledOrders');

    Route::get('/vendor/auth/orders/confirm/{id}', 'Api\VendorController@confirmOrders');
    Route::get('/vendor/auth/orders/decline/{id}', 'Api\VendorController@declineOrders');

    Route::post('/vendor/auth/password', 'Api\VendorController@changePassword');

});
