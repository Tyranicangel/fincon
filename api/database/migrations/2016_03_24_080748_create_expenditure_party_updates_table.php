<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpenditurePartyUpdatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('expenditure_party_updates', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('updated_by')->unsigned();
			$table->foreign('updated_by')->references('id')->on('users');
			$table->integer('expenditure_party')->unsigned();
			$table->foreign('expenditure_party')->references('id')->on('expenditure_parties');
			$table->decimal('amount',20,2);
			$table->decimal('paid',20,2);
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
		Schema::drop('expenditure_party_updates');
	}

}
