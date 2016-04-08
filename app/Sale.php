<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\salesDetails;
use DB,Input,Redirect,paginate;
use Session;

class Sale extends Model {

	protected $table = 'sales';
	
	public function index()
    {
        $member_detail = self::with('sales_details')->get();
        return $member_detail;
    }

    public function sales_details()
    {
        return $this->hasMany('App\salesDetails', 'sale_id', 'id')->orderBy('sales_details_id', 'desc')->get();
    }
				
				// Today Sale
				public function today_sale()
				{
					$user_id = Session::get('user_id');
					$user_type = Session::get('user_type');
					$TodayDate = date("Y-m-d");
						if($user_type == 1)
						{
					$sales['total_sale'] = DB::table('sales')
															->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
															->join('products', 'products.id', '=', 'sales_details.product_id')
															->join('users', 'users.id', '=', 'sales.user_id')
															->join('shops', 'shops.shop_id', '=', 'users.shop_id')
															->select('sales_details.*','product_name','first_name','invoice_id','shop_code')
															->whereRaw('sales.created_at =  "'.$TodayDate.'" AND sales.user_id = '.(int)$user_id.'')
															->orderBy('sales_details_id', 'desc')
															->paginate(10); //,DB::raw('SUM(sales_details.product_price) AS Total')
						$sales['sum_sale'] = DB::table('sales')
																->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
																->join('products', 'products.id', '=', 'sales_details.product_id')
																->select(DB::raw('SUM(sales_details.product_price) as TotalPrice, SUM(sales_details.product_qty) as TotalQty , SUM(sales.discount_amount) as DiscountAmount'))
																->whereRaw('sales.created_at =  "'.$TodayDate.'" AND sales.user_id = '.(int)$user_id.'')
																//->groupBy('sales_details.product_id')
																->orderBy('sales_details_id', 'desc')
																->get();
							/*$sales['discount_amount'] = DB::table('sales')
																->select(DB::raw('SUM(sales.discount_amount) as DiscountAmount'))
																->whereRaw('sales.created_at =  SUBDATE(CURDATE(),0) AND sales.user_id = '.(int)$user_id.'')
																//->groupBy('sales_details.product_id')
																//->orderBy('sales_details_id', 'desc')
																->get();*/																		
																
						$sales['discount_amount'] = DB::table('sales')
															//->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
															//->join('products', 'products.id', '=', 'sales_details.product_id')
															->select(DB::raw('SUM(sales.discount_amount) AS DiscountAmount'))
															->whereRaw('sales.created_at =  "'.$TodayDate.'" AND sales.user_id = '.(int)$user_id.'')
															->get();
						}
						else
						{
						$sales['total_sale'] = DB::table('sales')
															->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
															->join('products', 'products.id', '=', 'sales_details.product_id')
															->join('users', 'users.id', '=', 'sales.user_id')
															->select('sales_details.*','product_name','first_name')
															->whereRaw('sales.created_at = "'.$TodayDate.'"')
															//->groupBy('sales_details.product_id')
															->orderBy('sales_details_id', 'desc')
															->paginate(10); 
						$sales['sum_sale'] = DB::table('sales')
																->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
																->join('products', 'products.id', '=', 'sales_details.product_id')
																->select(DB::raw('SUM(sales_details.product_price) as TotalPrice, SUM(sales_details.product_qty) as TotalQty'))
																->whereRaw(' sales.created_at =  "'.$TodayDate.'" ')
																->orderBy('sales_details_id', 'desc')
																->get();
						$sales['yesterday_sale'] = DB::table('sales')
																->select(DB::raw('SUM(sales.net_amount) as YesterdaySale'))
																->whereRaw('sales.created_at =  SUBDATE(CURDATE(),1) ')
																->get();
						$sales['today_expense'] = DB::table('vouchermaster')
																->select(DB::raw('SUM(vm_amount) AS TodayExpense'))
																->whereRaw('vm_date =  "'.$TodayDate.'"')
																->get();
						$sales['yesterday_expense'] = DB::table('vouchermaster')
																->select(DB::raw('SUM(vm_amount) AS YesterdayExpense'))
																->whereRaw('vm_date =  SUBDATE(CURDATE(),1)')
																->get();				
						$sales['discount_amount'] = DB::table('sales')
															//->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
															//->join('products', 'products.id', '=', 'sales_details.product_id')
															->select(DB::raw('SUM(sales.discount_amount) AS DiscountAmount'))
															->whereRaw('sales.created_at =  "'.$TodayDate.'"')
															->get();																																						
						}
					return $sales;
					}
					
					// All Sale
					public function all_sale()
					{
						$user_id = Session::get('user_id');
						$user_type = Session::get('user_type');
						if($user_type == 1)
						{
						$sales['total_sale'] = DB::table('sales')
																->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
																->join('products', 'products.id', '=', 'sales_details.product_id')
																->join('users', 'users.id', '=', 'sales.user_id')
																->select('sales_details.*','product_name','first_name')
																->where('sales.user_id', '=', $user_id)
																->orderBy('sales_details_id', 'desc')
																->paginate(10);
						$sales['sum_sale'] = DB::table('sales')
																->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
																->join('products', 'products.id', '=', 'sales_details.product_id')
																->select(DB::raw('SUM(sales_details.product_price) as TotalPrice, SUM(sales_details.product_qty) as TotalQty'))
																->where('sales.user_id', '=', $user_id)
																->orderBy('sales_details_id', 'desc')
																->get();			
						}
						else
						{
						$sales['total_sale'] = DB::table('sales')
																->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
																->join('products', 'products.id', '=', 'sales_details.product_id')
																->join('users', 'users.id', '=', 'sales.user_id')
																->select('sales_details.*','product_name','first_name')
																->orderBy('sales_details_id', 'desc')
																->paginate(10);
						$sales['sum_sale'] = DB::table('sales')
																->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
																->join('products', 'products.id', '=', 'sales_details.product_id')
																->select(DB::raw('SUM(sales_details.product_price) as TotalPrice, SUM(sales_details.product_qty) as TotalQty'))
																->orderBy('sales_details_id', 'desc')
																->get();	
						}
						return $sales;
					}
					
					// Max id for invoice
					public function get_invoice_id()
					{
							$date = date('Y-m-d');
							$max_id = DB::table('sales')
																	->where('created_at', '=' ,$date)
																	->max('invoice_id');
							return $max_id;
					}
					
					// Get Shop Code
					public function get_shop_code()
					{
							$user_id = Session::get('user_id');	
							$arrayShopCode = DB::table('users')
															->join('shops', 'shops.shop_id', '=', 'users.shop_id')
															->select('shop_code')
															->where('users.id', '=' ,(int)$user_id)
															->get();
					return $arrayShopCode[0]->shop_code;
					}
					
					// Sale Summery
					public function get_sale_summery()
					{
						$arraySaleSummery = DB::table('sales')
							->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
							->join('products', 'products.id', '=', 'sales_details.product_id')
							->select(DB::raw('sales_details.product_id AS product_id, products.product_price, SUM(sales_details.product_price) AS NetAmount,SUM(sales_details.product_qty) AS TotalQty, sales.*'))
							->groupBy('sales.created_at')
							// ->orderBy('sales.created_at', 'desc')
							->paginate(30);
						return $arraySaleSummery;
					}

					public function search_ledeger($start_date, $end_date)
					{
						$arraySaleSummery = DB::table('sales')
							
							//->select('sales_details.product_id AS product_id','products.product_price','SUM(sales_details.product_price) AS NetAmount','SUM(sales_details.product_qty) AS TotalQty','sales.*')
							//->where('created_at', '>=', "$start_date")
							//->where('created_at', '<=', "$end_date")
							->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
							->select('sales.*')
							//->join('products', 'products.id', '=', 'sales_details.product_id')
							//->select(DB::raw('sales_details.product_id AS product_id, products.product_price, SUM(sales_details.product_price) AS NetAmount,SUM(sales_details.product_qty) AS TotalQty, sales.*'))
							
							->whereRaw('sales.created_at >= "'.$start_date.'" AND sales.created_at <= "'.$end_date.'" ')
							
							->groupBy('sales.created_at')
							// ->orderBy('sales.created_at', 'desc')
							->paginate(30);
							//->get();
							//print_r($arraySaleSummery); die;
						return $arraySaleSummery;
					}

					// Oppening Balance
					public function get_opening_balance()
					{
							$arrayOpBalance = array();
							$arrayOpBalance['sales_details'] = DB::table('sales')
															->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
															->join('products', 'products.id', '=', 'sales_details.product_id')
															->select(DB::raw('SUM(sales_details.product_price - sales.discount_amount) AS NetAmount'))
															->get();
							$arrayOpBalance['voucherdetail'] = DB::table('voucherdetail')
															->select(DB::raw('SUM(vd_debit) AS Expense'))
															->get();	
															$expense = str_replace(",","",number_format($arrayOpBalance['voucherdetail'][0]->Expense));
							$TotalOB = 	$arrayOpBalance['sales_details'][0]->NetAmount - 	$expense;													
					return $TotalOB;
					}					

}
