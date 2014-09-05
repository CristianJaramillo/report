<?php

// Composer: "fzaninotto/faker": "v1.3.0"

use Faker\Factory as Faker;
use Report\Entities\Report;
use Report\Entities\User;

class ReportTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		$user = User::where('type', 'client')->lists('id');

		foreach(range(1, 10) as $index)
		{
			Report::create([
				'title'     => $faker->company,
				'message'   => $faker->text,
				'client_id' => $faker->randomElement($user)
			]);
		}
	}

}