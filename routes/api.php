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

    Route::post('/users/update', 'ApiController@editUser');
    Route::post('/makeOrder', 'ApiController@makeOrder');
    Route::post('/insertOrderItem', 'ApiController@insertOrderItem');
    Route::post('/insertOrderStatus', 'ApiController@insertOrderStatus');
    Route::post('/cancelOrder', 'ApiController@cancelOrder');
    Route::post('/address', 'ApiController@saveAddress');
    Route::post('/address/delete', 'ApiController@deleteAddress');
    Route::post('/address/default', 'ApiController@setDefaultAddress');
    Route::post('/vendors/search', 'ApiController@searchVendorsByLocation');
    Route::post('/cart', 'ApiController@addToCart');

    Route::delete('/cart/{id}', 'ApiController@deleteCart');

    Route::get('/address', 'ApiController@getAddress');
    Route::get('/cart', 'ApiController@cart');
    Route::get('/state', 'ApiController@state');
    Route::get('/lga', 'ApiController@lga');
    Route::get('/area', 'ApiController@area');
    Route::get('/cart/clear', 'ApiController@clearCart');
    Route::get('/address/default', 'ApiController@getDefaultAddress');
    Route::get('/vendor/{id}', 'ApiController@vendor');
    Route::get('/vendors/category', 'ApiController@vendorsCategory');
    Route::get('/vendors/featured/{limit}', 'ApiController@vendorsFeatured');
    Route::get('/vendors', 'ApiController@vendors');
    Route::get('/menu/{id}', 'ApiController@getMenus');
    Route::get('/menu/c/{id}', 'ApiController@getMenusCategory');
    Route::get('/menu/{id}/c/{category}', 'ApiController@getMenusByCategory');
    Route::get('/vendors/search/{key}', 'ApiController@searchVendors');
    Route::get('/order', 'ApiController@allOrder');
    Route::get('/order/running', 'ApiController@runningOrder');
    Route::get('/order/completed', 'ApiController@completedOrder');

});

Route::get('/test/{id}/{name}', 'ApiController@test');

