<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reports', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('title');
			$table->string('message');
			$table->integer('client_id')->unsigned();
			// $table->foreign('client_id')->references('id')->on('users');
			$table->integer('technical_id')->unsigned();
			// $table->foreign('technical_id')->references('id')->on('users');
			$table->enum('status', ['Sin Asignar', 'Asignado', utf8_decode('Análizando'), 'Resuelto', 'Sin Resolver'])->default('Sin Asignar');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('reports');
	}

}
