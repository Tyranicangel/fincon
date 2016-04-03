<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpenditurePartiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('expenditure_parties', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('created_by')->unsigned();
			$table->foreign('created_by')->references('id')->on('users');
			$table->integer('expenditure')->unsigned();
			$table->foreign('expenditure')->references('id')->on('expenditures');
			$table->integer('third_party')->unsigned();
			$table->foreign('third_party')->references('id')->on('third_parties');
			$table->text('remarks');
			$table->decimal('amount',20,2);
			$table->integer('active')->unsigned()->default(1);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('expenditure_parties');
	}

}
