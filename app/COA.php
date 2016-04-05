<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB,Input,Redirect,paginate;
use Session;
use App\VoucherMaster;

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
	
	public function seleted_coa($str)
	{
					$arrayCoa = DB::table('coa')
																->whereRaw('coa_id IN ('.$str.') OR parent_id IN ('.$str.')')
																->orderBy('coa_code', 'asc')
                ->get();
					return $arrayCoa;
	}
	// View All Vouchers
	public function all_vouchers()
	{
				$arrayVouchers = DB::table('vouchermaster')
                ->orderBy('vm_id', 'desc')
                ->paginate(10);
					return $arrayVouchers;
	}
	// Select Voucher
	public function seleted_voucher($id)
	{
					$arrayVoucher = DB::table('voucherdetail')
															->join('coa', 'coa.coa_code', '=', 'voucherdetail.vd_coa_code')
															->select('voucherdetail.*','coa_account')
															->where('voucherdetail.vd_vm_id', '=' ,(int)$id)
															->get();
														//	var_dump($arrayVoucher); die;
					return $arrayVoucher;
	}
	// Search General Voucher
	public function search_vouchers($coa, $start_date, $end_date)
	{
		$arrayVoucher = DB::table('vouchermaster')
															->join('voucherdetail', 'voucherdetail.vd_vm_id', '=', 'vouchermaster.vm_id')
															->join('coa', 'coa.coa_code', '=', 'voucherdetail.vd_coa_code')
															->select('vouchermaster.*','voucherdetail.*','coa.*')
															->whereRaw('vd_coa_code = '.$coa.' AND vm_date >= "'.$start_date.'" AND vm_date <= "'.$end_date.'" ')
															->orderBy('vm_date', 'asc')
															->get();
					return $arrayVoucher;
	}
	
	// Search Cash Book
	public function search_cash_book($start_date, $end_date)
	{
		$arrayCashBook = DB::table('vouchermaster')
															->join('voucherdetail', 'voucherdetail.vd_vm_id', '=', 'vouchermaster.vm_id')
															->join('coa', 'coa.coa_code', '=', 'voucherdetail.vd_coa_code')
															->select('vm_date','voucherdetail.*','vm_type','coa_account')
															->whereRaw(' vm_date >= "'.$start_date.'" AND vm_date <= "'.$end_date.'" ')
															->orderBy('vm_date', 'asc')
															->groupBy('vd_vm_id')
															->get();
					return $arrayCashBook;
	}
	
	
	
	
	
}
