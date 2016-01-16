<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use app\Http\Request;
use View;
use DB;
use Validator;
use Input;
use Session;
use App\Shop;

class ShopsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View('index');
	}
	
	public function addShops(){
		//return 'test';
		return View('shops.add');	
	}
	public function listShops(){
		//return 'test';
		$shops = DB::table('shops')->orderBy('shop_id', 'desc')->get();
		//print_r($shops);
		return View('shops.index', compact('shops'));	
	}
	

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function createShop()
	{
		$rules = array(
            'shop_name'  => 'required',
            'shop_address'  => 'required',
			'shop_code'  => 'required',
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
			return Redirect::back()->withInput()->withErrors($validator);
        }
		$data = new Shop();
		
		$data->shop_name = Input::get('shop_name');
		$data->shop_address = Input::get('shop_address');
		$data->shop_code = Input::get('shop_code');
		$data->is_active = (Input::has('is_active')) ? 1 : 0;
		//$data->shop_code = Input::get('is_active');
		//return $data;exit;
		//$data->image_name = $safeName;
		//echo '<pre>';
		//print_r($data);
		//echo '</pre>';
		
		if($data->save()){
			//echo 'i am in save';
			return redirect()->route("shops")->with('message','Success');
			//return redirect()->action('HomeController@index');
		}
		else{
			return Redirect::back()->with('error', Lang::get('banners/message.error.create'));;
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getEdit($id)
	{
		//
		try {
			$shops = DB::table('shops')->where('shop_id', $id)->first();
			return View('shops.edit', compact('shops'));
		}
		catch (TestimonialNotFoundException $e) {
			$error = Lang::get('banners/message.error.update', compact('id'));
			return Redirect::route('banners')->with('error', $error);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function postEdit($id = null)
	{
		$rules = array(
            'shop_name'  => 'required',
            'shop_address'  => 'required',
			'shop_code'  => 'required',
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
			return Redirect::back()->withInput()->withErrors($validator);
        }
		$data = new Shop();
		
		$data->shop_name = Input::get('shop_name');
		$data->shop_address = Input::get('shop_address');
		$data->shop_code = Input::get('shop_code');
		$data->is_active = (Input::has('is_active')) ? 1 : 0;
		//$data->shop_code = Input::get('is_active');
		//return $data;exit;
		//$data->image_name = $safeName;
		//echo '<pre>';
		//print_r($data);
		//echo '</pre>';
		
		Shop::where('shop_id', $id)->update(
			[
			'shop_name' => $data->shop_name,
			'shop_address' => $data->shop_address,
			'shop_code' => $data->shop_code,
			'is_active' => $data->is_active
			]);
			//return Redirect::back();
		$shops = DB::table('shops')->orderBy('shop_id', 'desc')->get();
		//print_r($users);
		return View('shops.index', compact('shops'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
