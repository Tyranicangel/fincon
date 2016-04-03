<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class IncomeSource extends Model {

	public function sourcedets(){
		return $this->belongsTo('App\Source','source','id');
	}

}
