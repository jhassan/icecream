<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Product;
use DB,Input;
use App\Sale;
use App\salesDetails;
use Carbon\Carbon;

class SaleController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$products = DB::table('products')->orderBy('product_name', 'ASC')->get();
		return View('sale', compact('products'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$mytime = Carbon::now();
		$date = $mytime->toDateTimeString();
		// Insert in sale table
		$net_amount = Input::get('net_amount');
		$last_sale_id = Sale::insertGetId(array('net_amount' => $net_amount, "created_at" => $date));
		// Insert in sale detail table
		$product_id = Input::get('product_id');
		for($i=0; $i<count($product_id); $i++)
		{
				$arrData[] = array( 
										"product_price"      => Input::get("product_price.$i"),
										"product_qty"       => Input::get("product_qty.$i"), 
										"product_id"       => Input::get("product_id.$i"), 
										"sale_id"    					=> $last_sale_id,
										"created_at"    		=> $date               
						);
		}
		$sale = salesDetails::insert($arrData);
		// Redrect to sale page
		$products = DB::table('products')->orderBy('product_name', 'ASC')->get();
		return View('sale', compact('products'));
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
	public function all_sale()
	{
		
	return View('all_sale');
	}
	
	public function show($id)
	{
		echo 'jawad'; 
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
