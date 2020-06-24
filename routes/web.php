<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::group(['middleware' => ['get.menu']], function () {

    Route::get('/testing', 'AjaxController@testing');
    Route::get('/colors', function () {     return view('dashboard.colors'); });
    Route::prefix('vendor')->group(function(){
        Route::get('/add', function() { return view('dashboard.vendor.add'); })->name('vendor.add');
        Route::get('/edit', function() { return view('dashboard.vendor.edit'); })->name('vendor.edit');
        Route::get('/', function() { return view('dashboard.vendor.view'); })->name('vendor.view');
    });
    Route::prefix('menu')->group(function(){
        Route::get('/add', function() { return view('dashboard.menu.add'); })->name('menu.add');
        Route::get('/edit', function() { return view('dashboard.menu.edit'); })->name('menu.edit');
        Route::get('/', function() { return view('dashboard.menu.view'); })->name('menu.view');
    });

   Route::get('/', 'UsersController@home')->name('user.home');
   Route::get('vendors/{name}', 'UsersController@vendors')->name('user.vendors');
   Route::get('vendors', 'UsersController@vendorsHome')->name('user.vendors.home');
   Route::get('vendors/{id}/{name}', 'UsersController@vendorSingle')->name('user.vendor');
   Route::get('order/{id}/process', 'UsersController@orderProcess')->name('user.order.process');
   Route::get('order/success', 'UsersController@orderSuccess')->name('user.order.success');
   Route::get('user/profile', 'UsersController@profile')->name('user.profile');
   Route::get('user/orders', 'UsersController@orders')->name('user.orders');
   Route::get('user/address', 'UsersController@address')->name('user.address.book');
   Route::get('user/vendor/favourite', 'UsersController@favouriteVendors')->name('user.vendor.favourite');
   Route::get('user/password/change', 'UsersController@changePassword')->name('user.password.change');


   Route::post('logout', 'UsersController@logout')->name('logout');
   Route::post('order/place', 'UsersController@placeOrder')->name('user.order.place');


   //Ajax Requests
   Route::post('request/vendor/location', 'AjaxController@storeLocationToSession');
   Route::post('request/cart', 'AjaxController@addToCart');
   Route::post('request/login', 'AjaxController@login')->name('user.login');
   Route::post('request/register', 'AjaxController@register')->name('user.register');
   Route::post('request/address', 'AjaxController@addAddress')->name('user.address');
   Route::post('request/coupon', 'AjaxController@checkCoupon');
   Route::post('request/address/edit', 'AjaxController@editAddresss')->name('user.address.edit');
   Route::post('request/profile/edit', 'AjaxController@editProfile')->name('user.profile.edit');
   Route::post('user/password/change', 'AjaxController@changePassword')->name('user.password.change');

   Route::get('request/menu/{vendor}/{category}', 'AjaxController@getVendorMenu');
   Route::get('request/login', 'AjaxController@loginFrom')->name('user.login');
   Route::get('request/cart/{id}', 'AjaxController@cart');
   Route::get('request/cart/delete/{id}', 'AjaxController@deleteCart');
   Route::get('request/cart/increase/{id}', 'AjaxController@increaseCart');
   Route::get('request/cart/decrease/{id}', 'AjaxController@decreaseCart');
   Route::get('request/register', 'AjaxController@registerFrom')->name('user.register');
   Route::get('request/recover', 'AjaxController@recoverFrom')->name('user.recover');
   Route::get('request/address', 'AjaxController@addressForm')->name('user.address');
   Route::get('request/address/edit/{id}', 'AjaxController@editAddresssForm')->name('user.address.edit.form');
   Route::get('request/address/delete/{id}', 'AjaxController@deleteAddresss')->name('user.address.delete');
   Route::get('request/address/dafault/{id}', 'AjaxController@makeDefaultAddresss')->name('user.address.default');
   Route::get('request/order/{id}/summary/{address}/{type}/{coupon}', 'AjaxController@orderSummary')->name('user.order.summary');
   Route::get('request/user/order/{no}', 'AjaxController@myOrderSummary')->name('user.myorder');
   Route::get('request/vendor/favourite/{id}', 'AjaxController@favouriteVendor')->name('user.vendor.favourite.toggle');


   Route::get('request/test', 'AjaxController@test');



    Route::prefix('helper')->group(function(){
        Route::get('/colors', function () {     return view('dashboard.colors'); });
        Route::get('/typography', function () { return view('dashboard.typography'); });
        Route::get('/charts', function () {     return view('dashboard.charts'); });
        Route::get('/widgets', function () {    return view('dashboard.widgets'); });
        Route::get('/404', function () {        return view('dashboard.404'); });
        Route::get('/500', function () {        return view('dashboard.500'); });
        Route::prefix('base')->group(function () {
            Route::get('/breadcrumb', function(){   return view('dashboard.base.breadcrumb'); });
            Route::get('/cards', function(){        return view('dashboard.base.cards'); });
            Route::get('/carousel', function(){     return view('dashboard.base.carousel'); });
            Route::get('/collapse', function(){     return view('dashboard.base.collapse'); });

            Route::get('/forms', function(){        return view('dashboard.base.forms'); });
            Route::get('/jumbotron', function(){    return view('dashboard.base.jumbotron'); });
            Route::get('/list-group', function(){   return view('dashboard.base.list-group'); });
            Route::get('/navs', function(){         return view('dashboard.base.navs'); });

            Route::get('/pagination', function(){   return view('dashboard.base.pagination'); });
            Route::get('/popovers', function(){     return view('dashboard.base.popovers'); });
            Route::get('/progress', function(){     return view('dashboard.base.progress'); });
            Route::get('/scrollspy', function(){    return view('dashboard.base.scrollspy'); });

            Route::get('/switches', function(){     return view('dashboard.base.switches'); });
            Route::get('/tables', function () {     return view('dashboard.base.tables'); });
            Route::get('/tabs', function () {       return view('dashboard.base.tabs'); });
            Route::get('/tooltips', function () {   return view('dashboard.base.tooltips'); });
        });
        Route::prefix('buttons')->group(function () {
            Route::get('/buttons', function(){          return view('dashboard.buttons.buttons'); });
            Route::get('/button-group', function(){     return view('dashboard.buttons.button-group'); });
            Route::get('/dropdowns', function(){        return view('dashboard.buttons.dropdowns'); });
            Route::get('/brand-buttons', function(){    return view('dashboard.buttons.brand-buttons'); });
        });
        Route::prefix('icon')->group(function () {  // word: "icons" - not working as part of adress
            Route::get('/coreui-icons', function(){         return view('dashboard.icons.coreui-icons'); });
            Route::get('/flags', function(){                return view('dashboard.icons.flags'); });
            Route::get('/brands', function(){               return view('dashboard.icons.brands'); });
        });
        Route::prefix('notifications')->group(function () {
            Route::get('/alerts', function(){   return view('dashboard.notifications.alerts'); });
            Route::get('/badge', function(){    return view('dashboard.notifications.badge'); });
            Route::get('/modals', function(){   return view('dashboard.notifications.modals'); });
        });
    });

    //Auth::routes();


    //ADMIN ROUTES

    Route::get('/adminredirect', function() {return redirect('/adminredirect/dashboard'); });

    Route::group(['prefix' => 'adminredirect'], function() {

        // Login Routes...
            Route::get('login', ['as' => 'admin.login', 'uses' => 'AdminAuth\LoginController@showLoginForm']);
            Route::post('login', [ 'uses' => 'AdminAuth\LoginController@login']);
            Route::post('logout', ['as' => 'admin.logout', 'uses' => 'AdminAuth\LoginController@logout']);

        // Registration Routes...
            Route::get('register', ['as' => 'admin.register', 'uses' => 'AdminAuth\RegisterController@showRegistrationForm']);
            Route::post('register', ['as' => 'admin.register.post', 'uses' => 'AdminAuth\RegisterController@register']);

        // Password Reset Routes...
            Route::get('password/reset', ['as' => 'password.reset', 'uses' => 'AdminAuth\ForgotPasswordController@showLinkRequestForm']);
            Route::post('password/email', ['as' => 'password.email', 'uses' => 'AdminAuth\ForgotPasswordController@sendResetLinkEmail']);
            Route::get('password/reset/{token}', ['as' => 'password.reset.token', 'uses' => 'AdminAuth\ResetPasswordController@showResetForm']);
            Route::post('password/reset', ['as' => 'password.reset.post', 'uses' => 'AdminAuth\ResetPasswordController@reset']);
    });

    Route::group(['middleware' => ['admin'],'prefix' => 'adminredirect'], function() {

        Route::get('dashboard', ['as' => 'admin.dashboard', 'uses' => 'AdminController@dashboard']);
        Route::get('vendor/location', ['as' => 'admin.vendor.location', 'uses' => 'AdminController@location']);
        Route::get('vendor/add', ['as' => 'admin.vendor.add', 'uses' => 'AdminController@addVendorForm']);
        Route::get('vendor/category', ['as' => 'admin.vendor.category', 'uses' => 'AdminController@vendorCategory']);
        Route::get('vendor', ['as' => 'admin.vendor.view', 'uses' => 'AdminController@vendors']);
        Route::get('rider/add', ['as' => 'admin.rider.add', 'uses' => 'AdminController@addRiderForm']);
        Route::get('rider/category', ['as' => 'admin.rider.category', 'uses' => 'AdminController@riderCategory']);
        Route::get('rider/locations', ['as' => 'admin.rider.locations', 'uses' => 'AdminController@ridersLocation']);
        Route::get('rider', ['as' => 'admin.rider.view', 'uses' => 'AdminController@riders']);
        Route::get('rider/{id}/view', ['as' => 'admin.rider.single', 'uses' => 'AdminController@singleRider']);
        Route::get('vendor/{id}', ['uses' => 'AdminController@vendor']);
        Route::get('menus', ['as' => 'admin.menus', 'uses' => 'AdminController@menus']);
        Route::get('orders', ['as' => 'admin.orders', 'uses' => 'AdminController@orders']);
        Route::get('menus/view/{id}', ['uses' => 'AdminController@menu']);
        Route::get('vendor/auth/{id}', 'AdminController@vendorAuth')->name('admin.vendor.auth');


        //Ajax Requests

        Route::post('vendor/add', ['as' => 'admin.vendor.add', 'uses' => 'AdminAjaxController@addVendor']);
        Route::post('vendor/category', 'AdminAjaxController@addVendorCategory');
        Route::post('vendor/location', 'AdminAjaxController@addVendorLocation');
        Route::post('rider/add', 'AdminAjaxController@addRider')->name('admin.rider.add');
        Route::post('rider/category', 'AdminAjaxController@addRiderCategory')->name('admin.rider.category');
        Route::post('menus/add', ['as' => 'admin.menu.add', 'uses' => 'AdminAjaxController@addMenu']);
        Route::post('menuCategory/add', ['as' => 'admin.menu_category.add', 'uses' => 'AdminAjaxController@addMenuCategory']);
        Route::post('menuCategory/delete', ['as' => 'admin.menu_category.delete', 'uses' => 'AdminAjaxController@deleteMenuCategory']);
        Route::post('ajax/rider/assign', 'AdminAjaxController@assignRider')->name('admin.assign.rider');

        Route::get('ajax/viewVendor/{id}', ['as' => 'admin.ajax.vendor.view', 'uses' => 'AdminAjaxController@viewVendor']);
        Route::get('ajax/addMenuFrom/{id}', [ 'uses' => 'AdminAjaxController@addMenuFrom']);
        Route::get('ajax/deleteVendorCategory/{id}', 'AdminAjaxController@deleteVendorCategory');
        Route::get('ajax/deleteVendorLocation/{id}', 'AdminAjaxController@deleteVendorLocation');
        Route::get('ajax/refreshMenu', [ 'uses' => 'AdminAjaxController@refreshMenus']);
        Route::get('ajax/refreshVendorCategory', [ 'uses' => 'AdminAjaxController@refreshVendorCategory']);
        Route::get('ajax/refreshVendorLocation', [ 'uses' => 'AdminAjaxController@refreshVendorLocation']);
        Route::get('ajax/refreshMenu/{id}', [ 'uses' => 'AdminAjaxController@refreshMenu']);
        Route::get('ajax/getMenuCategoryList/{id}', ['uses' => 'AdminAjaxController@getMenuCategoryList']);
        Route::get('ajax/deleteMenu/{id}', ['as' => 'admin.menu.delete', 'uses' => 'AdminAjaxController@deleteMenu']);
        Route::get('ajax/deleteVendor/{id}', ['as' => 'admin.vendor.delete', 'uses' => 'AdminAjaxController@deleteVendor']);
        Route::get('ajax/searchVendor/{key}', ['as' => 'admin.vendor.search', 'uses' => 'AdminAjaxController@searchVendor']);
        Route::get('ajax/cancelOrder/{id}', ['as' => 'admin.order.cancel', 'uses' => 'AdminAjaxController@cancelOrder']);
        Route::get('ajax/rider/category/{id}/delete', 'AdminAjaxController@deleteRiderCategory')->name('admin.rider.category.delete');
        Route::get('ajax/rider/{id}/assign', 'AdminAjaxController@assignRiderForm')->name('admin.rider.assign');
        Route::get('ajax/rider/{id}/unassign', 'AdminAjaxController@unassignRider')->name('admin.rider.unassign');
        Route::get('ajax/rider/{location}/location/assign', 'AdminAjaxController@riderByAssignedLocation')->name('admin.rider.location.assign');
        //End Ajax Request

    });



    //VENDOR ROUTE


    Route::get('/vendorredirect', function() {return redirect('/vendorredirect/dashboard'); });

    Route::group(['prefix' => 'vendorredirect'], function() {

        // Login Routes...
            Route::get('login', ['as' => 'vendor.login', 'uses' => 'VendorAuth\LoginController@showLoginForm']);
            Route::post('login', ['as' => 'vendor.login', 'uses' => 'VendorAuth\LoginController@login']);
            Route::post('logout', ['as' => 'vendor.logout', 'uses' => 'VendorAuth\LoginController@logout']);
    });

    Route::group(['middleware' => ['vendor'],'prefix' => 'vendorredirect'], function() {

        Route::get('dashboard', ['as' => 'vendor.dashboard', 'uses' => 'VendorController@dashboard']);
        Route::get('menu_list', ['as' => 'vendor.menus', 'uses' => 'VendorController@menus']);
        Route::get('profile', ['as' => 'vendor.profile', 'uses' => 'VendorController@profile']);
        Route::get('authenticate-admin', ['as' => 'vendor.authAdmin', 'uses' => 'VendorController@authAdmin']);

        Route::post('authenticate-admin', ['as' => 'vendor.authAdmin', 'uses' => 'VendorController@authenticateAdmin']);
        Route::post('authenticate-admin/logout', ['as' => 'vendor.authAdminLogout', 'uses' => 'VendorController@authenticateAdminLogout']);


        //Ajax Requests

        Route::get('request/orders/{status}/{cancelled}', 'VendorAjaxController@orders')->name('vendor.ajax.orders');
        Route::get('request/order/{order_no}', 'VendorAjaxController@order')->name('vendor.ajax.order');
        Route::get('request/order/{order_no}/confirm', 'VendorAjaxController@confirmOrder')->name('vendor.order.confirm');
        Route::get('request/order/{order_no}/decline', 'VendorAjaxController@declineOrder')->name('vendor.order.decline');
        Route::get('request/menu_list/{category}', 'VendorAjaxController@getMenuList')->name('vendor.menu_list');
        Route::get('menu/add', 'VendorAjaxController@menuForm')->name('vendor.menu.add');
        Route::get('menu_category/add', 'VendorAjaxController@menuCategoryForm')->name('vendor.menu_category.add');
        Route::get('menu_category/edit/{id}', 'VendorAjaxController@editMenuCategoryForm')->name('vendor.menu_category.edit.form');
        Route::get('menu_category/delete/{id}', 'VendorAjaxController@deleteMenuCategory')->name('vendor.menu_category.delete');
        Route::get('menu/stock/{id}', 'VendorAjaxController@toggleMenuStock')->name('vendor.menu.stock');
        Route::get('menu/edit/{id}', 'VendorAjaxController@editMenuForm')->name('vendor.menu.edit.form');
        Route::get('menu/delete/{id}', 'VendorAjaxController@deleteMenu')->name('vendor.menu.delete');

        Route::post('menu/add', 'VendorAjaxController@addMenu')->name('vendor.menu.add');
        Route::post('menu_category/add', 'VendorAjaxController@addMenuCategory')->name('vendor.menu_category.add');
        Route::post('menu_category/edit', 'VendorAjaxController@editMenuCategory')->name('vendor.menu_category.edit');
        Route::post('menu/edit', 'VendorAjaxController@editMenu')->name('vendor.menu.edit');


        //End Ajax Request

    });
