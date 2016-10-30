<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Product extends Model {

	//
	protected $table = 'products';

	public function all_products()
	{
		$arrayProducts = DB::table('products')
        ->orderBy('product_name', 'asc')
        ->get();
		return $arrayProducts;
	}

}
