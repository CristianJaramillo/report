<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('DepartamentTableSeeder');
		$this->call('CategoryTableSeeder');
		$this->call('UserTableSeeder');
		$this->call('ReportTableSeeder');
		$this->call('PostTableSeeder');
		$this->call('PageTableSeeder');
		$this->call('FileTableSeeder');
	}

}
