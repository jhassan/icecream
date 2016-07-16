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
use Validator;

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
		// Shop code
		$shop_data = $data->get_shop_code();
		$shop_code = $shop_data[0]->shop_code;
		$shop_name = $shop_data[0]->shop_name;
		//print_r($shop_code); die;
		return View('sale', compact('products','invoice_id','shop_code','shop_name'));
	}

	// invoice return
	public function return_invoice()
	{
		$shops = DB::table('shops')->orderBy('shop_id', 'desc')->get();
		return View('admin/invoice/return_invoice',compact('shops'));
	}

	// Get all return invoice 
	public function get_return_invoice()
	{
		//$returns = DB::table('sales')->where('return_id', 1)->orderBy('sale_id', 'desc')->paginate(10);
		$returns = DB::table('sales')
				//->join('shops', 'shops.shop_id', '=', 'sales.shop_id')
                ->where('return_id', 1)
                ->orderBy('sales.created_at', 'desc')
                ->paginate(10);
		return View('admin/invoice/view_return_invoice',compact('returns'));
	}

	// Search Return Invoice
	public function search_return_invoice()
	{
		$invoice_id = Input::get('invoice_id');
		$shop_id = Input::get('shop_id');
		$return_invoice_date = date("Y-m-d",strtotime(Input::get('return_invoice_date')));
		$rules = array('invoice_id'  => 'required', 'shop_id' => 'required');
        // Create a new validator instance from our validation rules
     	 $validator = Validator::make(Input::all(), $rules);
        // If validation fails, we'll exit the operation now.
      if ($validator->fails()) {
			return Redirect::back()->withInput()->withErrors($validator);
        }
		$data = new Sale();
		$data->invoice_id = $invoice_id;
		$matchThese = ['invoice_id' => $invoice_id, 'created_at' => $return_invoice_date, 'shop_id' => $shop_id];
		Sale::where($matchThese)
			  ->update(
			[
			'invoice_id' => $data->invoice_id,
			'return_id'  => 1
			]);
			  Session::flash('message', 'Invoice has been successful returned!'); 
    	return redirect()->route("return_invoice");
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
		//$date = $mytime->toDateTimeString();
		$date = date("Y-m-d H:i:s");
		
		// Insert in sale table
		$net_amount = Input::get('net_amount');
		$discount_amount = Input::get('discount_amount');
		$user_id = Session::get('user_id');
		$shop_id = Session::get('shop_id');
		$arrayInsert = array('net_amount' => $net_amount, 
								"created_at" => $date,
								"discount_amount" => $discount_amount,
								"invoice_id" => $invoice_id,
								"shop_id" => $shop_id,
								"user_id" => $user_id);
		$last_sale_id = Sale::insertGetId($arrayInsert);
		if($last_sale_id != 0 && $last_sale_id != "")
		{
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
			echo "done";
		}
			// Redirect to sale page
			
			//return Redirect::to('sale');
		});
		
		
		
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
		$shop_id = (int)Input::get('shop_id');
		$TotalQty = 0;
		$user_type = Session::get('user_type');
		$data = new Sale;
		$sales = $data->today_sale($shop_id);
		$detail_sale = $sales['total_sale'];
		$sum_sale = $sales['sum_sale'];
		$discount_amount = $sales['discount_amount'];
		$TotalSale = number_format((int)$sum_sale[0]->TotalPrice);
		$TotalQty = number_format((int)$sum_sale[0]->TotalQty);
		$DiscountAmount = number_format((int)$discount_amount[0]->DiscountAmount);
		$shops = DB::table('shops')->orderBy('shop_id', 'desc')->get();
	//echo $user_type."-----"; die;	

		if($user_type == 1)
			return View('today_sale', compact('detail_sale','TotalSale','TotalQty','DiscountAmount'));
		else //if($user_type == 2)
		{
			// Yester day sale
			$yesterday_sale = $sales['yesterday_sale'];
			$YesterdaySale = number_format((int)$yesterday_sale[0]->YesterdaySale);
			// Today Expense
			$today_expense = $sales['today_expense'];
			$TodayExpense = number_format((int)$today_expense[0]->TodayExpense);
			
			// Yesterday Expense
			$yesterday_expense = $sales['yesterday_expense'];
			$YesterdayExpense = number_format((int)$yesterday_expense[0]->YesterdayExpense);
			
		// get_opening_balance
		//$OpBalance = $data->get_opening_balance();
			$OpBalance = 0;
			return View('admin/reports/today_sale', compact('detail_sale','TotalSale','TotalQty','YesterdaySale','TodayExpense','YesterdayExpense','DiscountAmount','OpBalance','shops','shop_id'));	
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
