<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Role;
use App\User;
use App\Company;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('RoleTableSeeder');
		$this->call('CompanyTableSeeder');
		$this->call('UserTableSeeder');
	}

}

class CompanyTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
		Company::create(['name'=>'Admin','address'=>'Admin','phone'=>'00','email'=>'admin@admin.com','website'=>'www.google.com','contact'=>'admin']);
	}

}

class RoleTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
		Role::create(['role'=>'Admin','link'=>'admin.main']);
		Role::create(['role'=>'General','link'=>'general.main']);
		Role::create(['role'=>'Accounts','link'=>'accounts.main']);
		Role::create(['role'=>'Head','link'=>'head.main']);
	}

}

class UserTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
		User::create(['username'=>'admin','name'=>'Admin','email'=>'admin@admin.com','address'=>'Admin','phoneno'=>'admin','designation'=>'Admin','password'=>'6c0ac46c9003a3bb4dedbbf5601c4aee25ba810f61d2aaf34d45e12fcc18a2a1','role'=>1,'company'=>1]);
	}

}
