<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB,Input,Redirect,paginate;
use App\User;

class Commision extends Model {

	protected $table = 'commisions';

	public function all_users()
	{
		$arrayUsers = DB::table('users')
		            ->orderBy('first_name', 'asc')
		            ->get();
		return $arrayUsers;
	}

	// show all commisions counts
	public function all_commision_counts($start_date, $end_date, $user_id){
		if($user_id == 0)
		{
			$arrayCounts = DB::table('commisions')
			->join('users', 'users.id', '=', 'commisions.user_id')
			->select(DB::raw('SUM(total_count) AS total_count'))
			->whereRaw('commisions.created_at >= "'.$start_date.'" AND commisions.created_at <= "'.$end_date.'" ')
			->get();
			return $arrayCounts;
		}
		else
		{
			$arrayCounts = DB::table('commisions')
			->join('users', 'users.id', '=', 'commisions.user_id')
			->select(DB::raw('SUM(total_count) AS total_count'))
			->whereRaw('commisions.user_id = '.(int)$user_id.' AND commisions.created_at >= "'.$start_date.'" AND commisions.created_at <= "'.$end_date.'" ')
			->get();
			return $arrayCounts;
		}
		
	}

	// show all commisions
	public function all_commision($start_date, $end_date, $user_id){
		if($user_id == 0)
		{
			$arrayCounts = DB::table('commisions')
			->join('users', 'users.id', '=', 'commisions.user_id')
			->select('commisions.*','first_name','last_name')
			->whereRaw('commisions.created_at >= "'.$start_date.'" AND commisions.created_at <= "'.$end_date.'" ')
			->paginate(10);
			return $arrayCounts;
		}
		else
		{
			$arrayCounts = DB::table('commisions')
			->join('users', 'users.id', '=', 'commisions.user_id')
			->select('commisions.*','first_name','last_name')
			->whereRaw('commisions.user_id = '.(int)$user_id.' AND commisions.created_at >= "'.$start_date.'" AND commisions.created_at <= "'.$end_date.'" ')
			->paginate(10);
			return $arrayCounts;
		}
	}

}
