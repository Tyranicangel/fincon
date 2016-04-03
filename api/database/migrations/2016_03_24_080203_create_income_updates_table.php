<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomeUpdatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('income_updates', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('updated_by')->unsigned();
			$table->foreign('updated_by')->references('id')->on('users');
			$table->integer('active')->unsigned();
			$table->string('name',100);
			$table->integer('account')->unsigned();
			$table->foreign('account')->references('id')->on('accounts');
			$table->integer('type')->unsigned();
			$table->foreign('type')->references('id')->on('income_types');
			$table->string('repeat_type',100);
			$table->string('interval_slot',100);
			$table->decimal('amount',20,2);
			$table->integer('income')->unsigned();
			$table->foreign('income')->references('id')->on('incomes');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('income_updates');
	}

}
