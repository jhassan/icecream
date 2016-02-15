<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB,Input,Redirect,paginate;
use Session;

class COA extends Model {

	protected $table = 'coa';
	
	public function all_coa()
	{
				//	$arrayCoa = COA::all()->orderBy('coa_id', 'ASC'); //->where('parent_id','=',0);
				$arrayCoa = DB::table('coa')
                ->orderBy('coa_code', 'asc')
                ->get();
					return $arrayCoa;
	}
	
	public function child_coa()
	{
					$arrayCoa = COA::all(); //->where('parent_id','!=',0);
					return $arrayCoa;
	}

}
