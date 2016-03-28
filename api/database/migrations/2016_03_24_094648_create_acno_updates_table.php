<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcnoUpdatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('acno_updates', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('updated_by')->unsigned();
			$table->foreign('updated_by')->references('id')->on('users');
			$table->integer('active')->unsigned()->default(1);
			$table->integer('third_party')->unsigned();
			$table->foreign('third_party')->references('id')->on('third_parties');
			$table->string('acname',100);
			$table->string('acno',30);
			$table->unique('acno','third_party');
			$table->string('bank',100);
			$table->string('branch',100);
			$table->string('ifsc',20);
			$table->string('micrcode',20);
			$table->integer('ac')->unsigned();
			$table->foreign('ac')->references('id')->on('acnos');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('acno_updates');
	}

}
