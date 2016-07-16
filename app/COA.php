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
	public function all_vouchers()
	{
				$arrayVouchers = DB::table('vouchermaster')
				->join('shops', 'shops.shop_id', '=', 'vouchermaster.shop_id')
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


	// Get Cash Book Opening Balance
	public function opb_cash_book($start_date, $end_date,$shop_id)
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
	public function opb_view_ledeger($coa_code, $start_date, $end_date, $shop_id)
	{
		$dBalance = 0;
		$dDebit = 0;
		$dCredit = 0;
		$yesterday = '';
		$ClosingBalance = 0;
		$OpBalance = 0;
		if($shop_id == 0 || empty($shop_id))
			$shop_id = 1;
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
			$data = new Sale;
			// Get Opening Balance
			$GetOpBalance = $data->get_opening_balance($coa_code);

			if($GetOpBalance[0]->coa_debit == 0)
				$OpBalance = $GetOpBalance[0]->coa_credit;
			else
				$OpBalance = $GetOpBalance[0]->coa_debit;
			$arrayLedeger = DB::table('vouchermaster')
			->join('voucherdetail', 'voucherdetail.vd_vm_id', '=', 'vouchermaster.vm_id')
			->join('coa', 'coa.coa_code', '=', 'voucherdetail.vd_coa_code')
			->select('vouchermaster.*','voucherdetail.*','coa.*')
			->whereRaw('vouchermaster.shop_id = "'.$shop_id.'" AND vd_coa_code = "'.$coa_code.'" AND vm_date >= "'.$start_date.'" AND vm_date <= "'.$yesterday.'" ')
			->orderBy('vm_date', 'asc')
			->get();

			$i = 1;

			if(!empty($arrayLedeger) && count($arrayLedeger) > 0 && $coa_code == "414002")
			{
				foreach($arrayLedeger as $rstRow)
				{
					$dBalance = 0;	
					$DateExpense = 0;
					if($rstRow->vm_type == "CR")
					{
						$DateExpense = $this -> GetDateWiseExpense($rstRow->vm_date);
						$dBalance = ($OpBalance - $DateExpense) + $rstRow->vd_credit;
						$rstRow->vd_debit = $rstRow->vd_credit;
						$rstRow->vd_credit = '0.0000';
					}
						$dDebit += $rstRow->vd_debit;
						$dCredit += $rstRow->vd_credit;
						$i++;
				}
						$Debit = $dDebit;
						$Credit = $dCredit;
						//echo $OpBalance."-----".$Debit."-----".$Credit; die;
						$ClosingBalance = ($OpBalance + $Debit) - $Credit;
						//echo $ClosingBalance."-------"; die;
			}
			else
			{
				//print_r($arrayLedeger); die;
				//if(!empty($arrayLedeger) && count($arrayLedeger) > 0)
				//{
					foreach($arrayLedeger as $rstRow)
					{
						$dDebit += $rstRow->vd_debit;
						$dCredit += $rstRow->vd_credit;
						$i++;
					}
						$Debit = $dDebit;
						$Credit = $dCredit;
						$ClosingBalance = ($OpBalance + $Debit) - $Credit;
				//}
			}
			//$ClosingBalance = 40050;
			return $ClosingBalance;
		//}
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
