<?php

// Composer: "fzaninotto/faker": "v1.3.0"

use Faker\Factory as Faker;
use Report\Entities\Page;

class PageTableSeeder extends Seeder {

	public function run()
	{

		/**
		 * Páginas por defecto para la aplicación.
		 */
		$pages = [
			[
				'name'        => 'sing-in',
				'title'       => 'Sistema de Reportes',
				'description' => 'Sistema para el control de la asignación de reportes a los técnicos disponibles',
				'app'         => 'apps.home.sing-in',
			],
			[
				'name'        => 'sing-up',
				'title'       => 'Registro',
				'description' => 'Registro - Sistema de Repostes',
				'app'         => 'apps.home.sing-up',
			],
			[
				'name'        => 'restore',
				'title'       => 'Restauración de Contraseña',
				'description' => 'Restauración de Contraseña - Sistema de Repostes',
				'app'         => 'apps.home.restore',
			],
			[
				'name'        => 'help',
				'title'       => 'Ayuda',
				'description' => 'Ayuda para usuarios sobre como interactuar con el Sistema de Repostes',
				'app'         => 'apps.home.help',
			],
			[
				'name'        => '401',
				'title'       => 'Error 401',
				'description' => 'Error 401 - Sistema de Repostes',
				'app'         => 'apps.error.401',
			],
			[
				'name'        => '403',
				'title'       => 'Error 403',
				'description' => 'Error 403 - Sistema de Repostes',
				'app'         => 'apps.error.403',
			],
			[
				'name'        => '404',
				'title'       => 'Error 404',
				'description' => 'Error 404 - Sistema de Repostes',
				'app'         => 'apps.error.404',
			],
			[
				'name'        => '500',
				'title'       => 'Error 500',
				'description' => 'Error 500 - Sistema de Repostes',
				'app'         => 'apps.error.500',
			],
			[
				'name'        => 'account',
				'title'       => 'Cuenta',
				'description' => 'Cuenta - Sistema de Repostes',
				'menu'        => 'menus.admin',
			],
			[
				'name'        => 'dashboard',
				'title'       => 'Panel de Control',
				'description' => 'Panel de Control - Sistema de Repostes',
				'menu'        => 'menus.admin',
				'app'         => 'apps.tool.dashboard',
			],
			[
				'name'        => 'table-ui',
				'title'       => 'Table UI',
				'description' => 'Table UI - Sistema de Repostes',
				'menu'        => 'menus.admin',
				'app'         => 'apps.tool.table-ui',
			],
		];

		foreach ($pages as $page) {
			Page::create($page);
		}

	}

}