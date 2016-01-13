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

Route::get('/', 'WelcomeController@index');

Route::get('product/index', 'ProductController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('index', function()
{
    return View::make('index');
});

Route::group(
	array('prefix' => 'users','before' => 'Sentry'), function () {
		Route::get('add', array('as' => 'add/user', 'uses' => 'UsersController@addUsers'));
        Route::get('/', array('as' => 'users', 'uses' => 'UsersController@listUers'));
		Route::post('add', 'UsersController@createUser');
		Route::get('{id}', array('as' => 'users.show', 'uses' => 'UsersController@show'));
        Route::get('{id}/edit', array('as' => 'users.update', 'uses' => 'UsersController@getEdit'));
		Route::post('{id}/edit', 'UsersController@postEdit');
		Route::get('{id}/delete', array('as' => 'delete/banner', 'uses' => 'UsersController@getDelete'));
		Route::get('{id}/confirm-delete', array('as' => 'confirm-delete/user', 'uses' => 'UsersController@getModalDelete'));
	});
	
	
Route::group(
	array('prefix' => 'shops','before' => 'Sentry'), function () {
		Route::get('add', array('as' => 'add/shop', 'uses' => 'ShopsController@addShops'));
        Route::get('/', array('as' => 'shops', 'uses' => 'ShopsController@listShops'));
		Route::post('add', 'ShopsController@createShop');
		Route::get('{id}', array('as' => 'banners.show', 'uses' => 'ShopsController@show'));
        Route::get('{id}/edit', array('as' => 'shops.update', 'uses' => 'ShopsController@getEdit'));
		Route::post('{id}/edit', 'BannersController@postEdit');
		Route::get('{id}/delete', array('as' => 'delete/banner', 'uses' => 'ShopsController@getDelete'));
		Route::get('{id}/confirm-delete', array('as' => 'confirm-delete/shop', 'uses' => 'BannersController@getModalDelete'));
	});
// Product routs
Route::group(
	array('prefix' => 'products','before' => 'Sentry'), function () {
		Route::get('add', array('as' => 'add/products', 'uses' => 'ProductsController@create'));
        Route::get('/', array('as' => 'products', 'uses' => 'ProductsController@index'));
		Route::post('add', 'ProductsController@store');
		Route::get('{id}', array('as' => 'products.show', 'uses' => 'ProductsController@show'));
        Route::get('{id}/edit', array('as' => 'products.update', 'uses' => 'ProductsController@getEdit'));
		Route::post('{id}/edit', 'ProductsController@postEdit');
		Route::get('{id}/delete', array('as' => 'delete/banner', 'uses' => 'ProductsController@getDelete'));
		Route::get('{id}/confirm-delete', array('as' => 'confirm-delete/user', 'uses' => 'ProductsController@getModalDelete'));
	});


//Route::resource('nerds', 'NerdController');
Route::get('/nerds/create', function(){ return View::make('nerds.create');}); // Add shop



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
//Route::get('shops/add', function(){ return View::make('shops.add');}); // Add shop
//Route::get('shops/show', function(){ return View::make('shops.show');}); // view shop
/*Route::group(['namespace' => 'shops', 'prefix' => 'shops'], function()
{
    Route::get('add',['uses' => 'ShopsController@create']);
    Route::get('/',['uses' => 'ShopsController@index']);
   // Route::get('edit', ['uses' => 'UserController@index']);

});*/




