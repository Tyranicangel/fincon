<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpenditureUpdatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('expenditure_updates', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('updated_by')->unsigned();
			$table->foreign('updated_by')->references('id')->on('users');
			$table->integer('active')->unsigned()->default(1);
			$table->integer('account')->unsigned();
			$table->foreign('account')->references('id')->on('accounts');
			$table->integer('type')->unsigned();
			$table->integer('repeat')->unsigned();
			$table->string('interval',100);
			$table->date('duedate');
			$table->integer('status')->unsigned();
			$table->decimal('amount',20,2);
			$table->decimal('paid',20,2);
			$table->decimal('left',20,2);
			$table->integer('expenditure')->unsigned();
			$table->foreign('expenditure')->references('id')->on('expenditures');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('expenditure_updates');
	}

}
