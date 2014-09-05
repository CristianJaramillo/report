<?php

// Composer: "fzaninotto/faker": "v1.3.0"

use Faker\Factory as Faker;
use Report\Entities\Post;
use Report\Entities\Report;
use Report\Entities\User;

class PostTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		$report = Report::all()->lists('id');

		$user = User::all()->lists('id');

		foreach(range(1, 100) as $index)
		{
			Post::create([
				'report_id' => $faker->randomElement($report),
				'user_id'   => $faker->randomElement($user),
				'message'   => $faker->text,
				'type'      => $faker->randomElement(['private', 'public'])
			]);
		}

	}

}