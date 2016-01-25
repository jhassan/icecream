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
 		return Redirect::to('auth/login')->with('error', 'You must be logged in!');
 	}
});

//Route::get('admin/product/index', 'ProductController@index');

// Route::get('admin/home', 'HomeController@index');

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::get('index', function()
{
    return View::make('admin/index');
});

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


Route::get('index2', function()
{
    return View::make('index2');
});

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




/* ======================== END CLIENT ROUTES ============================== */
