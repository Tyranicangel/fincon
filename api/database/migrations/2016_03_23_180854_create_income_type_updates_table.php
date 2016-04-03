<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomeTypeUpdatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('income_type_updates', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('type',100);
			$table->integer('updated_by')->unsigned();
			$table->foreign('updated_by')->references('id')->on('users');
			$table->integer('active')->unsigned();
			$table->integer('income_type')->unsigned();
			$table->foreign('income_type')->references('id')->on('income_types');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('income_type_updates');
	}

}
