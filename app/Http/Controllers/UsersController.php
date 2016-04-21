<?php namespace App\Http\Controllers;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Redirect;
use Sentry;
use app\Http\Request;
use View;
use DB;
use Validator;
use Input;
use Session;
use App\User;
use App\Shop;

class UsersController extends Controller {

  public function index(){
		//return 'user list';
		$users = DB::table('users')->orderBy('id', 'desc')->get();
		//print_r($users);
		return View('admin.users.index', compact('users'));	
	}
				
				public function listUers(){
		//return 'user list';
		$users = DB::table('users')->orderBy('id', 'desc')->get();
		//print_r($users);
		return View('admin.users.index', compact('users'));	
	}
	
	public function addUsers(){
		//return 'test';
		$shops = DB::table('shops')->orderBy('shop_id', 'desc')->get();
		return View('admin.users.add',compact('shops'));	
	}
	
	public function createUser(){
		$rules = array(
            'first_name'  => 'required',
            'last_name'  => 'required',
			'email'  => 'required|email|unique:users',
			'password'  => 'required|min:5',
			'login_name'  => 'required',
			'gender'  => 'required',
			'user_type'  => 'required',
			'confirm_password'  => 'required',
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
          //  echo "validation issues...";
			return Redirect::back()->withInput()->withErrors($validator);
        }
		//return 'i am here';
		// Input::get('first_name');

		$data = new User();
		
		$data->first_name = Input::get('first_name');
		$data->last_name = Input::get('last_name');
		$data->password = bcrypt(Input::get('password'));
		$data->login_name = Input::get('login_name');
		$data->gender = Input::get('gender');
		$data->email = Input::get('email');
		$data->city = Input::get('city');
		$data->address = Input::get('address');
		$data->shop_id = (int)Input::get('shop_id');
		$data->user_type = (int)Input::get('user_type');
		
		if($data->save()){
			//echo 'i am in save';
			return redirect()->route("users")->with('message','Success');
			//return redirect()->action('HomeController@index');
		}
		else{
			return Redirect::back()->with('error', Lang::get('banners/message.error.create'));;
		}
	}
	
	public function getEdit($id = null)
    {
		//return $id;
		try {
			$users = DB::table('users')->where('id', $id)->first();
			$shops = DB::table('shops')->orderBy('shop_id', 'desc')->get();
			return View('admin.users.edit', compact('users','shops'));
		}
		catch (TestimonialNotFoundException $e) {
			$error = Lang::get('banners/message.error.update', compact('id'));
			return Redirect::route('banners')->with('error', $error);
		}
		
	}
	
	public function postEdit($id = null)
    {
		//$users = DB::table('users')->where('id', $id)->first();
		
		$data = new User();
		
		$rules = array(
            'first_name'  => 'required',
            'last_name'  => 'required',
			'email'  => 'required|email|unique:users',
			'login_name'  => 'required',
			'city'  => 'required',
			'gender'  => 'required',
			'address'  => 'required',
			'user_type'  => 'required',
        );
	
	    // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);
        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
			return Redirect::back()->withInput()->withErrors($validator);
        }
		// is new image uploaded?
		$data->first_name = Input::get('first_name');
		$data->last_name = Input::get('last_name');
		if(!empty(Input::get('password')))
		$data->password = Input::get('password');
		$data->login_name = Input::get('login_name');
		$data->gender = Input::get('gender');
		$data->email = Input::get('email');
		$data->city = Input::get('city');
		$data->address = Input::get('address');
		$data->user_type = (int)Input::get('user_type');
		//print_r($data);
			
			User::where('id', $id)->update(
			[
			'first_name' => $data->first_name,
			'last_name' => $data->last_name,
			'password' => $data->password,
			'login_name' => $data->login_name,
			'gender' => $data->gender,
			'email' => $data->email,
			'city' => $data->city,
			'user_type' => $data->user_type,
			'address' => $data->address
			]);
			return Redirect::back();
    }

	public function getModalDelete($id = null)
    {
       $model = 'users';
        $confirm_route = $error = null;
        try {
			$banner = DB::table('users')->where('id', $id)->first();
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            $error = Lang::get('banners/message.error.delete');
            return View('backend/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
        }
        $confirm_route = route('delete/user',['id' => $banner->id]);
        return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
    }
	
	public function getDelete($id = null)
    {
		$folderName = '/uploads/banners/';
        try {
			$banner = DB::table('banners')->where('id', $id)->first();
			Banners::destroy($id);
			// Lets remove image from directory
			File::delete(public_path() . $folderName.$banner->image_name);
			File::delete(public_path() . $folderName."thumbs/thumb_".$banner->image_name);
			
            // Prepare the success message
            $success = Lang::get('banners/message.success.delete');
            // Redirect to the user management page
            return Redirect::route('banners')->with('success', $success);
        
		} catch (UserNotFoundException $e) {
            // Prepare the error message
            $error = Lang::get('banners/message.error.delete', compact('id' ));
			// Redirect to the user management page
            return Redirect::route('banners')->with('error', $error);
        }
    }
}