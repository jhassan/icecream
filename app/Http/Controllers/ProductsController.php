<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Input;
use App\Product;
use DB;
use Session;

class ProductsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//return 'user list';
		$products = DB::table('products')->orderBy('id', 'desc')->get();
		//print_r($users);
		return View('products.index', compact('products'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View('products.add');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//return 'test';
		$rules = array(
            'product_name'  => 'required',
            'product_price'  => 'required');
			print_r($rules);

        // Create a new validator instance from our validation rules
     	 $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
      if ($validator->fails()) {
            // Ooops.. something went wrong
          //  echo "validation issues...";
			return Redirect::back()->withInput()->withErrors($validator);
        }
		//return 'i am here';
		// Input::get('first_name');

		$data = new Product();
		
		$data->product_name = Input::get('product_name');
		$data->product_code = Input::get('product_code');
		$data->product_price = Input::get('product_price');
		//return $data;exit;
		//$data->image_name = $safeName;
		 echo '<pre>';
		 print_r($data);
		 echo '</pre>';
		
		if($data->save()){
			//echo 'i am in save';
			return redirect()->route("products")->with('message','Success');
			//return redirect()->action('HomeController@index');
		}
		else{
			return Redirect::back()->with('error', Lang::get('banners/message.error.create'));;
		}
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
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
