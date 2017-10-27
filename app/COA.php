<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB,Input,Redirect,paginate;
use Session;
use App\VoucherMaster;
use App\Sale;

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
	public function all_vouchers($shop_id, $start_date, $end_date)
	{
		if(empty($shop_id)){
			$arrayVouchers = DB::table('vouchermaster')
				->join('shops', 'shops.shop_id', '=', 'vouchermaster.shop_id')
                ->orderBy('vm_date', 'desc')
                ->paginate(20);
		}
		else
		{
			//echo $start_date; //die;
			$arrayVouchers = DB::table('vouchermaster')
				->join('shops', 'shops.shop_id', '=', 'vouchermaster.shop_id')
				->whereRaw('vm_date >= "'.$start_date.'" AND vm_date <= "'.$end_date.'"')
				//->whereRaw('vm_amount = "'.$str.'"')
                ->orderBy('vm_date', 'desc')
                ->paginate(20);
		}
		return $arrayVouchers;
	}
	// Select Voucher
	public function seleted_voucher($id)
	{
					$arrayVoucher = DB::table('voucherdetail')
								->join('coa', 'coa.coa_code', '=', 'voucherdetail.vd_coa_code')
								->select('voucherdetail.*','coa_account')
								->where('voucherdetail.vd_vm_id', '=' ,(int)$id)
								->orderBy('vd_id', 'ASC')
								->get();
							//	var_dump($arrayVoucher); die;
					return $arrayVoucher;
	}
	// Search General Voucher
	public function search_vouchers($coa, $start_date, $end_date, $shop_id)
	{
		if($coa == "511001")
		{
			$arrayVoucher = DB::table('vouchermaster')
						->join('voucherdetail', 'voucherdetail.vd_vm_id', '=', 'vouchermaster.vm_id')
						->join('coa', 'coa.coa_code', '=', 'voucherdetail.vd_coa_code')
						->select('vouchermaster.*','voucherdetail.*','coa.*')
						->whereRaw('vd_coa_code = '.$coa.' AND vm_date >= "'.$start_date.'" AND vm_date <= "'.$end_date.'" AND vouchermaster.shop_id <= "'.$shop_id.'" AND vouchermaster.shop_id <> 0 ')
						->orderBy('vm_date', 'asc')
						->get();
		}
		else
		{
			$arrayVoucher = DB::table('vouchermaster')
						->join('voucherdetail', 'voucherdetail.vd_vm_id', '=', 'vouchermaster.vm_id')
						->join('coa', 'coa.coa_code', '=', 'voucherdetail.vd_coa_code')
						->select('vouchermaster.*','voucherdetail.*','coa.*')
						->whereRaw('vd_coa_code = '.$coa.' AND vm_date >= "'.$start_date.'" AND vm_date <= "'.$end_date.'" AND vouchermaster.shop_id <= "'.$shop_id.'" AND vouchermaster.shop_id <> 0 AND vm_type <> "JV" ')
						->orderBy('vm_date', 'asc')
						->get();
		}	
		
					return $arrayVoucher;
	}
	
	// Search Cash Book
	public function search_cash_book($start_date, $end_date,$shop_id)
	{
		$arrayCashBook = DB::table('vouchermaster')
					->join('voucherdetail', 'voucherdetail.vd_vm_id', '=', 'vouchermaster.vm_id')
					->join('shops', 'shops.shop_id', '=', 'vouchermaster.shop_id')
					->join('coa', 'coa.coa_code', '=', 'voucherdetail.vd_coa_code')
					->select('vm_date','voucherdetail.*','vm_type','coa_account')
					->whereRaw(' vouchermaster.shop_id = "'.$shop_id.'" AND vm_date >= "'.$start_date.'" AND vm_date <= "'.$end_date.'" AND (`vm_type` != "CP" OR `vd_debit` != "0.0000") ')
					->orderBy('vd_coa_code', 'asc')
				    //->groupBy('vd_vm_id')
					->get();
					return $arrayCashBook;
	}

	// Get Opening Balance of cash book
	public function opb_cash_book($start_date, $shop_id)
	{
		$arrayDetail = DB::table('vouchermaster')
					->join('voucherdetail', 'voucherdetail.vd_vm_id', '=', 'vouchermaster.vm_id')
					->join('coa', 'coa.coa_code', '=', 'voucherdetail.vd_coa_code')
					->select(DB::raw('((`coa_credit`+`coa_debit`) + SUM(vd_debit)) - SUM(vd_credit) AS OpeningBalance'))
					->whereRaw('coa.coa_code = "414002" AND vm_date < "'.$start_date.'" AND vouchermaster.shop_id = "'.$shop_id.'" AND vouchermaster.shop_id <> 0 AND vm_type <> "JV" ')
					->get();	
		
		$ClosingBalance = $arrayDetail[0]->OpeningBalance;
		 if(empty($ClosingBalance))
		 {
		 	$arrayOpBalance = array();
			$arrayOpBalance = DB::table('coa')
						->select('coa_debit','coa_credit')
						->whereRaw('coa_code = "414002"')
						->get();	

			if($arrayOpBalance[0]->coa_debit != 0)
				$ClosingBalance = $arrayOpBalance[0]->coa_debit; 
			elseif($arrayOpBalance[0]->coa_credit != 0)
				$ClosingBalance = $arrayOpBalance[0]->coa_credit;
		 }

		return $ClosingBalance;
	}


	// Get Cash Book Opening Balance
	public function opb_cash_book123($start_date, $end_date,$shop_id)
	{
		$ClosingBalance = 0;
		$yesterday = '';
		$OpBalance = 0;	
		if($shop_id == 0 || empty($shop_id))
			$shop_id = 1;
		if($start_date == "2016-04-01")
		{
			return $ClosingBalance = "32070";
		}
		else // Other case except 2016-04-01 56600
		{
			if($start_date == $end_date)
			{
				$yesterday = date('Y-m-d', strtotime($start_date .' -1 day'));	
				if($yesterday == "2016-04-01")
				{
					$start_date = "2016-04-01";
					$yesterday = "2016-04-01";
				}
				else
				{
					$start_date = "2016-04-01";
					$yesterday = $yesterday;
				}
			}
			else
			{
				$yesterday = date('Y-m-d', strtotime($start_date .' -1 day'));
				$start_date = "2016-04-01";
			}
			$OpBalance = 32070;
			$arrayCashBook = DB::table('vouchermaster')
				->join('voucherdetail', 'voucherdetail.vd_vm_id', '=', 'vouchermaster.vm_id')
				->join('shops', 'shops.shop_id', '=', 'vouchermaster.shop_id')
				->join('coa', 'coa.coa_code', '=', 'voucherdetail.vd_coa_code')
				->select('vm_date','voucherdetail.*','vm_type','coa_account')
				->whereRaw(' vouchermaster.shop_id = "'.$shop_id.'" AND vm_date >= "'.$start_date.'" AND vm_date <= "'.$yesterday.'" AND (`vm_type` != "CP" OR `vd_debit` != "0.0000") ')
				->orderBy('vd_coa_code', 'asc')
			    //->groupBy('vd_vm_id')
				->get();
				//return $arrayCashBook;
				
				$dBalance = 0;
				$dDebit = 0;
				$dCredit = 0;
				$DetailDebit = 0;
				$DetailCredit = 0;
				$i = 1;
				$now_date = '';
				$sum_debit = 0;
				//print_r($arrayCashBook); die;
				if(count($arrayCashBook) > 0)
				{
				foreach($arrayCashBook as $rstRow)
				{
					$dBalance = ($OpBalance + $rstRow->vd_credit) - $rstRow->vd_debit;
					if($rstRow->vd_coa_code != "414002" || $rstRow->vm_type != "CR" || $rstRow->vd_credit != "0.0000")
					{
						$dDebit += $rstRow->vd_debit;
						$dCredit += $rstRow->vd_credit;
					}	
					
				}
					$Debit = $dDebit;
					$Credit = $dCredit;
					//echo $Credit."-----".$Debit; die;
					$ClosingBalance = ($OpBalance + $Credit) - $Debit;
					//echo $ClosingBalance."-----"; die;
					return $ClosingBalance;

				}
			}
			
	}

	// Get ledger opening balance
	public function opb_view_ledeger123($coa_code, $start_date = "")
	{
		$ClosingBalance = 0;
		$yesterdayDate = date('Y-m-d',strtotime("-1 days"));
		if($yesterdayDate == "2016-08-01")
		{
			$arrayOpBalance = array();
			$arrayOpBalance = DB::table('coa')
						->select('coa_debit','coa_credit')
						->whereRaw('coa_code = "'.$coa_code.'"')
						->get();	

			if($arrayOpBalance[0]->coa_debit != 0)
				$ClosingBalance = $arrayOpBalance[0]->coa_debit; 
			elseif($arrayOpBalance[0]->coa_credit != 0)
				$ClosingBalance = $arrayOpBalance[0]->coa_credit;	
		}
		else
		{
			$yesterday = date('Y-m-d', strtotime($start_date .' -1 day'));
			$arrayOpBalance = array();
			$coa_code = str_replace("`", "", $coa_code);
			$arrayOpBalance = DB::table('tbl_op_balance')
						->select("coa_$coa_code AS coa_credit")
						//->whereRaw('$coa_code = "'.$coa_code.'" AND current_date = "'.$yesterday.'"')
						->whereRaw("$coa_code = $coa_code AND `current_date` = '".$yesterday."'")
						//->where("$coa_code", '=' , "'$coa_code'")
						//->where('current_date', '=' , "'$yesterday'")
						->get();
						// print_r($arrayOpBalance); die;
			if(!empty($arrayOpBalance))
				$ClosingBalance = $arrayOpBalance[0]->coa_credit;			
		}
		 

		return $ClosingBalance;				
	}

	// Get ledger opening balance
	public function opb_view_ledeger($coa_code, $start_date = "", $shop_id)
	{
		$ClosingBalance = 0;
		if($coa_code == "511001")
		{
			$arrayDetail = DB::table('vouchermaster')
						->join('voucherdetail', 'voucherdetail.vd_vm_id', '=', 'vouchermaster.vm_id')
						->join('coa', 'coa.coa_code', '=', 'voucherdetail.vd_coa_code')
						->select(DB::raw('((`coa_credit`+`coa_debit`) + SUM(vd_debit)) - SUM(vd_credit) AS OpeningBalance'))
						->whereRaw('vd_coa_code = "'.$coa_code.'" AND vm_date < "'.$start_date.'" AND vouchermaster.shop_id = "'.$shop_id.'" AND vouchermaster.shop_id <> 0 ')
						->get();
		}
		else
		{
			$arrayDetail = DB::table('vouchermaster')
						->join('voucherdetail', 'voucherdetail.vd_vm_id', '=', 'vouchermaster.vm_id')
						->join('coa', 'coa.coa_code', '=', 'voucherdetail.vd_coa_code')
						->select(DB::raw('((`coa_credit`+`coa_debit`) + SUM(vd_debit)) - SUM(vd_credit) AS OpeningBalance'))
						->whereRaw('vd_coa_code = "'.$coa_code.'" AND vm_date < "'.$start_date.'" AND vouchermaster.shop_id = "'.$shop_id.'" AND vouchermaster.shop_id <> 0 AND vm_type <> "JV" ')
						->get();	
		}
		
		$ClosingBalance = $arrayDetail[0]->OpeningBalance;
		 if(empty($ClosingBalance))
		 {
		 	$arrayOpBalance = array();
			$arrayOpBalance = DB::table('coa')
						->select('coa_debit','coa_credit')
						->whereRaw('coa_code = "'.$coa_code.'"')
						->get();	

			if($arrayOpBalance[0]->coa_debit != 0)
				$ClosingBalance = $arrayOpBalance[0]->coa_debit; 
			elseif($arrayOpBalance[0]->coa_credit != 0)
				$ClosingBalance = $arrayOpBalance[0]->coa_credit;
		 }

		return $ClosingBalance;				
		//return 32070;				
	}

	public function GetDateWiseExpense($date)
	{
		$arrayDetail = DB::table('vouchermaster')
		->join('voucherdetail', 'voucherdetail.vd_vm_id', '=', 'vouchermaster.vm_id')
		->select(DB::raw('SUM(vd_debit) AS TotalExpense'))
		->whereRaw('vm_date = "'.$date.'" AND vd_coa_code != 0')
		->orderBy('vm_date', 'asc')
		->get();	
		return $arrayDetail[0]->TotalExpense;
	}
	
} //  end class
