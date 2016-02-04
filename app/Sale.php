<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\salesDetails;

class Sale extends Model {

	protected $table = 'sales';
	
	public function index()
    {
        $member_detail = self::with('sales_details')->get();
        return $member_detail;
    }

    public function sales_details()
    {
        return $this->hasMany('App\salesDetails', 'sale_id', 'sale_id');
    }

}
