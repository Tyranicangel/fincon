<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transactions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('created_by')->unsigned();
			$table->foreign('created_by')->references('id')->on('users');
			$table->integer('active')->unsigned()->default(1);
			$table->integer('company')->unsigned();
			$table->foreign('company')->references('id')->on('companies');
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
			$table->integer('approved_by')->unsigned();
			$table->foreign('approved_by')->references('id')->on('users');
			$table->timestamp('approved_on');
			$table->integer('paid_by')->unsigned();
			$table->foreign('paid_by')->references('id')->on('users');
			$table->timestamp('paid_on');
			$table->date('duedate');
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
		Schema::drop('transactions');
	}

}
