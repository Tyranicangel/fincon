<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use App\User;
use App\Session;
use App\Role;
use Carbon\Carbon;
use App\Password;
use DB;

class CommonController extends Controller {

	public function reset_password(){
		$date=Carbon::now();
		$tkn=Request::header('JWT-AuthToken');
		$user=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		$pass=Request::all();
		if($user->users->password!=hash("sha256",$user->users->username.$pass['old'].'fincon'))
		{
			return array('error',"Old password you entered is wrong");
		}
		else
		{
			DB::beginTransaction();
			try{
				$p=new Password;
				$p->user=$user->users->id;
				$p->old_password=$user->users->password;
				$p->new_password=hash("sha256",$user->users->username.$pass['new'].'fincon');
				$p->change_type="user_update";
				$p->save();
				$u=User::where('id','=',$user->users->id)->first();
				$u->password=hash("sha256",$user->users->username.$pass['new'].'fincon');
				$u->save();
			}
			catch(Exception $e){
				DB::rollback();
			}
			DB::commit();
			return array("success","Password reset successfully");
		}
	}

	public function login(){
		$date=Carbon::now();
		$userdata=Request::all();
		$usercount=User::where('username','=',$userdata['username'])->where('password','=',hash("sha256",$userdata['username'].$userdata['password'].'fincon'))->where('active','=','1')->count();
		if($usercount==1)
		{
			$user=User::where('username','=',$userdata['username'])->where('password','=',hash("sha256",$userdata['username'].$userdata['password'].'fincon'))->where('active','=','1')->first();
			$refreshtoken=hash("sha256",$userdata['username'].microtime().'noobtard123');
			$login=new Session;
			$login->user=$user->id;
			$login->login=$date;
			$login->token=$refreshtoken;
			$login->expiry=Carbon::now()->addHours(3);
			$login->save();
			$role=Role::where('id','=',$user->role)->first();
			return array('statusCode'=>'202','message'=>$refreshtoken,'userrole'=>$user->role,'link'=>$role->link);
		}
		else
		{
			$userdat=User::where('username','=',$userdata['username'])->count();
			if($userdat==1)
			{
				return array('statusCode'=>'401','message'=>'Please enter correct password.');
			}
			else
			{
				return array('statusCode'=>'401','message'=>'Please enter valid username.');
			}
		}
	}

	public function checkuser(){
		$date=Carbon::now();
		$tkn= Request::header('JWT-AuthToken');
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		return array('id'=>$admin->users->id,'name'=>$admin->users->name,'designation'=>$admin->users->designation);
	}

}
