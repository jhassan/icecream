<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use View;
use DB;
use Validator;
use Input;
use Session;
use App\Vendor;
use App\COA;
use Redirect;


class VendorController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View('admin.vendors.index');
	}

	public function addVendors(){
		return View('admin.vendors.add');	
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

		$rules = array(
            'vendor_name'  => 'required'
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
          //  echo "validation issues...";
			return Redirect::back()->withInput()->withErrors($validator);
        }

		$data = new Vendor();
		
		$data->vendor_name = Input::get('vendor_name');
		$data->vendor_address = Input::get('vendor_address');
		$data->vendor_phone = Input::get('vendor_phone');
		$data->is_active = (Input::has('is_active')) ? 1 : 0;
		
		if($data->save()){
			// Create COA of new suppliers
			$coa_code = COA::where('coa_code', 'LIKE', "515%")->max('coa_code');
			$supplier_id = Vendor::max('vendor_id');
			// Insert in COA table
			$arrayInsert = array('coa_account' => Input::get('vendor_name'), 
								 "coa_code" => $coa_code+1,
								 "coa_credit" => 0,
								 "coa_debit" => 0,
								 "parent_id" => 185,
								 "supplier_id" => $supplier_id
								 );
			$last_sale_id = COA::insertGetId($arrayInsert);	
			return redirect()->route("vendors")->with('message','Vendor added successfully!');
		}
		else{
			return Redirect::back()->with('error', Lang::get('banners/message.error.create'));;
		}
	}

	public function listVendors(){
		$vendors = DB::table('vendors')->orderBy('vendor_id', 'desc')->get();
		return View('admin.vendors.index', compact('vendors'));	
	}

	public function getEdit($id)
	{
		//
		try {
			$vendors = DB::table('vendors')->where('vendor_id', $id)->first();
			return View('admin.vendors.edit', compact('vendors'));
		}
		catch (TestimonialNotFoundException $e) {
			$error = Lang::get('banners/message.error.update', compact('id'));
			return Redirect::route('banners')->with('error', $error);
		}
	}

	public function postEdit($id = null)
	{
		$rules = array(
            'vendor_name'  => 'required'
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
			return Redirect::back()->withInput()->withErrors($validator);
        }
		$data = new Vendor();
		
		$data->vendor_name = Input::get('vendor_name');
		$data->vendor_address = Input::get('vendor_address');
		$data->vendor_phone = Input::get('vendor_phone');
		$data->is_active = (Input::has('is_active')) ? 1 : 0;
		
		Vendor::where('vendor_id', $id)->update(
			[
			'vendor_name' => $data->vendor_name,
			'vendor_address' => $data->vendor_address,
			'vendor_phone' => $data->vendor_phone,
			'is_active' => $data->is_active
			]);
			//return Redirect::back();
		//$vendors = DB::table('vendors')->orderBy('vendor_id', 'desc')->get();
		//return View('admin.vendors.index', compact('vendors'));
		return redirect()->route("vendors")->with('message','Vendor update successfully!');
	}

	public function delete_vendor()
	{
		// echo "Delete"; die;
		$DelID = Input::get('DelID');
		$vendors = Vendor::where('vendor_id', '=', $DelID)->delete();
		$ID = Vendor::where('vendor_id', '=', $DelID)->first();
		if ($ID === null) 
		   echo "delete"; 
		else
			echo "sorry";
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
