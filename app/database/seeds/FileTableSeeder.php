<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use Report\Entities\File;
use Report\Entities\Post;

class FileTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		$post = Post::all()->lists('id');

		foreach(range(1, 20) as $index)
		{

			$file = $faker->uuid.'.'.$faker->fileExtension;

			File::create([
				'post_id' => $faker->randomElement($post),
				'path'    => $file
			]);
		}
	}

}