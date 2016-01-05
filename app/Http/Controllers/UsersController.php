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
use App\Users;



class UsersController extends Controller {

    public function listBanners(){
		
		$banners = DB::table('banners')->orderBy('id', 'desc')->get();
		return View('admin.banners.list', compact('banners'));	
	}
	
	 public function show($id){
	 	
	 	$banners = DB::table('banners')->where('id', $id)->first();
		return View('admin.banners.show', compact('banners'));
	 }
	
	public function addUsers(){
		//return 'test';
		return View('users.add');	
	}
	
	public function createBanner(){
		//return 'here';
		$rules = array(
            'first_name'  => 'required',
            'last_name'  => 'required',
			'password'  => 'required|min:5'
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            //echo "validation issues...";
			return Redirect::back()->withInput()->withErrors($validator);
        }
		
		/*if ($file = Input::file('pic'))
        {
            $fileName        = $file->getClientOriginalName();
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $folderName      = '/uploads/banners/';
            $destinationPath = public_path() . $folderName;
            $safeName        = str_random(10).'.'.$extension;
            $file->move($destinationPath, $safeName);
        }
		
		// Lets create thumbs of images as well.
		$img = Image::make($destinationPath.$safeName);
		$img->resize(200, 200);*/
		//$img->save($destinationPath."thumbs/thumb_".$safeName);
		
		$data = new Users();
		
		$data->first_name = Input::get('first_name');
		$data->last_name = Input::get('last_name');
		$data->password = Input::get('password');
		//$data->image_name = $safeName;
		
		if($data->save()){
			return Redirect::back()->with('success', Lang::get('banners/message.success.create'));
		}
		else{
			return Redirect::back()->with('error', Lang::get('banners/message.error.create'));;
		}
	}
	
	public function getEdit($id = null)
    {
		try {
			$banners = DB::table('banners')->where('id', $id)->first();
			return View('admin.banners.edit', compact('banners'));
		}
		catch (TestimonialNotFoundException $e) {
			$error = Lang::get('banners/message.error.update', compact('id'));
			return Redirect::route('banners')->with('error', $error);
		}
		
	}
	
	public function postEdit($id = null)
    {
	
		$banner = DB::table('banners')->where('id', $id)->first();
		
		$data = new Banners();
		
		$rules = array(
            'title'        => 'required',
            'banner_text'  => 'required'
        );
	
	    // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);
        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
			return Redirect::back()->withInput()->withErrors($validator);
        }
		// is new image uploaded?
         	if ($file = Input::file('pic'))
            { 
				$fileName        = $file->getClientOriginalName();
                $extension       = $file->getClientOriginalExtension() ?: 'png';
                $folderName      = '/uploads/banners/';
                $destinationPath = public_path() . $folderName;
                $safeName        = str_random(10).'.'.$extension;
                $file->move($destinationPath, $safeName);

                //delete old pic if exists
                if(File::exists(public_path() . $folderName.$banner->image_name))
                {
                    File::delete(public_path() . $folderName.$banner->image_name);
					File::delete(public_path() . $folderName."thumbs/thumb_".$banner->image_name);
                }

                //save new file path into db
                $data->image_name = $safeName;	
            	
				// Lets create thumbs of images as well.
				$img = Image::make($destinationPath.$safeName);
				$img->resize(200, 200);
				$img->save($destinationPath."thumbs/thumb_".$safeName);
				
				}
				else{
					$data->image_name = $banner->image_name;
				}
				
				$data->title = Input::get('title');
				$data->caption = Input::get('caption');
				$data->banner_text = Input::get('banner_text');
				
				Banners::where('id', $id)->update(
				[
				'title' => $data->title,
				'caption' => $data->caption,
				'banner_text' => $data->banner_text,
				'image_name' => $data->image_name
				]);
				return Redirect::back()->with('success', Lang::get('banners/message.success.update'));;	
    }

	public function getModalDelete($id = null)
    {
       $model = 'banners';
        $confirm_route = $error = null;
        try {
			$banner = DB::table('banners')->where('id', $id)->first();
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            $error = Lang::get('admin/banners/message.error.delete');
            return View('backend/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
        }
        $confirm_route = route('delete/banner',['id' => $banner->id]);
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