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
        Route::get('/', array('as' => 'banners', 'uses' => 'BannersController@listBanners'));
		Route::post('add', 'UsersController@createBanner');
		Route::get('{id}', array('as' => 'banners.show', 'uses' => 'BannersController@show'));
        Route::get('{id}/edit', array('as' => 'banners.update', 'uses' => 'BannersController@getEdit'));
		Route::post('{id}/edit', 'BannersController@postEdit');
		Route::get('{id}/delete', array('as' => 'delete/banner', 'uses' => 'BannersController@getDelete'));
		Route::get('{id}/confirm-delete', array('as' => 'confirm-delete/banner', 'uses' => 'BannersController@getModalDelete'));
	});
	
	
Route::group(
	array('prefix' => 'shops','before' => 'Sentry'), function () {
		Route::get('add', array('as' => 'add/shop', 'uses' => 'ShopsController@addShops'));
        Route::get('/', array('as' => 'banners', 'uses' => 'BannersController@listBanners'));
		Route::post('add', 'UsersController@createBanner');
		Route::get('{id}', array('as' => 'banners.show', 'uses' => 'BannersController@show'));
        Route::get('{id}/edit', array('as' => 'banners.update', 'uses' => 'BannersController@getEdit'));
		Route::post('{id}/edit', 'BannersController@postEdit');
		Route::get('{id}/delete', array('as' => 'delete/banner', 'uses' => 'BannersController@getDelete'));
		Route::get('{id}/confirm-delete', array('as' => 'confirm-delete/banner', 'uses' => 'BannersController@getModalDelete'));
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


//Route::get('shops/add', function(){ return View::make('shops.add');}); // Add shop
//Route::get('shops/show', function(){ return View::make('shops.show');}); // view shop
/*Route::group(['namespace' => 'shops', 'prefix' => 'shops'], function()
{
    Route::get('add',['uses' => 'ShopsController@create']);
    Route::get('/',['uses' => 'ShopsController@index']);
   // Route::get('edit', ['uses' => 'UserController@index']);

});*/




