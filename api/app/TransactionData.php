<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionData extends Model {

	public function sourcedets(){
		return $this->belongsTo('App\Source','source','id');
	}

	public function partydets(){
		return $this->belongsTo('App\ThirdParty','party','id');
	}

}
