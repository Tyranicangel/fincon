<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Income extends Model {

	public function accountdet(){
		return $this->belongsTo('App\Account','account','id');
	}

	public function typedet(){
		return $this->belongsTo('App\IncomeType','type','id');
	}

	public function sources(){
		return $this->hasMany('App\IncomeSource','income','id');
	}

}
