<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountUpdatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('account_updates', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('updated_by')->unsigned();
			$table->foreign('updated_by')->references('id')->on('users');
			$table->integer('active')->unsigned()->default(1);
			$table->string('name',100);
			$table->decimal('number',20,0);
			$table->string('bank',100);
			$table->string('branch',100);
			$table->string('ifsc',20);
			$table->decimal('obalance',20,2);
			$table->decimal('balance',20,2);
			$table->decimal('expenditure',20,2);
			$table->decimal('income',20,2);
			$table->integer('account')->unsigned();
			$table->foreign('account')->references('id')->on('accounts');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('account_updates');
	}

}
