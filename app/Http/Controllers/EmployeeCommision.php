<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use DB,Input,Redirect,paginate;
use App\Commision;
use Validator;

class EmployeeCommision extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data = new Commision;
	 	$arrayUsers = $data->all_users();
		return View('admin/commision/add_commision',compact('arrayUsers'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//echo "commision"; die;
		$rules = array(
            'user_id'  => 'required',
            'total_count'  => 'required'
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
          //  echo "validation issues...";
			return Redirect::back()->withInput()->withErrors($validator);
        }
        $user_id = Input::get('user_id');
        $vm_date = date("Y-m-d",strtotime(Input::get('vm_date')));
		$get_row = Commision::where('user_id', '=', $user_id)->where('created_at', '=', $vm_date)->first();
		if ($get_row === null) 
		{
			$arrayInsert = array('user_id' => Input::get('user_id'), 
							 "total_count" => Input::get('total_count'),
							 "created_at" => date("Y-m-d",strtotime(Input::get('vm_date')))
							 );
			$last_sale_id = Commision::insertGetId($arrayInsert);
			// Redrect to view commision page
			return Redirect::to('admin/commision/add_commision')->with('message', 'Commision added successfully!');
		}
		else
		{
			return Redirect::to('admin/commision/add_commision')->with('message_error', 'Commision already added!');
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
	public function show()
	{
		$data = new Commision;
		$arrayUsers = $data->all_users();
		$start_date 	= date("Y-m-d",strtotime(Input::get('start_date')));
		$end_date 		= date("Y-m-d",strtotime(Input::get('end_date')));
		$user_id		= Input::get('user_id');
		if(empty($user_id)) $user_id = 0;
		if(empty($start_date) || $start_date == "1970-01-01") $start_date = "2016-08-01";
		if(empty($end_date) || $end_date == "1970-01-01") $end_date = date("Y-m-d");
	 	$arrayCommision = $data->all_commision($start_date, $end_date, $user_id);
	 	$arrayCounts 	= $data->all_commision_counts($start_date, $end_date, $user_id);
	 	$arrayCounts	= $arrayCounts[0]->total_count;
		return View('admin/commision/view_commision',compact('arrayCommision','arrayCounts','arrayUsers','start_date','end_date'));
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
