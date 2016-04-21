<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use DB,Input,Redirect,paginate;
use App\COA;
use App\Sale;
use App\VoucherMaster;
use App\VoucherDetail;
use App\User;
use Carbon\Carbon;
use Session;

class AccountController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data = new coa;
	 $arrayCOA = $data->all_coa();
		$arrayChild = $data->child_coa();
	//	print_r($arrayChild);
		return View('admin/accounts/index_coa',compact('arrayCOA','arrayChild'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function add_coa()
	{
		$mytime = Carbon::now();
		$date = $mytime->toDateTimeString();
		
		$coa_code = COA::where('coa_code', '=', Input::get('coa_code'))->first();
		if ($coa_code === null) {
					// Insert in COA table
					$arrayInsert = array('coa_account' => Input::get('coa_account'), 
										 "coa_code" => Input::get('coa_code'),
										 "coa_credit" => Input::get('coa_credit'),
										 "coa_debit" => Input::get('coa_debit')
										 );
					$last_sale_id = COA::insertGetId($arrayInsert);
					// Redrect to sale page
					return Redirect::to('admin/accounts/index_coa'); 
		}
		else 
		return Redirect::to('admin/accounts/index_coa')->withErrors('message', 'Register Failed'); //die;
	}
	
	// View Coa
	function view_coa()
	{
		$data = new coa;
	 $arrayCOA = $data->all_coa();
		return View('admin/accounts/show_coa',compact('arrayCOA'));
		
	}
	
	// General Vouchers
	function general_voucher()
	{
		$data = new coa;
		// Debit array
	 $arrayDebit = $data->all_coa();
		return View('admin/accounts/general_voucher',compact('arrayDebit'));	
	}
	
	function frm_cash_book()
	{
		$data = new coa;
		// Debit array
	 $arrayDebit = $data->all_coa();
		return View('admin/accounts/frm_cash_book',compact('arrayDebit'));	
	}
	
	// Find Vouchers
	function view_ledger()
	{
		 $data = new coa;
			$sale = new sale;
				// get_opening_balance
		    $coa_account = Input::get('coa_account');
		    $OpBalance 	= $sale->get_opening_balance($coa_account);
			$start_date 	= date("Y-m-d",strtotime(Input::get('start_date')));
			$end_date 			= date("Y-m-d",strtotime(Input::get('end_date')));
			//var_dump($start_date); die;
			if($start_date != "1970-01-01" && $end_date != "1970-01-01")
			{
				$arrayLedeger 	= $data->search_vouchers($coa_account, $start_date, $end_date);
				$start_date 	= date("d-m-Y",strtotime($start_date));
			 $end_date 			= date("d-m-Y",strtotime($end_date));
				return View('admin/accounts/view_ledger',compact('arrayLedeger','end_date','start_date','OpBalance'));
			}
	}
	
	// Find Cash Book
	function view_cash_book()
	{
		  $data = new coa;
				$sale = new sale;
				// get_opening_balance
		  //$OpBalance = $sale->get_opening_balance();
			 $start_date 	= date("Y-m-d",strtotime(Input::get('start_date')));
			$end_date 			= date("Y-m-d",strtotime(Input::get('end_date')));
			//var_dump($start_date); die;
			if($start_date != "1970-01-01" && $end_date != "1970-01-01")
			{
				$arrayCashBook 	= $data->search_cash_book($start_date,$end_date);
				return View('admin/accounts/view_cash_book',compact('arrayCashBook','end_date','start_date','OpBalance'));
			}
	}
	
	// Bank Pay Vouchers
	function bank_pay()
	{
		$data = new coa;
		// Debit array
	 $arrayDebit = $data->all_coa();
		// Credit array
	 $arrayCredit = $data->all_coa();
		return View('admin/accounts/bank_pay',compact('arrayDebit','arrayCredit'));
	}
	
	// Bank Receipt Vouchers
	function bank_receipt()
	{
		$data = new coa;
		// Debit array
	 $arrayDebit = $data->all_coa();
		// Credit array
	 $arrayCredit = $data->all_coa();
		return View('admin/accounts/bank_receipt',compact('arrayDebit','arrayCredit'));
	}
	
	// Cash Receipt Vouchers
	function cash_receipt()
	{
		$data = new coa;
		// Debit array
	 $arrayDebit = $data->all_coa();
		// Credit array
	 $arrayCredit = $data->all_coa();
		return View('admin/accounts/cash_receipt',compact('arrayDebit','arrayCredit'));
	}
	
	// Cash Pay Vouchers
	function cash_pay()
	{
		$data = new coa;
		// Debit array
	 $arrayDebit = $data->all_coa();
		// Credit array
	 $arrayCredit = $data->all_coa();
		return View('admin/accounts/cash_pay',compact('arrayDebit','arrayCredit'));
	}
	
	// Sale Summery
	function sale_summery()
	{
		$data = new sale;
		$start_date 	= date("2016-04-01");
		$end_date 		= date("Y-m-d");
	 	$arraySummery = $data->get_sale_summery($start_date, $end_date);
		return View('admin/accounts/sale_summery',compact('arraySummery','start_date','end_date'));
	}
	
	
	
	
	// Add accounts data
	public function add_accounts()
	{
		
		DB::transaction(function () {
		// Insert in master table
		$vm_amount = Input::get('vm_amount');
		$vm_date = Input::get('vm_date');
		$vm_desc = Input::get('vm_desc');
		$vm_type = Input::get('vm_type');
		
		$user_id = Session::get('user_id');
		$arrayInsertMaster = array('vm_amount' => $vm_amount, 
									"vm_date" => date("Y-m-d",strtotime($vm_date)),
									"vm_type" => $vm_type,
									"vm_desc" => $vm_desc,
									"vm_user_id" => (int)$user_id);
		$last_master_id = VoucherMaster::insertGetId($arrayInsertMaster);
		// Insert in detail table
		$arrayInsertDetail = array('vd_vm_id' => $last_master_id, 
									"vm_date" => date("Y-m-d",strtotime($vm_date)),
									"vd_coa_code" => $vm_desc,
									"vm_user_id" => $user_id);
		$strDebitAcc = Input::get('vd_debit');
		$strCreditAcc = Input::get('vd_credit');
		$arrTrans[] = array("coa" => $strDebitAcc, "desc" => $vm_desc,  "debit" => $vm_amount, "credit" => 0);
		$arrTrans[] = array("coa" => $strCreditAcc, "desc" => $vm_desc,"debit" => 0, "credit" => $vm_amount);
		foreach($arrTrans as $tran)
		{
			$arrayInsertDetail = array("vd_vm_id" => $last_master_id,
						"vd_coa_code" => $tran["coa"],
						"vd_debit" => $tran["debit"],
						"vd_desc" => $tran["desc"],
						"vd_credit" => $tran["credit"]);
			$sale = VoucherDetail::insert($arrayInsertDetail);
		}
		});
		$vm_type = Input::get('vm_type');
		// Redrect to sale page all_vouchers
		//return Redirect::to('admin/accounts/all_vouchers');
		if($vm_type == "BP")
			return Redirect::to('admin/accounts/bank_pay');
		elseif($vm_type == "BR")
			return Redirect::to('admin/accounts/bank_receipt');
		elseif($vm_type == "CP")
			return Redirect::to('admin/accounts/cash_pay');
		elseif($vm_type == "CR")
			return Redirect::to('admin/accounts/cash_receipt');			
		
	}
	
	// trial_balance
	public function trial_balance()
	{
		return View('admin/accounts/trial_balance');
	}
	
	// all_vouchers
	public function all_vouchers()
	{
		$data = new coa;
	 $arrayVouchers = $data->all_vouchers();
		return View('admin/accounts/all_vouchers',compact('arrayVouchers'));
	}
	// view_vouchers
	public function view_vouchers()
	{
 	$ID = Input::get('ID');
		$data = new coa;
	 $SelectedVoucher = $data->seleted_voucher($ID);
		//return response()->json($SelectedVoucher);
		//var_dump($SelectedVoucher); die;
		//return json_encode($SelectedVoucher); die;
	//	print_r($SelectedVoucher);
		return View('admin/accounts/dialog_vouchers',compact('SelectedVoucher'));
		
	}

	// All Search View Ledger
	public function all_search_view_ledger()
	{
		$data = new sale;
		$start_date 	= date("Y-m-d",strtotime(Input::get('start_date')));
		$end_date 		= date("Y-m-d",strtotime(Input::get('end_date')));
		//var_dump($start_date); die;
		if($start_date != "1970-01-01" && $end_date != "1970-01-01")
		{
			$arraySummery 	= $data->search_ledeger($start_date, $end_date);
			$start_date 	= date("d-m-Y",strtotime($start_date));
		 	$end_date 		= date("d-m-Y",strtotime($end_date));
			return View('admin/accounts/sale_summery',compact('arraySummery','end_date','start_date'));
		}

	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
		try {
			$data = new coa;
	  $arrayCOA = $data->all_coa();
			$EditCOA = DB::table('coa')->where('coa_id', $id)->first();
			return View('admin.accounts.edit_coa', compact('EditCOA','arrayCOA'));
		}
		catch (TestimonialNotFoundException $e) {
			$error = Lang::get('banners/message.error.update', compact('id'));
			return Redirect::route('banners')->with('error', $error);
		}
	}
	
	public function postEdit($id)
	{
		$data = new coa();
		$arrayEdit = $data->all_coa();
		//print_r($arrayEdit[0]->coa_account); die;
		$arrayEdit[0]->coa_account = Input::get('coa_account');
		$arrayEdit[0]->coa_code = Input::get('coa_code');
		$arrayEdit[0]->coa_credit = Input::get('coa_credit');
		$arrayEdit[0]->coa_debit = Input::get('coa_debit');
		//$arrayEdit[0]->parent_id = Input::get('parent_id');
		
		COA::where('coa_id', $id)->update(
			[
			'coa_account' => $arrayEdit[0]->coa_account,
			 'coa_code' => $arrayEdit[0]->coa_code,
			 'coa_credit' => $arrayEdit[0]->coa_credit,
			 'coa_debit' => $arrayEdit[0]->coa_debit
			]);
			$data = new coa;
	 	$arrayCOA = $data->all_coa();
			return View('admin/accounts/show_coa',compact('arrayCOA'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete_vouchers()
	{
		//echo "Delete"; die;
		$DelID = Input::get('DelID');
		$vouchermaster = VoucherMaster::where('vm_id', '=', $DelID)->delete();
		$voucherdetail = VoucherDetail::where('vd_vm_id', '=', $DelID)->delete();
	
		//$vouchermaster = DB::table('vouchermaster')->delete($DelID);
		//$voucherdetail = DB::table('voucherdetail')->delete($DelID);
		$ID = VoucherMaster::where('vm_id', '=', $DelID)->first();
		if ($ID === null) 
		   echo "delete"; 
		else
			echo "sorry";
	}

}