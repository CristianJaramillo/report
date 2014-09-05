<?php

// Composer: "fzaninotto/faker": "v1.3.0"

use Faker\Factory as Faker;
use Report\Entities\Category;

class CategoryTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		$categories = [
			'Diseñador',
			'Jefe de Academia',
			'Profesor',
			'Técnico de Hardware',
			'Técnico de Software'
		];

		foreach ($categories as $category) {
			Category::create(['name' => $category]);
		}

	}

}