<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use DB;
use App\User;
use App\Session;
use Carbon\Carbon;
use App\Company;
use App\CompanyUpdate;

class AdminController extends Controller {

	public function get_company(){
		return Company::where('id','!=',1)->get();
	}

	public function activate_company(){
		$cid=Request::get('company_id');
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		DB::beginTransaction();
		try{
			$c=Company::where('id','=',$cid)->first();
			$cu=new CompanyUpdate;
			$cu->updated_by=$admin->users->id;
			$cu->name=$c->name;
			$cu->address=$c->address;
			$cu->phone=$c->phone;
			$cu->email=$c->email;
			$cu->website=$c->website;
			$cu->contact=$c->contact;
			$cu->active=$c->active;
			$cu->company=$c->id;
			$cu->save();
			$c->active=1;
			$c->save();
			$users=User::where('company','=',$cid)->update(array("active"=>1));
		}
		catch(Exception $e){
			DB::rollback();
		}
		DB::commit();
		return Company::where('id','!=',1)->get();
	}

	public function deactivate_company(){
		$cid=Request::get('company_id');
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		DB::beginTransaction();
		try{
			$c=Company::where('id','=',$cid)->first();
			$cu=new CompanyUpdate;
			$cu->updated_by=$admin->users->id;
			$cu->name=$c->name;
			$cu->address=$c->address;
			$cu->phone=$c->phone;
			$cu->email=$c->email;
			$cu->website=$c->website;
			$cu->contact=$c->contact;
			$cu->active=$c->active;
			$cu->company=$c->id;
			$cu->save();
			$c->active=0;
			$c->save();
			$users=User::where('company','=',$cid)->update(array("active"=>0));
		}
		catch(Exception $e){
			DB::rollback();
		}
		DB::commit();
		return Company::where('id','!=',1)->get();
	}

	public function save_company(){
		$company=Request::all();
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		if(array_key_exists('id', $company)){
			DB::beginTransaction();
			try{
				$c=Company::where('id','=',$company['id'])->first();
				$cu=new CompanyUpdate;
				$cu->updated_by=$admin->users->id;
				$cu->name=$c->name;
				$cu->address=$c->address;
				$cu->phone=$c->phone;
				$cu->email=$c->email;
				$cu->website=$c->website;
				$cu->contact=$c->contact;
				$cu->active=$c->active;
				$cu->company=$c->id;
				$cu->save();
				$c->name=$company['name'];
				$c->address=$company['address'];
				$c->phone=$company['phone'];
				$c->email=$company['email'];
				$c->website=$company['website'];
				$c->contact=$company['contact'];
				$c->save();
			}
			catch(Exception $e){
				DB::rollback();
			}
			DB::commit();
		}
		else
		{
			DB::beginTransaction();
			try{
				$c=new Company;
				$c->name=$company['name'];
				$c->address=$company['address'];
				$c->phone=$company['phone'];
				$c->email=$company['email'];
				$c->website=$company['website'];
				$c->contact=$company['contact'];
				$c->created_by=$admin->users->id;
				$c->save();
				$u=new User;
				$u->username="admin_".$c->id;
				$u->name=$company['name'].' Admin';
				$u->email=$company['email'];
				$u->address=$company['address'];
				$u->phoneno=$company['phone'];
				$u->designation="Company Admin";
				$u->password=hash("sha256","admin_".$c->id.'123456fincon');
				$u->role=2;
				$u->company=$c->id;
				$u->created_by=$admin->users->id;
				$u->save();
			}
			catch(Exception $e){
				DB::rollback();
			}
			DB::commit();
		}
		return Company::where('id','!=',1)->get();
	}
}
