<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use DB,Input,Redirect,paginate;
use App\COA;
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
		// Insert in COA table
		$arrayInsert = array('coa_account' => Input::get('coa_account'), 
																							"coa_code" => Input::get('coa_code'),
																							"parent_id" => Input::get('parent_id'));
		$last_sale_id = COA::insertGetId($arrayInsert);
		// Redrect to sale page
		return Redirect::to('admin/accounts/index_coa');
	
	}
	
	// View Coa
	function view_coa()
	{
		$data = new coa;
	 $arrayCOA = $data->all_coa();
		return View('admin/accounts/show_coa',compact('arrayCOA'));
		
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
