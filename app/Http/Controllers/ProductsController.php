<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use app\Http\Request;
use View;
use DB;
use Validator,Redirect;
use Input;
use Session;
use App\Product;


class ProductsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//return 'user list';
		$products = DB::table('products')->orderBy('product_name', 'ASC')->paginate(20);
		//print_r($users);
		return View('admin.products.index', compact('products'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View('admin.products.add');
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
			//print_r($rules);

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
		$data->is_active 	= (Input::has('is_active')) ? 1 : 0;
		//return $data;exit;
		//$data->image_name = $safeName;
		//  echo '<pre>';
		//  print_r($data);
		//  echo '</pre>';
		// die;
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

	public function getEdit($id = null)
    {
		//return $id;
		try {
			$products = DB::table('products')->where('id', $id)->first();
			return View('admin.products.edit', compact('products'));
		}
		catch (TestimonialNotFoundException $e) {
			$error = Lang::get('banners/message.error.update', compact('id'));
			return Redirect::route('banners')->with('error', $error);
		}
		
	}

	public function postEdit($id = null)
	{
		//return 'test';
		$rules = array(
            'product_name'  => 'required',
            'product_price'  => 'required');
			//print_r($rules);

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
		$data->is_active 	= (Input::has('is_active')) ? 1 : 0;
		//return $data;exit;
		//$data->image_name = $safeName;
		 // echo '<pre>';
		 // print_r($data);
		 // echo '</pre>';
		
		Product::where('id', $id)->update(
			[
			'product_name' => $data->product_name,
			'product_code' => $data->product_code,
			'product_price' => $data->product_price,
			'is_active' => $data->is_active
			]);
			//return Redirect::back();
		$products = DB::table('products')->orderBy('id', 'desc')->get();
		//print_r($users);
		//return View('admin.products.index', compact('products'));
		return Redirect::to('admin/products');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$data = new Product();
		
		$data->is_active = Input::get('is_active');
		
		Product::where('id', $id)->update(
			[
			'is_active' => $data->is_active
			]);
			//return Redirect::back();
		$products = DB::table('products')->orderBy('id', 'desc')->get();
		//print_r($users);
		return View('admin.products.index', compact('products'));
	}

}
