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
		//$products = DB::table('products')->orderBy('product_name', 'ASC');
		$data = new Product;
	 	$products = $data->all_products();
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
            'category_id'  => 'required',
            'product_price'  => 'required');
			//print_r($rules);

        // Create a new validator instance from our validation rules
     	 $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
      if ($validator->fails()) {
			return Redirect::back()->withInput()->withErrors($validator);
        }
		$data = new Product();
		
		$data->product_name = Input::get('product_name');
		$data->category_id = Input::get('category_id');
		$data->product_code = Input::get('product_code');
		$data->product_price = Input::get('product_price');
		$data->is_active 	= (Input::has('is_active')) ? 1 : 0;
		if($data->save()){
			return redirect()->route("products")->with('message','Success');
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
		
		//print_r(Input::all()); die;
		//return 'test';
		$rules = array(
            'product_name'  => 'required',
            'product_price'  => 'required');
        // Create a new validator instance from our validation rules
     	 $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
      if ($validator->fails()) {
			return Redirect::back()->withInput()->withErrors($validator);
        }

		$data = new Product();
		
		$data->product_name = Input::get('product_name');
		//$data->category_id = Input::get('category_id');
		$data->product_code = Input::get('product_code');
		$data->product_price = Input::get('product_price');
		$data->is_active 	= (Input::has('is_active')) ? 1 : 0;
		
		Product::where('id', $id)->update(
			[
			'product_name' => $data->product_name,
			//'category_id' => $data->category_id,
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

	// Get all purchased items
	public function purchase_items()
	{
		$products = DB::table('products')->select('id as value', 'product_name as label')->where('category_id', 2)->orderBy('id', 'desc')->get();
		$str = json_encode($products);
		$str = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $str);
		echo $str;
	}

}
