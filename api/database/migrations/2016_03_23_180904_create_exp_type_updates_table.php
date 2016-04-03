<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpTypeUpdatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('exp_type_updates', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('type',100);
			$table->integer('updated_by')->unsigned();
			$table->foreign('updated_by')->references('id')->on('users');
			$table->integer('active')->unsigned();
			$table->integer('exp_type')->unsigned();
			$table->foreign('exp_type')->references('id')->on('exp_types');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('exp_type_updates');
	}

}
