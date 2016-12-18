<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use DB,Input,Redirect,paginate;
use App\COA;
use App\Sale;
use App\VoucherMaster;
use App\VoucherDetail;
use App\PurchaseItems;
use App\User;
use Carbon\Carbon;
use Session;
use Validator;

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
	 $shops = DB::table('shops')->orderBy('shop_id', 'desc')->get();
		return View('admin/accounts/general_voucher',compact('arrayDebit','shops'));	
	}

	// General Ledeger
	function general_ledeger()
	{
		$data = new coa;
		// Debit array
	 $arrayDebit = $data->all_coa();
	 $shops = DB::table('shops')->orderBy('shop_id', 'desc')->get();
		return View('admin/accounts/general_ledeger',compact('arrayDebit','shops'));	
	}
	
	function frm_cash_book()
	{
		$data = new coa;
		// Debit array
	 $arrayDebit = $data->all_coa();
	 $shops = DB::table('shops')->orderBy('shop_id', 'desc')->get();
		return View('admin/accounts/frm_cash_book',compact('arrayDebit','shops'));	
	}
	
	// Find Vouchers
	function view_ledger()
	{
		 $data = new coa;
			$sale = new sale;
				// get_opening_balance
		    $coa_account = Input::get('coa_account');
		    $shop_id = Input::get('shop_id');
		    $start_date = date("Y-m-d",strtotime(Input::get('start_date')));
			$end_date 	= date("Y-m-d",strtotime(Input::get('end_date')));
		    //$OpBalance 	= $sale->get_opening_balance($coa_account);
		    $OpBalance 	= $data -> opb_view_ledeger($coa_account, $start_date, $shop_id);
			if($start_date != "1970-01-01" && $end_date != "1970-01-01")
			{
				$arrayLedeger = $data->search_vouchers($coa_account, $start_date, $end_date, $shop_id);
				$start_date   = date("d-m-Y",strtotime($start_date));
				$end_date 	  = date("d-m-Y",strtotime($end_date));
				return View('admin/accounts/view_ledger',compact('arrayLedeger','end_date','start_date','OpBalance','coa_account'));
			}
	}
	
	// Find Cash Book
	function view_cash_book()
	{
		    $data = new coa;
		    $sale = new sale;
			// get_opening_balance
		    //$OpBalance = $sale->get_opening_balance();
			$start_date = date("Y-m-d",strtotime(Input::get('start_date')));
			$end_date = date("Y-m-d",strtotime(Input::get('end_date')));
			$shop_id = Input::get('shop_id');
			// get_opening_balance
		    $OpBalance = $data->opb_cash_book($start_date, $shop_id);
			//var_dump($OpBalance); die;
			if($start_date != "1970-01-01" && $end_date != "1970-01-01")
			{
				$arrayCashBook 	= $data->search_cash_book($start_date,$end_date,$shop_id);
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
	 $shops = DB::table('shops')->orderBy('shop_id', 'desc')->get();
	 
		return View('admin/accounts/bank_pay',compact('arrayDebit','arrayCredit','shops'));
	}

	// Payment Vouchers
	function payment_voucher()
	{
		$data = new coa;
		// Debit array
	 $arrayDebit = $data->all_coa();
		// Credit array
	 $arrayCredit = $data->all_coa();
	 $shops = DB::table('shops')->orderBy('shop_id', 'desc')->get();
	 $vendors = DB::table('vendors')->orderBy('vendor_id', 'desc')->get();
		return View('admin/accounts/payment_voucher',compact('arrayDebit','arrayCredit','shops','vendors'));
	}

	// Purchase Vouchers
	function purchase_voucher()
	{
		$data = new coa;
		// Debit array
		$arrayDebit = $data->all_coa();
		// Credit array
		$arrayCredit = $data->all_coa();
		$shops = DB::table('shops')->orderBy('shop_id', 'desc')->get();
		$vendors = DB::table('vendors')->orderBy('vendor_id', 'desc')->get();
		return View('admin/accounts/purchase_voucher',compact('arrayDebit','arrayCredit','shops','vendors'));
	}

	function add_purchase_voucher(){

		// Sales Invoice Transections
		DB::transaction(function () {
		// Insert in sales master table
		$vm_date = date("Y-m-d");
		$vm_type = "PV";
		$vendor_id = Input::get('vendor_id');
		$vd_debit = Input::get('vd_debit');
		$cash_mode = Input::get('cash_mode');
		$vm_amount = Input::get('vm_amount');
		$item_id = Input::get('item_id');
		$add_item_amount = Input::get('add_item_amount');
		$vm_date = date("Y-m-d",strtotime(Input::get('vm_date')));
		$shop_id = Input::get('shop_id');
		$vm_memo_no = Input::get('vm_memo_no');
		$vm_desc = Input::get('vm_desc');
		$arrayInsertMaster = array('vm_amount' => $vm_amount, 
									"vm_date" => date("Y-m-d",strtotime($vm_date)),
									"vm_type" => $vm_type,
									"vm_desc" => $vm_desc,
									"vm_memo_no" => $vm_memo_no,
									"vm_ven_id" => $vendor_id,
									"shop_id" => $shop_id);
		$last_master_id = VoucherMaster::insertGetId($arrayInsertMaster);
		// Insert in sales detail table
		$coa_code = DB::table('coa')->where('supplier_id', $vendor_id)->first();
		$strDebitAcc = $vd_debit;
		$strCreditAcc = $coa_code->coa_code;
		$strDebitSupplier = $coa_code->coa_code;
		$strCreditCash = "414002";
		$arrTrans[] = array("coa" => $strDebitAcc, "desc" => $vm_desc,  "debit" => $vm_amount, "credit" => 0);
		$arrTrans[] = array("coa" => $strCreditAcc, "desc" => $vm_desc,"debit" => 0, "credit" => $vm_amount);
		$arrTrans[] = array("coa" => $strDebitSupplier, "desc" => $vm_desc,  "debit" => $vm_amount, "credit" => 0);
		$arrTrans[] = array("coa" => $strCreditCash, "desc" => $vm_desc,"debit" => 0, "credit" => $vm_amount);
		foreach($arrTrans as $tran)
		{
			$arrayInsertDetail = array("vd_vm_id" => $last_master_id,
						"vd_coa_code" => $tran["coa"],
						"vd_debit" => $tran["debit"],
						"vd_desc" => $tran["desc"],
						"vd_credit" => $tran["credit"]);
			$sale = VoucherDetail::insert($arrayInsertDetail);
		}
		// Insert all purchase items
		// $item_id = Input::get('item_id');
		// for($i=0; $i<count($item_id); $i++)
		// {
		// 	$arrData[] = array( 
		// 				"item_amount"      => Input::get("add_item_amount.$i"),
		// 				"item_qty"       => Input::get("item_qty.$i"), 
		// 				"product_id"       => Input::get("item_id.$i"), 
		// 				"vm_id"    		=> $last_master_id,
		// 				"vendor_id"    		=> $vendor_id,
		// 				"created_at"    	=> date("Y-m-d")               
		// 			);
		// }
		// $purchase_item = PurchaseItems::insert($arrData);
		}); // End transections
		return Redirect::to('admin/accounts/purchase_voucher');
		
		//print_r($add_item_amount);
	}
	
	// Bank Receipt Vouchers
	function bank_receipt()
	{
		$data = new coa;
		// Debit array
	 $arrayDebit = $data->all_coa();
		// Credit array
	 $arrayCredit = $data->all_coa();
	 $shops = DB::table('shops')->orderBy('shop_id', 'desc')->get();
		return View('admin/accounts/bank_receipt',compact('arrayDebit','arrayCredit','shops'));
	}
	
	// Cash Receipt Vouchers
	function cash_receipt()
	{
		$data = new coa;
		// Debit array
	 $arrayDebit = $data->all_coa();
		// Credit array
	 $arrayCredit = $data->all_coa();
	 $shops = DB::table('shops')->orderBy('shop_id', 'desc')->get();
		return View('admin/accounts/cash_receipt',compact('arrayDebit','arrayCredit','shops'));
	}
	
	// Cash Pay Vouchers
	function cash_pay()
	{
		$data = new coa;
		// Debit array
	 $arrayDebit = $data->all_coa();
		// Credit array
	 $arrayCredit = $data->all_coa();
	 $shops = DB::table('shops')->orderBy('shop_id', 'desc')->get();
		return View('admin/accounts/cash_pay',compact('arrayDebit','arrayCredit','shops'));
	}
	
	// Sale Summery
	function sale_summery()
	{
		$data = new sale;
		$start_date 	= date("2016-04-01");
		$end_date 		= date("Y-m-d");
	 	$arraySummery = $data->get_sale_summery($start_date, $end_date);
	 	$shops = DB::table('shops')->orderBy('shop_id', 'desc')->get();
		return View('admin/accounts/sale_summery',compact('arraySummery','start_date','end_date','shops'));
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
		$shop_id = Input::get('shop_id');
		
		$user_id = Session::get('user_id');
		$arrayInsertMaster = array('vm_amount' => $vm_amount, 
									"vm_date" => date("Y-m-d",strtotime($vm_date)),
									"vm_type" => $vm_type,
									"vm_desc" => $vm_desc,
									"shop_id" => $shop_id,
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

	// Add Payment Vouchers
	public function add_payment_voucher()
	{
		$rules = array(
            'vendor_id'  => 'required',
            'vm_amount'  => 'required',
            'shop_id'  => 'required'
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
          //  echo "validation issues...";
			return Redirect::back()->withInput()->withErrors($validator);
        }

		DB::transaction(function () {
		// Insert in master table
		$vm_amount = Input::get('vm_amount');
		$vm_date = Input::get('vm_date');
		$vm_desc = Input::get('vm_desc');
		$shop_id = Input::get('shop_id');
		$vendor_id = Input::get('vendor_id');
		$cash_mode = Input::get('cash_mode');
		$vm_memo_no = Input::get('vm_memo_no');
		
		$user_id = Session::get('user_id');
		// Get Vendor COA
		//$coa_code = COA::select('coa_code')->where('supplier_id', '=', $vendor_id);
		$coa_code = DB::table('coa')->where('supplier_id', $vendor_id)->first();
		//var_dump($coa_code->coa_code); die;
		$arrayInsertMaster = array('vm_amount' => $vm_amount, 
									"vm_date" => date("Y-m-d",strtotime($vm_date)),
									"vm_type" => "PV",
									"vm_desc" => $vm_desc,
									"vm_ven_id" => (int)$vendor_id,
									"vm_memo_no" => $vm_memo_no,
									"shop_id" => (int)$shop_id,
									"vm_user_id" => (int)$user_id);
		$last_master_id = VoucherMaster::insertGetId($arrayInsertMaster);
		// Insert in detail table
		$strDebitAcc = $coa_code->coa_code;
		$strCreditAcc = $cash_mode;
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
		return Redirect::to('admin/accounts/payment_voucher');
	}

	// Add General Vouchers
	public function save_general_voucher()
	{
		$rules = array(
            'start_date'  => 'required',
            'vm_type'  => 'required',
            'shop_id'  => 'required'
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
          //  echo "validation issues...";
			return Redirect::back()->withInput()->withErrors($validator);
        }

		DB::transaction(function () {
		// Insert in master table
		$vm_amount = Input::get('vm_amount');
		$vm_date = Input::get('start_date');
		$vm_desc = Input::get('vm_desc');
		$shop_id = Input::get('shop_id');
		$vendor_id = Input::get('vendor_id');
		$coa_account_debit = Input::get('coa_account_debit');
		$coa_account_credit = Input::get('coa_account_credit');
		
		$d_amount_debit = Input::get('d_amount_debit');
		$d_amount_credit = Input::get('d_amount_credit');
		if(empty($d_amount_debit))
			$debit_amount = $d_amount_credit;
		else
			$debit_amount = $d_amount_debit;

		$c_amount_debit = Input::get('c_amount_debit');
		$c_amount_credit = Input::get('c_amount_credit');
		
		if(empty($c_amount_debit))
			$credit_amount = $c_amount_credit;
		else
			$credit_amount = $c_amount_debit;
		$vm_type	= Input::get('vm_type');
		$user_id = Session::get('user_id');
		$arrayInsertMaster = array('vm_amount' => $debit_amount, 
									"vm_date" => date("Y-m-d",strtotime($vm_date)),
									"vm_type" => $vm_type,
									"vm_desc" => $vm_desc,
									"shop_id" => (int)$shop_id,
									"vm_user_id" => (int)$user_id);
		$last_master_id = VoucherMaster::insertGetId($arrayInsertMaster);
		// Insert in detail table
		$strDebitAcc = $coa_account_debit;
		$strCreditAcc = $coa_account_credit;
		$arrTrans[] = array("coa" => $strDebitAcc, "desc" => $vm_desc,  "debit" => $debit_amount, "credit" => 0);
		$arrTrans[] = array("coa" => $strCreditAcc, "desc" => $vm_desc,"debit" => 0, "credit" => $credit_amount);
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
		return Redirect::to('admin/accounts/general_voucher');

	}
	
	// trial_balance
	public function trial_balance()
	{
		//echo "adfadf"; die;
		$start_date = Input::get('start_date');
		$end_date = Input::get('end_date');
		if(empty($start_date) && empty($end_date))
		{
			$start_date = "2016-04-01";
			$end_date =  date("Y-m-d");
		}
		else
		{
			$start_date = date("Y-m-d",strtotime($start_date));
			$end_date = date("Y-m-d",strtotime($end_date));
		}
		return View('admin/accounts/trial_balance',compact('start_date','end_date'));	
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
		$shop_id 		= Input::get('shop_id');
		//var_dump($start_date); die;
		if($start_date != "1970-01-01" && $end_date != "1970-01-01")
		{
			$arraySummery 	= $data->search_ledeger($start_date, $end_date, $shop_id);
			$start_date 	= date("d-m-Y",strtotime($start_date));
		 	$end_date 		= date("d-m-Y",strtotime($end_date));
		 	$shops = DB::table('shops')->orderBy('shop_id', 'desc')->get();
			return View('admin/accounts/sale_summery',compact('arraySummery','end_date','start_date','shops','shop_id'));
		}

	}

	// Purchased Items Details
	public function purchased_items_details(){
		$data = new PurchaseItems;
		$start_date 	= date("Y-m-d",strtotime(Input::get('start_date')));
		$end_date 		= date("Y-m-d",strtotime(Input::get('end_date')));
		if(empty($start_date) || $start_date == "1970-01-01") $start_date = "2016-08-01";
		if(empty($end_date) || $end_date == "1970-01-01") $end_date = "2099-08-01";
		$get_items 		= $data->get_all_items($start_date, $end_date);
		$arrayCounts 	= $data->get_all_items_counts($start_date, $end_date);
		$Total_amount 	= $arrayCounts[0]->item_amount;
		$Total_Qty 		= $arrayCounts[0]->item_qty;
		$Total_Balance 	= $arrayCounts[0]->total_amount;
		return View('admin/accounts/purchased_items_details',compact('get_items','Total_amount','Total_Qty','Total_Balance'));
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
	// Delete COA
	public function delete_coa()
	{
		//echo "Delete"; die;
		$DelID = Input::get('DelID');
		//$vouchermaster = VoucherMaster::where('vm_id', '=', $DelID)->delete();
		//$voucherdetail = VoucherDetail::where('vd_vm_id', '=', $DelID)->delete();
	
		DB::table('coa')->where('coa_id', $DelID)->delete();
		//$voucherdetail = DB::table('voucherdetail')->delete($DelID);
		//$ID = VoucherMaster::where('vm_id', '=', $DelID)->first();
		$ID = DB::table('coa')->where('coa_id', $DelID)->first();
		if ($ID === null) 
		   echo "delete"; 
		else
			echo "sorry";
	}

}