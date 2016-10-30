<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/* ======================== ADMIN ROUTES ============================== */

/*Route::get('/admin/', function(){
	if(Auth::guest()) { //return 'here';
		return Redirect::to('auth/login');	
	} else {
		return Redirect::to('admin/users');		
	}
	
});*/
Route::filter('Sentry', function()
{
	if ( Auth::guest()) {
 		return Redirect::to('admin')->with('error', 'You must be logged in!');
 	}
});

//Route::get('admin/product/index', 'ProductController@index');

// Route::get('admin/home', 'HomeController@index');

// Authentication routes...
Route::get('admin', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
/*Route::get('index', function()
{
    return View::make('admin/index');
});*/

Route::group(
	array('prefix' => 'admin/users','before' => 'Sentry'), function () {
		Route::get('add', array('as' => 'add/user', 'uses' => 'UsersController@addUsers'));
        Route::get('/', array('as' => 'users', 'uses' => 'UsersController@listUers'));
		Route::post('add', 'UsersController@createUser');
        Route::get('{id}/edit', array('as' => 'users.update', 'uses' => 'UsersController@getEdit'));
		Route::post('{id}/edit', 'UsersController@postEdit');
		Route::get('delete_user', array('as'=>'delete_user', 'uses' => 'UsersController@delete_user'));
		Route::get('{id}/delete', array('as' => 'delete/banner', 'uses' => 'UsersController@getDelete'));
		Route::get('{id}/confirm-delete', array('as' => 'confirm-delete/user', 'uses' => 'UsersController@getModalDelete'));
		
		//Route::get('{id}', array('as' => 'users.show', 'uses' => 'UsersController@show'));
	});
	
	
Route::group(
	array('prefix' => 'admin/shops','before' => 'Sentry'), function () {
		Route::get('add', array('as' => 'add/shop', 'uses' => 'ShopsController@addShops'));
        Route::get('/', array('as' => 'shops', 'uses' => 'ShopsController@listShops'));
		Route::post('add', 'ShopsController@createShop');
		//Route::get('{id}', array('as' => 'banners.show', 'uses' => 'ShopsController@show'));
        Route::get('{id}/edit', array('as' => 'shops.update', 'uses' => 'ShopsController@getEdit'));
		Route::post('{id}/edit', 'ShopsController@postEdit');
		Route::get('{id}/delete', array('as' => 'delete/banner', 'uses' => 'ShopsController@getDelete'));
		Route::get('{id}/confirm-delete', array('as' => 'confirm-delete/shop', 'uses' => 'ShopsController@getModalDelete'));
	});
// Vendors
Route::group(
	array('prefix' => 'admin/vendors','before' => 'Sentry'), function () {
		Route::get('add', array('as' => 'add/vendor', 'uses' => 'VendorController@addVendors'));
        Route::get('/', array('as' => 'vendors', 'uses' => 'VendorController@listVendors'));
		Route::post('add', 'VendorController@create');
		//Route::get('{id}', array('as' => 'banners.show', 'uses' => 'ShopsController@show'));
        Route::get('{id}/edit', array('as' => 'vendors.update', 'uses' => 'VendorController@getEdit'));
		Route::post('{id}/edit', 'VendorController@postEdit');
		Route::get('delete_vendor', array('as'=>'delete_vendor', 'uses' => 'VendorController@delete_vendor'));
		Route::get('{id}/delete', array('as' => 'delete/banner', 'uses' => 'VendorController@getDelete'));
		Route::get('{id}/confirm-delete', array('as' => 'confirm-delete/vendor', 'uses' => 'VendorController@getModalDelete'));
	});
// Product routs
Route::group(
	array('prefix' => 'admin/products','before' => 'Sentry'), function () {
		Route::get('add', array('as' => 'add/products', 'uses' => 'ProductsController@create'));
        Route::get('/', array('as' => 'products', 'uses' => 'ProductsController@index'));
		Route::post('add', 'ProductsController@store');
		//Route::get('{id}', array('as' => 'products.show', 'uses' => 'ProductsController@show'));
        Route::get('{id}/edit', array('as' => 'products.update', 'uses' => 'ProductsController@getEdit'));
		Route::post('{id}/edit', 'ProductsController@postEdit');
		Route::get('{id}/delete', array('as' => 'delete/banner', 'uses' => 'ProductsController@getDelete'));
		Route::get('{id}/confirm-delete', array('as' => 'confirm-delete/user', 'uses' => 'ProductsController@getModalDelete'));
	});

Route::group(

	array('prefix' => 'admin/reports','before' => 'Sentry'), function () {
//echo "adfad"; die;
// Show all sale 
// Route::get('all_sale', array('uses' => 'SaleController@all_sale'));

// // Show today sale 
// Route::get('today_sale', array('uses' => 'SaleController@today_sale'));
// Show all sale 
Route::get('all_sale', array('as' => 'all_sale', 'uses' => 'SaleController@all_sale'));

// Show today sale 
Route::get('today_sale', array('as' => 'today_sale', 'uses' => 'SaleController@today_sale'));

// Search Flavour Sale with given date
//Route::get('frm_search_flavour', array('as' => 'frm_search_flavour', 'uses' => 'SaleController@flavour_sale'));

// Search Flavour Sale with given date
Route::post('flavour_sale', array('as' => 'flavour_sale', 'uses' => 'SaleController@flavour_sale'));

// Show today Flavour wise sale 
Route::get('flavour_sale', array('as' => 'flavour_sale', 'uses' => 'SaleController@flavour_sale'));



});

// invoice 
Route::group(

	array('prefix' => 'admin/invoice','before' => 'Sentry'), function () {

// Show return invoice 
Route::get('return_invoice', array('as' => 'return_invoice', 'uses' => 'SaleController@return_invoice'));

// Show all return invoice 
Route::get('view_return_invoice', array('as' => 'view_return_invoice', 'uses' => 'SaleController@get_return_invoice'));


// Search Return Invoice
Route::post('search_return_invoice', array('as' => 'search_return_invoice', 'uses' => 'SaleController@search_return_invoice'));		

});
// commision 
Route::group(

	array('prefix' => 'admin/commision','before' => 'Sentry'), function () {

// Show return invoice 
Route::get('add_commision', array('as' => 'add_commision', 'uses' => 'EmployeeCommision@index'));

// save commision 
Route::post('save_commision', array('as' => 'save_commision', 'uses' => 'EmployeeCommision@create'));

// show all commision 
Route::get('view_commision', array('as' => 'view_commision', 'uses' => 'EmployeeCommision@show'));

// show all commision 
Route::post('frm_view_commision', array('as' => 'frm_view_commision', 'uses' => 'EmployeeCommision@show'));

// Search Return Invoice
Route::post('search_return_invoice', array('as' => 'search_return_invoice', 'uses' => 'SaleController@search_return_invoice'));		

});
// account routs
Route::group(
	array('prefix' => 'admin/accounts','before' => 'Sentry'), function () {
		Route::get('trial_balance', array('as' => 'trial_balance', 'uses' => 'AccountController@trial_balance'));
		Route::post('view_trial_balance', array('as' => 'view_trial_balance', 'uses' => 'AccountController@trial_balance'));
		// Load COA 
		Route::get('index_coa', array('as' => 'index_coa', 'uses' => 'AccountController@index'));
		// Bank Pay Vouchers 
		Route::get('bank_pay', array('as' => 'bank_pay', 'uses' => 'AccountController@bank_pay'));
		// Bank Receipt Vouchers 
		Route::get('bank_receipt', array('as' => 'bank_receipt', 'uses' => 'AccountController@bank_receipt'));
		// Cash Pay Vouchers 
		Route::get('cash_pay', array('as' => 'cash_pay', 'uses' => 'AccountController@cash_pay'));
		// Cash Receipt Vouchers 
		Route::get('cash_receipt', array('as' => 'cash_receipt', 'uses' => 'AccountController@cash_receipt'));
		// All Vouchers 
		Route::get('all_vouchers', array('as' => 'all_vouchers', 'uses' => 'AccountController@all_vouchers'));
		// View Sale Summery
		Route::get('sale_summery', array('as' => 'sale_summery', 'uses' => 'AccountController@sale_summery'));
		// View Sale Vouchers
		Route::get('view_vouchers', array('as'=>'view_vouchers', 'uses' => 'AccountController@view_vouchers'));
		// View General Vouchers
		Route::get('general_voucher', array('as'=>'general_voucher', 'uses' => 'AccountController@general_voucher'));
		// View General Ledger
		Route::get('general_ledeger', array('as'=>'general_ledeger', 'uses' => 'AccountController@general_ledeger'));
		// Search Ledger Vouchers
		Route::post('view_ledger', array('as'=>'view_ledger', 'uses' => 'AccountController@view_ledger'));
		// Search Cash Book
		Route::get('frm_cash_book', array('as'=>'frm_cash_book', 'uses' => 'AccountController@frm_cash_book'));
		// View Cash Book
		Route::post('view_cash_book', array('as'=>'view_cash_book', 'uses' => 'AccountController@view_cash_book'));
		// Delete Vouchers
		Route::get('delete_vouchers', array('as'=>'delete_vouchers', 'uses' => 'AccountController@delete_vouchers'));
		// Search Sale Summery
		Route::post('search_view_ledger', array('as'=>'search_view_ledger', 'uses' => 'AccountController@all_search_view_ledger'));
		// Payment Vouchers 
		Route::get('payment_voucher', array('as' => 'payment_voucher', 'uses' => 'AccountController@payment_voucher'));
		// Purchase Vouchers 
		Route::get('purchase_voucher', array('as' => 'purchase_voucher', 'uses' => 'AccountController@purchase_voucher'));
		// General Vouchers 
		Route::post('save_general_voucher', array('as' => 'save_general_voucher', 'uses' => 'AccountController@save_general_voucher'));
		// Add Purchase Voucher 
		Route::post('add_purchase_voucher', array('as' => 'add_purchase_voucher', 'uses' => 'AccountController@add_purchase_voucher'));
		// View Purchase Items 
		Route::get('purchased_items_details', array('as' => 'purchased_items_details', 'uses' => 'AccountController@purchased_items_details'));				
		// Search Purchase Items 
		Route::post('frm_purchased_items_details', array('as' => 'frm_purchased_items_details', 'uses' => 'AccountController@purchased_items_details'));						
	});



// Add COA 
//Route::get('add_coa', array('uses' => 'AccountController@add_coa'));

// COA routs
Route::group(
	array('prefix' => 'admin/accounts','before' => 'Sentry'), function () {
		Route::post('add_coa', array('as' => 'add_coa', 'uses' => 'AccountController@add_coa'));
		Route::post('add_accounts', array('as' => 'add_accounts', 'uses' => 'AccountController@add_accounts'));
		Route::post('add_payment_voucher', array('as' => 'add_payment_voucher', 'uses' => 'AccountController@add_payment_voucher'));
        Route::get('show_coa', array('as' => 'show_coa', 'uses' => 'AccountController@view_coa'));
		Route::post('add', 'ProductsController@store');
		//Route::get('{id}', array('as' => 'products.show', 'uses' => 'ProductsController@show'));
        Route::get('{id}/edit', array('as' => 'coa.update', 'uses' => 'AccountController@update'));
		Route::post('{id}/edit', 'AccountController@postEdit');
		Route::get('delete_coa', array('as'=>'delete_coa', 'uses' => 'AccountController@delete_coa'));
		Route::get('{id}/confirm-delete', array('as' => 'confirm-delete/user', 'uses' => 'ProductsController@getModalDelete'));
	});



/*Route::get('sale', function()
{
    return View::make('sale');
});*/

// subpage for the posts found at /admin/posts (app/views/admin/posts.blade.php)
Route::get('layout/top-nav', function()
{
    return View::make('layout.top-nav');
});

// subpage for the posts found at /admin/posts (app/views/admin/posts.blade.php)
Route::get('layout/boxed', function()
{
    return View::make('layout.boxed');
});

Route::get('examples/login', function()
{
    return View::make('examples.login');
});


Route::get('layouts/header', function(){ return View::make('layouts.header');});

/* ======================== END ADMIN ROUTES ============================== */



/* ======================== CLIENT ROUTES ============================== */

Route::get('/', 'ClientController@index');
// route to show the login form
//Route::get('login', array('uses' => 'ClientController@showLogin'));

// Client end routs
Route::group(
	array('prefix' => 'client','before' => 'Sentry'), function () {
		Route::post('add_coa', array('as' => 'add_coa', 'uses' => 'AccountController@add_coa'));
	});

// route to process the form
Route::post('login', array('uses' => 'ClientController@doLogin'));

// Logout
Route::get('logout', array('uses' => 'ClientController@doLogout'));

// Client end group 
Route::group(array('before' => 'auth', 'after' => 'no-cache'), function()
{
// Show all products in front end
Route::get('sale', array('as' => 'sale', 'uses' => 'SaleController@index'));

// insert sale product products in front end
Route::get('sale_product', array('as' => 'sale_product', 'uses' => 'SaleController@create'));

// get all purchased Items
Route::get('purchase_items', array('as' => 'purchase_items', 'uses' => 'ProductsController@purchase_items'));

// Show all sale 
Route::get('all_sale', array('as' => 'all_sale', 'uses' => 'SaleController@all_sale'));

// Show today sale 
Route::get('today_sale', array('as' => 'today_sale', 'uses' => 'SaleController@today_sale'));

// // Show return invoice 
// Route::get('return_invoice', array('as' => 'return_invoice', 'uses' => 'SaleController@return_invoice'));

// // Search Return Invoice
// Route::post('search_return_invoice', array('as' => 'search_return_invoice', 'uses' => 'SaleController@search_return_invoice'));

});



/* ======================== END CLIENT ROUTES ============================== */