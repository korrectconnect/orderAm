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

    Route::post('/users/update/{id}', 'ApiController@editUser');
    Route::get('/vendor/{id}', 'ApiController@vendor');
    Route::get('/vendors', 'ApiController@vendors');
    Route::get('/vendors/{p}', 'ApiController@vendors');
    Route::get('/menu/{id}', 'ApiController@getMenus');
    Route::get('/menu/{id}/{p}', 'ApiController@getMenus');
    Route::get('/menu/c/{id}', 'ApiController@getMenusCategory');
    Route::get('/menu/{id}/c/{category}', 'ApiController@getMenusByCategory');
    Route::get('/menu/{id}/c/{category}/{p}', 'ApiController@getMenusByCategory');
    Route::get('/vendors/s/{key}', 'ApiController@searchVendors');
    Route::get('/vendors/s/{key}/{p}', 'ApiController@searchVendors');

});

