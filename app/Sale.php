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
						if($user_type == 1)
						{
					$sales['total_sale'] = DB::table('sales')
															->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
															->join('products', 'products.id', '=', 'sales_details.product_id')
															->join('users', 'users.id', '=', 'sales.user_id')
															->join('shops', 'shops.shop_id', '=', 'users.shop_id')
															->select('sales_details.*','product_name','first_name','invoice_id','shop_name')
															->whereRaw('sales.created_at =  SUBDATE(CURDATE(),0) AND sales.user_id = '.(int)$user_id.'')
															->orderBy('sales_details_id', 'desc')
															->paginate(10); //,DB::raw('SUM(sales_details.product_price) AS Total')
						$sales['sum_sale'] = DB::table('sales')
																->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
																->join('products', 'products.id', '=', 'sales_details.product_id')
																->select(DB::raw('SUM(sales_details.product_price) as TotalPrice, SUM(sales_details.product_qty) as TotalQty'))
																->whereRaw('sales.created_at =  SUBDATE(CURDATE(),0) AND sales.user_id = '.(int)$user_id.'')
																//->groupBy('sales_details.product_id')
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
															->whereRaw('sales.created_at = SUBDATE(CURDATE(),0)')
															//->groupBy('sales_details.product_id')
															->orderBy('sales_details_id', 'desc')
															->paginate(10); 
						$sales['sum_sale'] = DB::table('sales')
																->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
																->join('products', 'products.id', '=', 'sales_details.product_id')
																->select(DB::raw('SUM(sales_details.product_price) as TotalPrice, SUM(sales_details.product_qty) as TotalQty'))
																->whereRaw(' sales.created_at =  SUBDATE(CURDATE(),0) ')
																->orderBy('sales_details_id', 'desc')
																->get();
						$sales['yesterday_sale'] = DB::table('sales')
																->select(DB::raw('SUM(sales.net_amount) as YesterdaySale'))
																->whereRaw('sales.created_at =  SUBDATE(CURDATE(),1) ')
																->get();
						$sales['today_expense'] = DB::table('vouchermaster')
																->select(DB::raw('SUM(vm_amount) AS TodayExpense'))
																->whereRaw('vm_date =  SUBDATE(CURDATE(),0)')
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

}
