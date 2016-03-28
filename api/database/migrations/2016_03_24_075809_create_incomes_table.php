<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('incomes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('created_by')->unsigned();
			$table->foreign('created_by')->references('id')->on('users');
			$table->integer('active')->unsigned()->default(1);
			$table->integer('account')->unsigned();
			$table->foreign('account')->references('id')->on('accounts');
			$table->integer('type')->unsigned();
			$table->integer('repeat')->unsigned();
			$table->string('interval',100);
			$table->date('duedate');
			$table->integer('status')->unsigned();
			$table->decimal('amount',20,2);
			$table->decimal('received',20,2);
			$table->decimal('left',20,2);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('incomes');
	}

}
