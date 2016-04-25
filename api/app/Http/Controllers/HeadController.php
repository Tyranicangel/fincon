<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use DB;
use App\User;
use App\Session;
use App\Transaction;
use App\Account;
use Carbon\Carbon;

class HeadController extends Controller {

	public function get_approval_list(){
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		return Transaction::where('company','=',$admin->users->company)->with('accountdet')->with('incometypedet')->with('exptypedet')->with(array('details'=>function($query){
					$query->where('active','=',1)->with('sourcedets')->with('partydets');
				}))->where('status','=',1)->orderBy('duedate')->get();
	}


	public function approve_trans(){
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		DB::beginTransaction();
		try{
			$trans=Transaction::where('id','=',Request::get('transid'))->first();
			$trans->approved_on=$date;
			$trans->status=2;
			$trans->save();
			$account=Account::where('id','=',$trans->account)->first();
			if($trans->type=='1')
			{
				$account->expenditure=$account->expenditure+$trans->amount;
				$account->balance=$account->balance-$trans->amount;
			}
			else
			{
				$account->income=$account->income+$trans->amount;
				$account->balance=$account->balance+$trans->amount;
			}
			$account->save();
		}
		catch(Exception $e){
			DB::rollback();
		}
		DB::commit();
		return Transaction::where('company','=',$admin->users->company)->with('accountdet')->with('incometypedet')->with('exptypedet')->with(array('details'=>function($query){
					$query->where('active','=',1)->with('sourcedets')->with('partydets');
				}))->where('status','=',1)->orderBy('duedate')->get();
	}

}
