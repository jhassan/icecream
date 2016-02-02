<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Input;
use Auth;
use Redirect;
use Hash;
use View;
use Session;

use Illuminate\Http\Request;

class ClientController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('index');
	}
	
	public function showLogin()
	{
		// show the form
		return View::make('index');
	}
	
	public function doLogin()
	{
		// validate the info, create rules for the inputs
		$rules = array(
		'email'    => 'required|email', // make sure the email is an actual email
		'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
		);
		
		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);
		
		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
		return Redirect::to('/')
		->withErrors($validator) // send back all errors to the login form
		->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
		} else {
		
		// create our user data for the authentication
		$userdata = array(
		'email'     => Input::get('email'),
		'password'  => Input::get('password')
		);
		//echo $password = Hash::make('123456'); die;
	//print_r($userdata); die;
		// attempt to do the login
		if (Auth::attempt($userdata)) {
			$user = Auth::getUser(); 
			Session::set('user_id', $user->id);
			//print_r($t); die;
			
		return Redirect::to('sale');
		// validation successful!
		// redirect them to the secure section or whatever
		// return Redirect::to('secure');
		// for now we'll just echo success (even though echoing in a controller is bad)
		//echo 'SUCCESS!';
		
		} else {        

		// validation not successful, send back to form 
		return Redirect::to('/');
		
		}
		
		}
	}
	
	public function doLogout()
	{
		Auth::logout(); // log the user out of our application
		return Redirect::to('/'); // redirect the user to the login screen
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
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
