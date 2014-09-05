<?php

// Composer: "fzaninotto/faker": "v1.3.0"

use Faker\Factory as Faker;
use Report\Entities\Departament;

class DepartamentTableSeeder extends Seeder {

	public function run()
	{

		$departaments = [
			[
				'id'        => 1,
				'name' 	    => 'Activo Fijo',
				'ext_phone' => '1001'
			],
			[
				'id'        => 2,
				'name' 	    => 'Administración',
				'ext_phone' => '1002'
			],
			[
				'id'        => 3,
				'name' 	    => 'Dirección',
				'ext_phone' => '1003'
			],
			[
				'id'        => 4,
				'name' 	    => 'Decanato',
				'ext_phone' => '1004'
			],
			[
				'id'        => 5,
				'name' 	    => 'Gestión Escolar',
				'ext_phone' => '1005'
			],
			[
				'id'        => 6,
				'name' 	    => 'Sub Dirección',
				'ext_phone' => '1006'
			],
			[
				'id'        => 7,
				'name' 	    => 'UTEyCV',
				'ext_phone' => '1007'
			]
		];

		foreach ($departaments as $departament) {
			Departament::create($departament);
		}

	}

}