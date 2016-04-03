<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Expenditure extends Model {

	public function accountdet(){
		return $this->belongsTo('App\Account','account','id');
	}

	public function typedet(){
		return $this->belongsTo('App\ExpType','type','id');
	}

	public function parties(){
		return $this->hasMany('App\ExpenditureParty','expenditure','id');
	}

}
