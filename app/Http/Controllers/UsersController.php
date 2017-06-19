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
use Hash;
use Auth;


class UsersController extends Controller {

  public function index(){
		$users = DB::table('users')->orderBy('id', 'desc')->get();
		return View('admin.users.index', compact('users'));	
	}
				
	public function listUers(){
		$users = DB::table('users')->orderBy('id', 'desc')->get();
		return View('admin.users.index', compact('users'));	
	}
	
	public function addUsers(){
		$data = new User;
        $patentPermission = $data->all_parent_permission();
        $childPermission = $data->all_child_permission();
		$shops = DB::table('shops')->orderBy('shop_id', 'desc')->get();
		return View('admin.users.add',compact('shops','patentPermission','childPermission'));	
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
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
			return Redirect::back()->withInput()->withErrors($validator);
        }
		$data = new User();
		$permission_checked = Input::get('permission');
		if(!empty($permission_checked))
        	$arrayChickList = implode(',', $permission_checked);
		else
			$arrayChickList = "";
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
		$data->user_permission = $arrayChickList;
		
		if($data->save()){
			return redirect()->route("users")->with('message','User added successfully!');
		}
		else{
			return Redirect::back()->with('error', Lang::get('banners/message.error.create'));;
		}
	}
	
	public function getEdit($id = null)
    {
		try {
			$data = new User;
            $patentPermission = $data->all_parent_permission();
            $childPermission = $data->all_child_permission();
            $user_permission =  $data->user_permissions($id);
			$users = DB::table('users')->where('id', $id)->first();
			if(Auth::user()->user_type == 2)
				$shops = DB::table('shops')->orderBy('shop_id', 'desc')->get();
			else
				$shops = DB::table('shops')->where('shop_id', Auth::user()->shop_id)->orderBy('shop_id', 'desc')->get();
			return View('admin.users.edit', compact('users','shops','patentPermission','childPermission','user_permission'));
		}
		catch (TestimonialNotFoundException $e) {
			$error = Lang::get('banners/message.error.update', compact('id'));
			return Redirect::route('banners')->with('error', $error);
		}
		
	}
	
	public function postEdit($id = null)
    {
		$data = new User();
		$rules = array(
            'first_name'  => 'required',
            'last_name'  => 'required',
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
        $permission_checked = Input::get('permission');
        if(!empty($permission_checked))
        	$arrayChickList = implode(',', $permission_checked);
        else
        	$arrayChickList = "";
		$data->first_name = Input::get('first_name');
		$data->last_name = Input::get('last_name');
		if(!empty(Input::get('password')))
			$data->password = Hash::make(Input::get('password'));
		$data->login_name = Input::get('login_name');
		$data->gender = Input::get('gender');
		$data->email = Input::get('email');
		$data->city = Input::get('city');
		$data->address = Input::get('address');
		$data->shop_id = Input::get('shop_id');
		$data->user_type = (int)Input::get('user_type');
		$data->user_permission = $arrayChickList;
		if(!empty(Input::get('password')))
		{
			User::where('id', $id)->update(
			[
			'first_name' => $data->first_name,
			'last_name' => $data->last_name,
			'password' => $data->password,
			'login_name' => $data->login_name,
			'gender' => $data->gender,
			'email' => $data->email,
			'city' => $data->city,
			'shop_id' => $data->shop_id,
			'user_type' => $data->user_type,
			'address' => $data->address,
			'user_permission'=> $data->user_permission,
			]);
		}	
		else
		{
			User::where('id', $id)->update(
			[
			'first_name' => $data->first_name,
			'last_name' => $data->last_name,
			'login_name' => $data->login_name,
			'gender' => $data->gender,
			'email' => $data->email,
			'city' => $data->city,
			'shop_id' => $data->shop_id,
			'user_type' => $data->user_type,
			'address' => $data->address,
			'user_permission'=> $data->user_permission,
			]);}
			return redirect()->route("users")->with('message','User update successfully!');
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

    // Delete User
	public function delete_user()
	{
		$DelID = Input::get('DelID');
		DB::table('users')->where('id', $DelID)->delete();
		$ID = DB::table('users')->where('id', $DelID)->first();
		if ($ID === null) 
		   echo "delete"; 
		else
			echo "sorry";
	}

	// view_permissions
    public function view_permissions()
    {
        $user_id = Input::get('ID');
        $data = new User;
        $patentPermission = $data->all_parent_permission();
        $childPermission = $data->all_child_permission();
        $user_permission =  $data->user_permissions($user_id);
        $user = DB::table('users')->where('id', $user_id)->first();
        return View('dialogs.show_permissions',compact('user','patentPermission','childPermission','user_permission'));
    }
}