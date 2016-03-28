<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('companies', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('created_by')->unsigned()->default(0);
			$table->string('name',100);
			$table->text('address');
			$table->string('phone',20);
			$table->string('email',100)->unique();
			$table->string('website',100);
			$table->text('contact');
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
		Schema::drop('companies');
	}

}
