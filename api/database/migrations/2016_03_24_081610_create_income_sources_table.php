<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomeSourcesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('income_sources', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('created_by')->unsigned();
			$table->foreign('created_by')->references('id')->on('users');
			$table->integer('income')->unsigned();
			$table->foreign('income')->references('id')->on('incomes');
			$table->integer('source')->unsigned();
			$table->text('remarks');
			$table->decimal('amount',20,2);
			$table->decimal('received',20,2);
			$table->decimal('left',20,2);
			$table->integer('status')->unsigned();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('income_sources');
	}

}
