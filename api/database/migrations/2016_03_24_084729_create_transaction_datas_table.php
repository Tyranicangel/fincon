<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionDatasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transaction_datas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('created_by')->unsigned();
			$table->foreign('created_by')->references('id')->on('users');
			$table->integer('transaction')->unsigned();
			$table->foreign('transaction')->references('id')->on('transactions');
			$table->integer('source')->unsigned();
			$table->integer('party')->unsigned();
			$table->text('remarks');
			$table->decimal('amount',20,2);
			// $table->decimal('partial',20,2);
			// $table->decimal('remainder',20,2);
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
		Schema::drop('transaction_datas');
	}

}
