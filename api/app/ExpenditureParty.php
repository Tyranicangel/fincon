<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenditureParty extends Model {

	public function partydets(){
		return $this->belongsTo('App\ThirdParty','third_party','id');
	}

}
