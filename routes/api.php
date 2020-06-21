<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
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

Route::group(['middleware' => ['auth:api']], function() {

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
    Route::get('/vendors/featured/{limit}', 'ApiController@vendorsFeatured'); // limit
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

});

Route::get('/test/{id}/{name}', 'ApiController@test');

