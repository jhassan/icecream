<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\salesDetails;
use DB,Input,Redirect,paginate;

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
					$sales = DB::table('sales')
															->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
															->join('products', 'products.id', '=', 'sales_details.product_id')
															->select('sales_details.*','product_name')
															->whereRaw('sales.created_at >= CURRENT_DATE() AND (sales.created_at < CURDATE() + INTERVAL 1 DAY)')
															->orderBy('sales_details_id', 'desc')
															->get();
					return $sales;
					}
					
					// All Sale
					public function all_sale()
					{
						$sales['total_sale'] = DB::table('sales')
																->join('sales_details', 'sales.sale_id', '=', 'sales_details.sale_id')
																->join('products', 'products.id', '=', 'sales_details.product_id')
																->select('sales_details.*','product_name')
																//->where('product_qty', '>', 1)->paginate(15)
																->orderBy('sales_details_id', 'desc')
																->paginate(5);
						return $sales;
					}

}
