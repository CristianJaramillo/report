## Report Laravel

Report Laravel es una aplicación web en desarrollo para el control de solicitudes de clientes a un centro de soporte la cual permite generar y distribuir las demandas del servicio ademas de llevar un control sobre los incidentes que se presentan.

## Instalación

La instalación de Report Laravel resulta muy sencilla solo situate en la carpeta del projecto utilizando tu terminal y ejecuta la siguiente linea.

	composer update

Ahora crearemos la base de datos en mysql ejecuta la siguientes lineas puedes realizar las modificaciones que requieras solo recuerda establecerlos tambien en `app/config/app.php`.

	SET time_zone = '-06:00';
	CREATE DATABASE IF NOT EXISTS report CHARACTER SET latin1 COLLATE latin1_spanish_ci;

### Opcional

Por ultimo crearemos las tablas y algunos registros utilizando los siguientes componentes los cuales ya han sido instalados y deveran ser removidos de `composer.json` para un verción de producción.

 - [barryvdh/laravel-debugbar](https://github.com/barryvdh/laravel-debugbar)
 - [fzaninotto/faker](https://github.com/fzaninotto/faker)
 - [JeffreyWay/Laravel-4-Generators](https://github.com/JeffreyWay/Laravel-4-Generators)

Ejecutamos la siguientes lineas para crear las tablas y registros puede demorar un poco.

	php artisan migrate:install
	php artisan migrate --seed

## Bienvenido

Si todo a salido bien deverias poder ver esto.
<img src="https://raw.githubusercontent.com/CristianJaramillo/report/master/public/img/welcome.png"/>
