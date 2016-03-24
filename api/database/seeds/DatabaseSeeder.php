<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Role;
use App\User;

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
		$this->call('UserTableSeeder');
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
		User::create(['username'=>'admin','name'=>'Admin','email'=>'admin@admin.com','address'=>'Admin','phoneno'=>'admin','designation'=>'Admin','password'=>'6c0ac46c9003a3bb4dedbbf5601c4aee25ba810f61d2aaf34d45e12fcc18a2a1','role'=>1,'created_by'=>0]);
	}

}
