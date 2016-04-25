<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionUpdatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transaction_updates', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('updated_by')->unsigned();
			$table->foreign('updated_by')->references('id')->on('users');
			$table->integer('active')->unsigned()->default(1);
			$table->integer('account')->unsigned();
			$table->foreign('account')->references('id')->on('accounts');
			$table->string('name',100);
			$table->integer('income_type')->unsigned();
			$table->integer('exp_type')->unsigned();
			$table->decimal('amount',20,2);
			// $table->decimal('partial',20,2);
			// $table->decimal('remainder',20,2);
			$table->integer('type')->unsigned();
			$table->integer('expenditure')->unsigned();
			$table->integer('income')->unsigned();
			$table->date('duedate');
			$table->text('remarks');
			$table->integer('transaction')->unsigned();
			$table->foreign('transaction')->references('id')->on('transactions');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('transaction_updates');
	}

}
