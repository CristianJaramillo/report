<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
use GeoIp2\Database\Reader as GeoIp;
use Report\Entities\Category;
use Report\Entities\Departament;
use Report\Entities\User;

class UserTableSeeder extends Seeder {

	public function run()
	{
		// Permite obtener campos de forma arbitraria.
		$faker = Faker::create();

		$departament = Departament::all()->lists('id');

		$category = Category::all()->lists('id');

		$type = 'client';

		// Permitre identificar origen de la solicitud.
		$geoIp = new GeoIp(app_path('database/GeoLite2-City.mmdb'));

		foreach(range(1, 100) as $index)
		{

			if ($index > 90) {
				$type = 'technical';
			}

			$ip = $faker->ipv4;

			try {
				
				$record = $geoIp->city($ip);

				$user = new User();

				$user->full_name      = $faker->name;
				$user->username       = $faker->numberBetween($min = 2011000000, $max = 2015000000);
				$user->email          = $faker->email;
				$user->password       = '123456';
				$user->category_id    = $faker->randomElement($departament);
				$user->departament_id = $faker->randomElement($category);
				$user->type           = $type;
				$user->ip_address     = $ip;
				$user->country        = $record->country->names['es'];
				$user->city           = $record->mostSpecificSubdivision->names['es'];

				$user->authorized = $faker->randomElement([true, false]);

				$user->save();

			} catch (Exception $e) {
				echo "undefined location for ip: ".$ip."\n";
			}

		}		

		
		$user = new User();

		$user->full_name      = 'Cristian Gerardo Jaramillo Cruz';
		$user->username       = '2011081473';
		$user->email          = 'cristian_gerar@hotmail.com';
		$user->password       = 'friki454_';
		$user->category_id    = '5';
		$user->departament_id = '7';
		$user->type           = 'admin';
		$user->authorized     = true;
		$user->ip_address     = '201.141.89.52';

		$record = $geoIp->city($user->ip_address);
		
		$user->country = $record->country->names['es'];
		$user->city    = $record->mostSpecificSubdivision->names['es'];
		
		$user->save();
		
	}

}