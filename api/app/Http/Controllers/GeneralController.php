<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use DB;
use App\User;
use App\Session;
use App\Role;
use App\UserUpdate;
use App\Account;
use App\AccountUpdate;
use Carbon\Carbon;

class GeneralController extends Controller {

	public function activate_account(){
		$aid=Request::get('account_id');
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		DB::beginTransaction();
		try{
			$a=Account::where('id','=',$aid)->first();
			$au=new AccountUpdate;
			$au->updated_by=$admin->users->id;
			$au->name=$a->name;
			$au->number=$a->number;
			$au->obalance=$a->obalance;
			$au->balance=$a->balance;
			$au->expenditure=$a->expenditure;
			$au->income=$a->income;
			$au->account=$a->id;
			$au->active=$a->active;
			$au->save();
			$a->active=1;
			$a->save();
		}
		catch(Exception $e){
			DB::rollback();
		}
		DB::commit();
		return Account::where('company','=',$admin->users->company)->orderBy('id')->get();
	}

	public function deactivate_account(){
		$aid=Request::get('account_id');
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		DB::beginTransaction();
		try{
			$a=Account::where('id','=',$aid)->first();
			$au=new AccountUpdate;
			$au->updated_by=$admin->users->id;
			$au->name=$a->name;
			$au->number=$a->number;
			$au->obalance=$a->obalance;
			$au->balance=$a->balance;
			$au->expenditure=$a->expenditure;
			$au->income=$a->income;
			$au->account=$a->id;
			$au->active=$a->active;
			$au->save();
			$a->active=0;
			$a->save();
		}
		catch(Exception $e){
			DB::rollback();
		}
		DB::commit();
		return Account::where('company','=',$admin->users->company)->orderBy('id')->get();
	}

	public function save_account(){
		$account=Request::all();
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		if(array_key_exists('id', $account)){
			DB::beginTransaction();
			try{
				$a=Account::where('id','=',$account['id'])->first();
				$au=new AccountUpdate;
				$au->updated_by=$admin->users->id;
				$au->name=$a->name;
				$au->number=$a->number;
				$au->obalance=$a->obalance;
				$au->balance=$a->balance;
				$au->expenditure=$a->expenditure;
				$au->income=$a->income;
				$au->account=$a->id;
				$au->active=$a->active;
				$au->save();
				$a->name=$account['name'];
				$a->number=$account['number'];
				$a->obalance=$account['obalance'];
				$a->balance=$a->balance+$account['obalance']-$au['obalance'];
				$a->save();
			}
			catch(Exception $e){
				DB::rollback();
			}
			DB::commit();
		}
		else
		{
			$acheck=Account::where('number','=',$account['number'])->where('company','=',$admin->users->company)->count();
			if($acheck==0)
			{
				DB::beginTransaction();
				try{
					$a=new Account;
					$a->name=$account['name'];
					$a->number=$account['number'];
					$a->obalance=$account['obalance'];
					$a->balance=$account['obalance'];
					$a->company=$admin->users->company;
					$a->created_by=$admin->users->id;
					$a->save();
				}
				catch(Exception $e){
					DB::rollback();
				}
				DB::commit();
			}
			else
			{
				return array("error","This account already in use");
			}
		}
		$alist=Account::where('company','=',$admin->users->company)->orderBy('id')->get();
		return array("success",$alist);
	}

	public function get_accounts(){
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		return Account::where('company','=',$admin->users->company)->orderBy('id')->get();
	}

	public function get_roles(){
		return Role::where('id','>',2)->get();
	}

	public function get_users(){
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		return User::where('company','=',$admin->users->company)->where('role','!=',2)->with('roles')->orderBy('role')->orderBy('id')->get();
	}

	public function activate_user(){
		$uid=Request::get('user_id');
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		DB::beginTransaction();
		try{
			$u=User::where('id','=',$uid)->first();
			$uu=new UserUpdate;
			$uu->updated_by=$admin->users->id;
			$uu->name=$u->name;
			$uu->email=$u->email;
			$uu->address=$u->address;
			$uu->phoneno=$u->phoneno;
			$uu->designation=$u->designation;
			$uu->role=$u->role;
			$uu->user=$u->id;
			$uu->active=$u->active;
			$uu->save();
			$u->active=1;
			$u->save();
		}
		catch(Exception $e){
			DB::rollback();
		}
		DB::commit();
		return User::where('company','=',$admin->users->company)->where('role','!=',2)->with('roles')->orderBy('role')->orderBy('id')->get();
	}

	public function deactivate_user(){
		$uid=Request::get('user_id');
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		DB::beginTransaction();
		try{
			$u=User::where('id','=',$uid)->first();
			$uu=new UserUpdate;
			$uu->updated_by=$admin->users->id;
			$uu->name=$u->name;
			$uu->email=$u->email;
			$uu->address=$u->address;
			$uu->phoneno=$u->phoneno;
			$uu->designation=$u->designation;
			$uu->role=$u->role;
			$uu->user=$u->id;
			$uu->active=$u->active;
			$uu->save();
			$u->active=0;
			$u->save();
		}
		catch(Exception $e){
			DB::rollback();
		}
		DB::commit();
		return User::where('company','=',$admin->users->company)->where('role','!=',2)->with('roles')->orderBy('role')->orderBy('id')->get();
	}

	public function save_user(){
		$user=Request::all();
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		if(array_key_exists('id', $user)){
			DB::beginTransaction();
			try{
				$u=User::where('id','=',$user['id'])->first();
				$uu=new UserUpdate;
				$uu->updated_by=$admin->users->id;
				$uu->name=$u->name;
				$uu->email=$u->email;
				$uu->address=$u->address;
				$uu->phoneno=$u->phoneno;
				$uu->designation=$u->designation;
				$uu->role=$u->role;
				$uu->user=$u->id;
				$uu->active=$u->active;
				$uu->save();
				$u->name=$user['name'];
				$u->email=$user['email'];
				$u->address=$user['address'];
				$u->phoneno=$user['phoneno'];
				$u->designation=$user['designation'];
				$u->role=$user['role'];
				$u->save();
			}
			catch(Exception $e){
				DB::rollback();
			}
			DB::commit();
		}
		else
		{
			$ucheck=User::where('username','=',$user['username'])->count();
			if($ucheck==0)
			{
				DB::beginTransaction();
				try{
					$u=new User;
					$u->username=$user['username'];
					$u->name=$user['name'];
					$u->email=$user['email'];
					$u->address=$user['address'];
					$u->phoneno=$user['phoneno'];
					$u->designation=$user['designation'];
					$u->password=hash("sha256",$user['username'].'123456fincon');
					$u->role=$user['role'];
					$u->company=$admin->users->company;
					$u->created_by=$admin->users->id;
					$u->save();
				}
				catch(Exception $e){
					DB::rollback();
				}
				DB::commit();
			}
			else
			{
				return array("error","This username already in use");
			}
		}
		$ulist=User::where('company','=',$admin->users->company)->where('role','!=',2)->with('roles')->orderBy('role')->orderBy('id')->get();
		return array("success",$ulist);
	}

}
