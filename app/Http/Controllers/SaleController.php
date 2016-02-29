<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use App\Product;
use DB,Input,Redirect,paginate;
use App\Sale;
use App\salesDetails;
use Carbon\Carbon;
use Session;

class SaleController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$products = DB::table('products')->where('is_active',1)->orderBy('product_name', 'ASC')->get();
		// Get max invoice id
		$data = new Sale;
	 $invoice_id = $data->get_invoice_id();
		$invoice_id++;
		return View('sale', compact('products','invoice_id'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		DB::transaction(function () {
		// Get Max invoice id
		$data = new Sale;
		$invoice_id = $data->get_invoice_id();
		$invoice_id++;
		
		$mytime = Carbon::now();
		$date = $mytime->toDateTimeString();
		
		// Insert in sale table
		$net_amount = Input::get('net_amount');
		$user_id = Session::get('user_id');
		$arrayInsert = array('net_amount' => $net_amount, 
																							"created_at" => $date,
																							"invoice_id" => $invoice_id,
																							"user_id" => $user_id);
		$last_sale_id = Sale::insertGetId($arrayInsert);
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
		});
		// Redirect to sale page
		
		return Redirect::to('sale');
		
		
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
	$user_type = Session::get('user_type');
	$data = new Sale;
	$sales = $data->all_sale();
	$detail_sale = $sales['total_sale'];
	$sum_sale = $sales['sum_sale'];
	$TotalSale = number_format($sum_sale[0]->TotalPrice,0);
	$TotalQty = number_format($sum_sale[0]->TotalQty,0);
	if($user_type == 2)			
			return View('all_sale', compact('detail_sale','TotalSale','TotalQty'));
	else
			return View('admin/reports/all_sale', compact('detail_sale','TotalSale','TotalQty'));		
	}
	
	public function today_sale()
	{
		$user_type = Session::get('user_type');
			$data = new Sale;
	  $sales = $data->today_sale();
			$detail_sale = $sales['total_sale'];
	$sum_sale = $sales['sum_sale'];
	$TotalSale = number_format((int)$sum_sale[0]->TotalPrice);
	$TotalQty = number_format((int)$sum_sale[0]->TotalQty);
	//var_dump($detail_sale[0]->shop_name); die;
		if($user_type == 1)
			return View('today_sale', compact('detail_sale','TotalSale','TotalQty'));
		else
		{
			// Yester day sale
			$yesterday_sale = $sales['yesterday_sale'];
			$YesterdaySale = number_format((int)$yesterday_sale[0]->YesterdaySale);
			// Today Expense
			$today_expense = $sales['today_expense'];
			$TodayExpense = number_format((int)$today_expense[0]->TodayExpense);
			
			return View('admin/reports/today_sale', compact('detail_sale','TotalSale','TotalQty','YesterdaySale','TodayExpense'));	
		}
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
