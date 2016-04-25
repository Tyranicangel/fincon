<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {

	public function accountdet(){
		return $this->belongsTo('App\Account','account','id');
	}

	public function exptypedet(){
		return $this->belongsTo('App\ExpType','type','id');
	}

	public function incometypedet(){
		return $this->belongsTo('App\IncomeType','type','id');
	}

	public function details(){
		return $this->hasMany('App\TransactionData','transaction','id');
	}
}
