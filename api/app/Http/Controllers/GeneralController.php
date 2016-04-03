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
use App\ExpType;
use App\ExpTypeUpdate;
use App\IncomeType;
use App\IncomeTypeUpdate;
use Carbon\Carbon;

class GeneralController extends Controller {

	public function activate_income_type(){
		$itid=Request::get('type_id');
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		DB::beginTransaction();
		try{
			$it=IncomeType::where('id','=',$itid)->first();
			$itu=new IncomeTypeUpdate;
			$itu->updated_by=$admin->users->id;
			$itu->type=$it->type;
			$itu->income_type=$it->id;
			$itu->active=$it->active;
			$itu->save();
			$it->active=1;
			$it->save();
		}
		catch(Exception $e){
			DB::rollback();
		}
		DB::commit();
		return IncomeType::where('company','=',$admin->users->company)->orderBy('id')->get();
	}

	public function deactivate_income_type(){
		$itid=Request::get('type_id');
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		DB::beginTransaction();
		try{
			$it=IncomeType::where('id','=',$itid)->first();
			$itu=new IncomeTypeUpdate;
			$itu->updated_by=$admin->users->id;
			$itu->type=$it->type;
			$itu->income_type=$it->id;
			$itu->active=$it->active;
			$itu->save();
			$it->active=0;
			$it->save();
		}
		catch(Exception $e){
			DB::rollback();
		}
		DB::commit();
		return IncomeType::where('company','=',$admin->users->company)->orderBy('id')->get();
	}

	public function save_income_type(){
		$type=Request::all();
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		if(array_key_exists('id', $type)){
			DB::beginTransaction();
			try{
				$it=IncomeType::where('id','=',$type['id'])->first();
				$itu=new IncomeTypeUpdate;
				$itu->updated_by=$admin->users->id;
				$itu->income_type=$it->id;
				$itu->active=$it->active;
				$itu->save();
				$it->type=$type['type'];
				$it->save();
			}
			catch(Exception $e){
				DB::rollback();
			}
			DB::commit();
		}
		else
		{
			$itacheck=IncomeType::where('type','=',$type['type'])->where('company','=',$admin->users->company)->count();
			if($itacheck==0)
			{
				DB::beginTransaction();
				try{
					$it=new IncomeType;
					$it->type=$type['type'];
					$it->company=$admin->users->company;
					$it->created_by=$admin->users->id;
					$it->save();
				}
				catch(Exception $e){
					DB::rollback();
				}
				DB::commit();
			}
			else
			{
				return array("error","This type already in use");
			}
		}
		$itlist=IncomeType::where('company','=',$admin->users->company)->orderBy('id')->get();
		return array("success",$itlist);
	}

	public function get_income_types(){
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		return IncomeType::where('company','=',$admin->users->company)->orderBy('id')->get();
	}

	public function activate_exp_type(){
		$etid=Request::get('type_id');
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		DB::beginTransaction();
		try{
			$et=ExpType::where('id','=',$etid)->first();
			$etu=new ExpTypeUpdate;
			$etu->updated_by=$admin->users->id;
			$etu->type=$et->type;
			$etu->exp_type=$et->id;
			$etu->active=$et->active;
			$etu->save();
			$et->active=1;
			$et->save();
		}
		catch(Exception $e){
			DB::rollback();
		}
		DB::commit();
		return ExpType::where('company','=',$admin->users->company)->orderBy('id')->get();
	}

	public function deactivate_exp_type(){
		$etid=Request::get('type_id');
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		DB::beginTransaction();
		try{
			$et=ExpType::where('id','=',$etid)->first();
			$etu=new ExpTypeUpdate;
			$etu->updated_by=$admin->users->id;
			$etu->type=$et->type;
			$etu->exp_type=$et->id;
			$etu->active=$et->active;
			$etu->save();
			$et->active=0;
			$et->save();
		}
		catch(Exception $e){
			DB::rollback();
		}
		DB::commit();
		return ExpType::where('company','=',$admin->users->company)->orderBy('id')->get();
	}

	public function save_exp_type(){
		$type=Request::all();
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		if(array_key_exists('id', $type)){
			DB::beginTransaction();
			try{
				$et=ExpType::where('id','=',$type['id'])->first();
				$etu=new ExpTypeUpdate;
				$etu->updated_by=$admin->users->id;
				$etu->exp_type=$et->id;
				$etu->active=$et->active;
				$etu->save();
				$et->type=$type['type'];
				$et->save();
			}
			catch(Exception $e){
				DB::rollback();
			}
			DB::commit();
		}
		else
		{
			$etacheck=ExpType::where('type','=',$type['type'])->where('company','=',$admin->users->company)->count();
			if($etacheck==0)
			{
				DB::beginTransaction();
				try{
					$et=new ExpType;
					$et->type=$type['type'];
					$et->company=$admin->users->company;
					$et->created_by=$admin->users->id;
					$et->save();
				}
				catch(Exception $e){
					DB::rollback();
				}
				DB::commit();
			}
			else
			{
				return array("error","This type already in use");
			}
		}
		$etlist=ExpType::where('company','=',$admin->users->company)->orderBy('id')->get();
		return array("success",$etlist);
	}

	public function get_exp_types(){
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		return ExpType::where('company','=',$admin->users->company)->orderBy('id')->get();
	}

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
			$au->bank=$a->bank;
			$au->branch=$a->branch;
			$au->ifsc=$a->ifsc;
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
			$au->bank=$a->bank;
			$au->branch=$a->branch;
			$au->ifsc=$a->ifsc;
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
				$au->bank=$a->bank;
				$au->branch=$a->branch;
				$au->ifsc=$a->ifsc;
				$au->obalance=$a->obalance;
				$au->balance=$a->balance;
				$au->expenditure=$a->expenditure;
				$au->income=$a->income;
				$au->account=$a->id;
				$au->active=$a->active;
				$au->save();
				$a->name=$account['name'];
				$a->number=$account['number'];
				$a->bank=$account['bank'];
				$a->branch=$account['branch'];
				$a->ifsc=$account['ifsc'];
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
					$a->bank=$account['bank'];
					$a->branch=$account['branch'];
					$a->ifsc=$account['ifsc'];
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
