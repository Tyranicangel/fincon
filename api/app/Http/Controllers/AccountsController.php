<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use DB;
use App\User;
use App\Session;
use App\Role;
use App\ThirdParty;
use App\ThirdPartyUpdate;
use App\Source;
use App\SourceUpdate;
use App\ExpType;
use App\IncomeType;
use App\Account;
use App\Expenditure;
use App\ExpenditureParty;
use App\ExpenditureUpdate;
use App\ExpenditurePartyUpdate;
use App\Income;
use App\IncomeSource;
use App\IncomeUpdate;
use App\IncomeSourceUpdate;
use Carbon\Carbon;

class AccountsController extends Controller {

	public function activate_income(){
		$iid=Request::get('income_id');
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		DB::beginTransaction();
		try{
			$i=Income::where('id','=',$iid)->first();
			$iu=new IncomeUpdate;
			$iu->updated_by=$admin->users->id;
			$iu->name=$i->name;
			$iu->account=$i->account;
			$iu->type=$i->type;
			$iu->repeat_type=$i->repeat_type;
			$iu->interval_slot=$i->interval_slot;
			$iu->active=$i->active;
			$iu->income=$i->id;
			$iu->save();
			$i->active=1;
			$i->save();
		}
		catch(Exception $e){
			DB::rollback();
		}
		DB::commit();
		return Income::where('company','=',$admin->users->company)->with('accountdet')->with('typedet')->get();
	}

	public function deactivate_income(){
		$iid=Request::get('income_id');
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		DB::beginTransaction();
		try{
			$i=Income::where('id','=',$iid)->first();
			$iu=new IncomeUpdate;
			$iu->updated_by=$admin->users->id;
			$iu->name=$i->name;
			$iu->account=$i->account;
			$iu->type=$i->type;
			$iu->repeat_type=$i->repeat_type;
			$iu->interval_slot=$i->interval_slot;
			$iu->active=$i->active;
			$iu->income=$i->id;
			$iu->save();
			$i->active=0;
			$i->save();
		}
		catch(Exception $e){
			DB::rollback();
		}
		DB::commit();
		return Income::where('company','=',$admin->users->company)->with('accountdet')->with('typedet')->get();
	}

	public function get_income_list(){
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		return Income::where('company','=',$admin->users->company)->with('accountdet')->with('typedet')->get();
	}

	public function save_income(){
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		$income=Request::all();
		if(array_key_exists('id',$income))
		{
			DB::beginTransaction();
			try{
				$i=Income::where('id','=',$income['id'])->with('sources')->first();
				$iu=new IncomeUpdate;
				$iu->updated_by=$admin->users->id;
				$iu->name=$i->name;
				$iu->account=$i->account;
				$iu->type=$i->type;
				$iu->repeat_type=$i->repeat_type;
				$iu->interval_slot=$i->interval_slot;
				$iu->active=$i->active;
				$iu->income=$i->id;
				$iu->save();
				$i->name=$income['name'];
				$i->account=$income['account'];
				$i->type=$income['type'];
				$i->repeat_type=$income['repeat_type'];
				$i->interval_slot=$income['interval_slot'];
				$i->amount=0;
				$i->save();
				$sum=0;
				$slist=array();
				for($j=0;$j<count($income['sources']);$j++)
				{
					$is=IncomeSource::where('income','=',$i->id)->where('source','=',$income['sources'][$j]['source'])->first();
					if($is)
					{
						$isu=new IncomeSourceUpdate;
						$isu->updated_by=$admin->users->id;
						$isu->remarks=$is->remarks;
						$isu->amount=$is->amount;
						$isu->active=$is->active;
						$isu->income_source=$is->id;
						$isu->save();
						$is->amount=$income['sources'][$j]['amount'];
						$is->remarks=$income['sources'][$j]['remarks'];
						$sum+=$income['sources'][$j]['amount'];
						$is->active=1;
						array_push($slist,$is->source);
						$is->save();
					}
					else
					{
						$is=new IncomeSource;
						$is->created_by=$admin->users->id;
						$is->income=$i->id;
						$is->third_party=$income['sources'][$j]['source'];
						$is->amount=$income['sources'][$j]['amount'];
						$is->remarks=$income['sources'][$j]['remarks'];
						$sum+=$income['sources'][$j]['amount'];
						$is->save();
					}
				}
				$i->amount=$sum;
				$i->save();
				$islist=IncomeSource::where('income','=',$i->id)->get()->toArray();
				for($j=0;$j<count($islist);$j++)
				{
					if(in_array($islist[$j]['source'], $slist))
					{

					}
					else
					{
						$is=IncomeSource::where('id','=',$islist[$j]['id'])->first();
						$isu=new IncomeSourceUpdate;
						$isu->updated_by=$admin->users->id;
						$isu->remarks=$is->remarks;
						$isu->amount=$is->amount;
						$isu->active=$is->active;
						$isu->income_source=$is->id;
						$isu->save();
						$is->active=0;
						$is->save();
					}
				}
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
				$i=new Income;
				$i->created_by=$admin->users->id;
				$i->name=$income['name'];
				$i->company=$admin->users->company;
				$i->account=$income['account'];
				$i->type=$income['type'];
				$i->repeat_type=$income['repeat_type'];
				$i->interval_slot=$income['interval_slot'];
				$i->amount=0;
				$i->save();
				$sum=0;
				for($j=0;$j<count($income['sources']);$j++)
				{
					$is=new IncomeSource;
					$is->created_by=$admin->users->id;
					$is->income=$i->id;
					$is->source=$income['sources'][$j]['source'];
					$is->amount=$income['sources'][$j]['amount'];
					$is->remarks=$income['sources'][$j]['remarks'];
					$sum+=$income['sources'][$j]['amount'];
					$is->save();
				}
				$i->amount=$sum;
				$i->save();
			}
			catch(Exception $e)
			{
				DB::rollback();
			}
			DB::commit();
		}
	}

	public function get_income_details(){
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		$types=IncomeType::where('company','=',$admin->users->company)->where('active','=',1)->orderBy('type')->get();
		$accs=Account::where('company','=',$admin->users->company)->where('active','=',1)->orderBy('name')->get();
		$source=Source::where('company','=',$admin->users->company)->where('active','=',1)->orderBy('name')->get();
		if(Request::get('id')=='0')
		{
			return array($types,$accs,$source,array());
		}
		else
		{
			$income=Income::where('id','=',Request::get('id'))->with('accountdet')->with('typedet')->
			with(array('sources'=>function($query){
					$query->where('active','=',1)->with('sourcedets');
				}))->first()->toArray();
			$slist=array();
			for($i=0;$i<count($income['sources']);$i++)
			{
				array_push($slist,$income['sources'][$i]['source']);
			}
			return array($types,$accs,$source,$income,$slist);
		}
	}

	public function activate_exp(){
		$eid=Request::get('exp_id');
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		DB::beginTransaction();
		try{
			$e=Expenditure::where('id','=',$eid)->first();
			$eu=new ExpenditureUpdate;
			$eu->updated_by=$admin->users->id;
			$eu->name=$e->name;
			$eu->account=$e->account;
			$eu->type=$e->type;
			$eu->repeat_type=$e->repeat_type;
			$eu->interval_slot=$e->interval_slot;
			$eu->active=$e->active;
			$eu->expenditure=$e->id;
			$eu->save();
			$e->active=1;
			$e->save();
		}
		catch(Exception $e){
			DB::rollback();
		}
		DB::commit();
		return Expenditure::where('company','=',$admin->users->company)->with('accountdet')->with('typedet')->get();
	}

	public function deactivate_exp(){
		$eid=Request::get('exp_id');
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		DB::beginTransaction();
		try{
			$e=Expenditure::where('id','=',$eid)->first();
			$eu=new ExpenditureUpdate;
			$eu->updated_by=$admin->users->id;
			$eu->name=$e->name;
			$eu->account=$e->account;
			$eu->type=$e->type;
			$eu->repeat_type=$e->repeat_type;
			$eu->interval_slot=$e->interval_slot;
			$eu->active=$e->active;
			$eu->expenditure=$e->id;
			$eu->save();
			$e->active=0;
			$e->save();
		}
		catch(Exception $e){
			DB::rollback();
		}
		DB::commit();
		return Expenditure::where('company','=',$admin->users->company)->with('accountdet')->with('typedet')->get();
	}

	public function get_exp_list(){
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		return Expenditure::where('company','=',$admin->users->company)->with('accountdet')->with('typedet')->get();
	}

	public function save_exp(){
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		$exp=Request::all();
		if(array_key_exists('id',$exp))
		{
			DB::beginTransaction();
			try{
				$e=Expenditure::where('id','=',$exp['id'])->with('parties')->first();
				$eu=new ExpenditureUpdate;
				$eu->updated_by=$admin->users->id;
				$eu->name=$e->name;
				$eu->account=$e->account;
				$eu->type=$e->type;
				$eu->repeat_type=$e->repeat_type;
				$eu->interval_slot=$e->interval_slot;
				$eu->active=$e->active;
				$eu->expenditure=$e->id;
				$eu->save();
				$e->name=$exp['name'];
				$e->account=$exp['account'];
				$e->type=$exp['type'];
				$e->repeat_type=$exp['repeat_type'];
				$e->interval_slot=$exp['interval_slot'];
				$e->amount=0;
				$e->save();
				$sum=0;
				$plist=array();
				for($i=0;$i<count($exp['parties']);$i++)
				{
					$ep=ExpenditureParty::where('expenditure','=',$e->id)->where('third_party','=',$exp['parties'][$i]['third_party'])->first();
					if($ep)
					{
						$epu=new ExpenditurePartyUpdate;
						$epu->updated_by=$admin->users->id;
						$epu->remarks=$ep->remarks;
						$epu->amount=$ep->amount;
						$epu->active=$ep->active;
						$epu->expenditure_party=$ep->id;
						$epu->save();
						$ep->amount=$exp['parties'][$i]['amount'];
						$ep->remarks=$exp['parties'][$i]['remarks'];
						$sum+=$exp['parties'][$i]['amount'];
						$ep->active=1;
						array_push($plist,$ep->third_party);
						$ep->save();
					}
					else
					{
						$ep=new ExpenditureParty;
						$ep->created_by=$admin->users->id;
						$ep->expenditure=$e->id;
						$ep->third_party=$exp['parties'][$i]['third_party'];
						$ep->amount=$exp['parties'][$i]['amount'];
						$ep->remarks=$exp['parties'][$i]['remarks'];
						$sum+=$exp['parties'][$i]['amount'];
						$ep->save();
					}
				}
				$e->amount=$sum;
				$e->save();
				$eplist=ExpenditureParty::where('expenditure','=',$e->id)->get()->toArray();
				for($i=0;$i<count($eplist);$i++)
				{
					if(in_array($eplist[$i]['third_party'], $plist))
					{

					}
					else
					{
						$ep=ExpenditureParty::where('id','=',$eplist[$i]['id'])->first();
						$epu=new ExpenditurePartyUpdate;
						$epu->updated_by=$admin->users->id;
						$epu->remarks=$ep->remarks;
						$epu->amount=$ep->amount;
						$epu->active=$ep->active;
						$epu->expenditure_party=$ep->id;
						$epu->save();
						$ep->active=0;
						$ep->save();
					}
				}
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
				$e=new Expenditure;
				$e->created_by=$admin->users->id;
				$e->name=$exp['name'];
				$e->company=$admin->users->company;
				$e->account=$exp['account'];
				$e->type=$exp['type'];
				$e->repeat_type=$exp['repeat_type'];
				$e->interval_slot=$exp['interval_slot'];
				$e->amount=0;
				$e->save();
				$sum=0;
				for($i=0;$i<count($exp['parties']);$i++)
				{
					$ep=new ExpenditureParty;
					$ep->created_by=$admin->users->id;
					$ep->expenditure=$e->id;
					$ep->third_party=$exp['parties'][$i]['third_party'];
					$ep->amount=$exp['parties'][$i]['amount'];
					$ep->remarks=$exp['parties'][$i]['remarks'];
					$sum+=$exp['parties'][$i]['amount'];
					$ep->save();
				}
				$e->amount=$sum;
				$e->save();
			}
			catch(Exception $e)
			{
				DB::rollback();
			}
			DB::commit();
		}
	}

	public function get_exp_details(){
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		$types=ExpType::where('company','=',$admin->users->company)->where('active','=',1)->orderBy('type')->get();
		$accs=Account::where('company','=',$admin->users->company)->where('active','=',1)->orderBy('name')->get();
		$party=ThirdParty::where('company','=',$admin->users->company)->where('active','=',1)->orderBy('name')->get();
		if(Request::get('id')=='0')
		{
			return array($types,$accs,$party,array());
		}
		else
		{
			$exp=Expenditure::where('id','=',Request::get('id'))->with('accountdet')->with('typedet')->
			with(array('parties'=>function($query){
					$query->where('active','=',1)->with('partydets');
				}))->first()->toArray();
			$plist=array();
			for($i=0;$i<count($exp['parties']);$i++)
			{
				array_push($plist,$exp['parties'][$i]['third_party']);
			}
			return array($types,$accs,$party,$exp,$plist);
		}
	}

	public function activate_source(){
		$sid=Request::get('source_id');
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		DB::beginTransaction();
		try{
			$s=Source::where('id','=',$sid)->first();
			$su=new SourceUpdate;
			$su->updated_by=$admin->users->id;
			$su->name=$s->name;
			$su->description=$s->description;
			$su->type=$p->type;
			$su->active=$s->active;
			$su->source=$s->id;
			$su->save();
			$s->active=1;
			$s->save();
		}
		catch(Exception $e){
			DB::rollback();
		}
		DB::commit();
		return Source::where('company','=',$admin->users->company)->orderBy('id')->get();
	}

	public function deactivate_source(){
		$sid=Request::get('source_id');
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		DB::beginTransaction();
		try{
			$s=ThirdParty::where('id','=',$sid)->first();
			$su=new SourceUpdate;
			$su->updated_by=$admin->users->id;
			$su->name=$s->name;
			$su->description=$s->description;
			$su->type=$s->type;
			$su->active=$s->active;
			$su->source=$s->id;
			$su->save();
			$s->active=0;
			$s->save();
		}
		catch(Exception $e){
			DB::rollback();
		}
		DB::commit();
		return Source::where('company','=',$admin->users->company)->orderBy('id')->get();
	}

	public function save_source(){
		$source=Request::all();
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		if(array_key_exists('id', $source)){
			DB::beginTransaction();
			try{
				$s=Source::where('id','=',$source['id'])->first();
				$su=new SourceUpdate;
				$su->updated_by=$admin->users->id;
				$su->name=$s->name;
				$su->description=$s->description;
				$su->type=$s->type;
				$su->active=$s->active;
				$su->source=$s->id;
				$su->save();
				$s->name=$source['name'];
				$s->description=$source['description'];
				$s->type=$source['type'];
				$s->save();
			}
			catch(Exception $e){
				DB::rollback();
			}
			DB::commit();
		}
		else
		{
			$pcheck=Source::where('name','=',$source['name'])->where('company','=',$admin->users->company)->count();
			if($pcheck==0)
			{
				DB::beginTransaction();
				try{
					$s=new Source;
					$s->name=$source['name'];
					$s->description=$source['description'];
					$s->type=$source['type'];
					$s->company=$admin->users->company;
					$s->created_by=$admin->users->id;
					$s->save();
				}
				catch(Exception $e){
					DB::rollback();
				}
				DB::commit();
			}
			else
			{
				return array("error","This source already in use");
			}
		}
		$plist=Source::where('company','=',$admin->users->company)->orderBy('id')->get();
		return array("success",$plist);
	}

	public function get_sources(){
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		return Source::where('company','=',$admin->users->company)->orderBy('id')->get();
	}

	public function activate_party(){
		$pid=Request::get('party_id');
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		DB::beginTransaction();
		try{
			$p=ThirdParty::where('id','=',$pid)->first();
			$pu=new ThirdPartyUpdate;
			$pu->updated_by=$admin->users->id;
			$pu->name=$p->name;
			$pu->description=$p->description;
			$pu->type=$p->type;
			$pu->active=$p->active;
			$pu->third_party=$p->id;
			$pu->save();
			$p->active=1;
			$p->save();
		}
		catch(Exception $e){
			DB::rollback();
		}
		DB::commit();
		return ThirdParty::where('company','=',$admin->users->company)->orderBy('id')->get();
	}

	public function deactivate_party(){
		$pid=Request::get('party_id');
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		DB::beginTransaction();
		try{
			$p=ThirdParty::where('id','=',$pid)->first();
			$pu=new ThirdPartyUpdate;
			$pu->updated_by=$admin->users->id;
			$pu->name=$p->name;
			$pu->description=$p->description;
			$pu->type=$p->type;
			$pu->active=$p->active;
			$pu->third_party=$p->id;
			$pu->save();
			$p->active=0;
			$p->save();
		}
		catch(Exception $e){
			DB::rollback();
		}
		DB::commit();
		return ThirdParty::where('company','=',$admin->users->company)->orderBy('id')->get();
	}

	public function save_party(){
		$party=Request::all();
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		if(array_key_exists('id', $party)){
			DB::beginTransaction();
			try{
				$p=ThirdParty::where('id','=',$party['id'])->first();
				$pu=new ThirdPartyUpdate;
				$pu->updated_by=$admin->users->id;
				$pu->name=$p->name;
				$pu->description=$p->description;
				$pu->type=$p->type;
				$pu->active=$p->active;
				$pu->third_party=$p->id;
				$pu->save();
				$p->name=$party['name'];
				$p->description=$party['description'];
				$p->type=$party['type'];
				$p->save();
			}
			catch(Exception $e){
				DB::rollback();
			}
			DB::commit();
		}
		else
		{
			$pcheck=ThirdParty::where('name','=',$party['name'])->where('company','=',$admin->users->company)->count();
			if($pcheck==0)
			{
				DB::beginTransaction();
				try{
					$p=new ThirdParty;
					$p->name=$party['name'];
					$p->description=$party['description'];
					$p->type=$party['type'];
					$p->company=$admin->users->company;
					$p->created_by=$admin->users->id;
					$p->save();
				}
				catch(Exception $e){
					DB::rollback();
				}
				DB::commit();
			}
			else
			{
				return array("error","This party already in use");
			}
		}
		$plist=ThirdParty::where('company','=',$admin->users->company)->orderBy('id')->get();
		return array("success",$plist);
	}

	public function get_parties(){
		$tkn=Request::header('JWT-AuthToken');
		$date=Carbon::now();
		$admin=Session::where('token','=',$tkn)->where('expiry','>',$date)->whereHas('users',function($q){
				$q->where('active','=','1');
			})->first();
		return ThirdParty::where('company','=',$admin->users->company)->orderBy('id')->get();
	}

}
