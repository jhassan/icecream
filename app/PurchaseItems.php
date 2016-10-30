<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB,Input,Redirect,paginate;
use App\Vendor;
use App\Product;

class PurchaseItems extends Model {

	protected $table = 'purchase_items';

	public function get_all_items($start_date, $end_date)
	{
		$arrayItems = DB::table('purchase_items')
		->join('products', 'products.id', '=', 'purchase_items.product_id')
		->join('vendors', 'vendors.vendor_id', '=', 'purchase_items.vendor_id')
		->select('purchase_items.*','vendors.vendor_name','products.product_name')
		->whereRaw('purchase_items.created_at >= "'.$start_date.'" AND purchase_items.created_at <= "'.$end_date.'" ')
		->orderBy('created_at', 'DESC')
		->paginate(10);
		return $arrayItems;
	}

	public function get_all_items_counts($start_date, $end_date)
	{
		$arrayItems = DB::table('purchase_items')
		->join('products', 'products.id', '=', 'purchase_items.product_id')
		->join('vendors', 'vendors.vendor_id', '=', 'purchase_items.vendor_id')
		->select(DB::raw('SUM(item_qty) AS item_qty, SUM(item_amount) AS item_amount, SUM(item_amount*item_qty) AS total_amount'))
		->whereRaw('purchase_items.created_at >= "'.$start_date.'" AND purchase_items.created_at <= "'.$end_date.'" ')
		//->orderBy('created_at', 'DESC')
		//->paginate(10);
		->get();
		return $arrayItems;
	}

}
