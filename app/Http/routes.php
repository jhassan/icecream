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

// Show all sale 
Route::get('admin/reports/all_sale', array('uses' => 'SaleController@all_sale'));

// Show today sale 
Route::get('admin/reports/today_sale', array('uses' => 'SaleController@today_sale'));

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

// route to process the form
Route::post('login', array('uses' => 'ClientController@doLogin'));

// Logout
Route::get('logout', array('uses' => 'ClientController@doLogout'));

// Show all products in front end
Route::get('sale', array('uses' => 'SaleController@index'));

// insert sale product products in front end
Route::post('sale_product', array('uses' => 'SaleController@create'));

// Show all sale 
Route::get('all_sale', array('uses' => 'SaleController@all_sale'));

// Show today sale 
Route::get('today_sale', array('uses' => 'SaleController@today_sale'));




/* ======================== END CLIENT ROUTES ============================== */
