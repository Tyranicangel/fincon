<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('accounts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('created_by')->unsigned();
			$table->foreign('created_by')->references('id')->on('users');
			$table->integer('active')->unsigned()->default(1);
			$table->integer('company')->unsigned();
			$table->foreign('company')->references('id')->on('companies');
			$table->string('name',100);
			$table->decimal('number',20,0)->default(0);
			$table->decimal('obalance',20,2);
			$table->decimal('balance',20,2);
			$table->decimal('expenditure',20,2);
			$table->decimal('income',20,2);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('accounts');
	}

}
