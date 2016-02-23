<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use DB,Input,Redirect,paginate;
use App\COA;
use App\VoucherMaster;
use App\VoucherDetail;
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
																										"parent_id" => Input::get('parent_id'));
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
	
	// Bank Pay Vouchers
	function bank_pay()
	{
		$data = new coa;
		// Debit array
	 $arrayDebit = $data->seleted_coa('1,2,13');
		// Credit array
	 $arrayCredit = $data->seleted_coa('2,13');
		return View('admin/accounts/bank_pay',compact('arrayDebit','arrayCredit'));
	}
	
	// Bank Receipt Vouchers
	function bank_receipt()
	{
		$data = new coa;
		// Debit array
	 $arrayDebit = $data->seleted_coa('1,2,13');
		// Credit array
	 $arrayCredit = $data->seleted_coa('2,13');
		return View('admin/accounts/bank_receipt',compact('arrayDebit','arrayCredit'));
	}
	
	// Cash Receipt Vouchers
	function cash_receipt()
	{
		$data = new coa;
		// Debit array
	 $arrayDebit = $data->seleted_coa('1,2,13');
		// Credit array
	 $arrayCredit = $data->seleted_coa('2,13');
		return View('admin/accounts/cash_receipt',compact('arrayDebit','arrayCredit'));
	}
	
	// Cash Pay Vouchers
	function cash_pay()
	{
		$data = new coa;
		// Debit array
	 $arrayDebit = $data->seleted_coa('1,2,13');
		// Credit array
	 $arrayCredit = $data->seleted_coa('2,13');
		return View('admin/accounts/cash_pay',compact('arrayDebit','arrayCredit'));
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
		$arrTrans[] = array("coa" => $strDebitAcc, "debit" => $vm_amount, "credit" => 0);
		$arrTrans[] = array("coa" => $strCreditAcc,"debit" => 0, "credit" => $vm_amount);
		foreach($arrTrans as $tran)
		{
			$arrayInsertDetail = array("vd_vm_id" => $last_master_id,
						"vd_coa_code" => $tran["coa"],
						"vd_debit" => $tran["debit"],
						"vd_credit" => $tran["credit"]);
			$sale = VoucherDetail::insert($arrayInsertDetail);
		}
		});
		$vm_type = Input::get('vm_type');
		// Redrect to sale page
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
			return View('admin.accounts.edit', compact('EditCOA','arrayCOA'));
		}
		catch (TestimonialNotFoundException $e) {
			$error = Lang::get('banners/message.error.update', compact('id'));
			return Redirect::route('banners')->with('error', $error);
		}
	}
	
	public function postEdit($id = null)
	{
		/*$rules = array(
            'shop_name'  => 'required',
            'shop_address'  => 'required',
												'shop_code'  => 'required',
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
			return Redirect::back()->withInput()->withErrors($validator);
        }*/
		$data = new coa();
		$arrayEdit = $data->all_coa();
		$arrayInsert = array("coa_account" => Input::get('coa_account'), 
																							"coa_code" => Input::get('coa_code'),
																							"parent_id" => Input::get('parent_id'));
		
		$arrayEdit->coa_account = Input::get('coa_account');
		$arrayEdit->coa_code = Input::get('coa_code');
		$arrayEdit->parent_id = Input::get('parent_id');
		
		COA::where('coa_id', $id)->update(
			[
			'coa_account' => $arrayEdit->coa_account,
			'coa_code' => $arrayEdit->coa_code,
			'parent_id' => $arrayEdit->parent_id
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
	public function destroy($id)
	{
		//
	}

}
