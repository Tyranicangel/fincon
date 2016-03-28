<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomeSourceUpdatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('income_source_updates', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('updated_by')->unsigned();
			$table->foreign('updated_by')->references('id')->on('users');
			$table->integer('income_source')->unsigned();
			$table->foreign('income_source')->references('id')->on('income_sources');
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
		Schema::drop('income_source_updates');
	}

}
