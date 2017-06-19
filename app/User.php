<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['first_name','last_name','login_name', 'email', 'password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	public function all_parent_permission()
    {
        $arrayParentPermission = DB::table('permissions')->whereRaw('parent_id = 0')->get();
        return $arrayParentPermission;
    }

    public function all_child_permission()
    {
        $arrayChieldPerission = DB::table('permissions')->get();
        return $arrayChieldPerission;
    }

    // Get user permissions
    public function user_permissions($id)
    {
        $arrayPermission = DB::table('users')
                    ->select('user_permission')    
                    ->where('id', '=', $id)
                    ->get();
        return $arrayPermission[0]->user_permission;
    }

}
