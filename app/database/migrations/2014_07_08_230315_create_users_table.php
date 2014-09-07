<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('full_name');
			$table->string('username')->unique();
			$table->string('password');
			$table->string('email', 320)->unique();
			$table->integer('departament_id')->unsigned();
			$table->foreign('departament_id')->references('id')->on('departaments');
			$table->integer('category_id')->unsigned();
			$table->foreign('category_id')->references('id')->on('categories');
			$table->enum('type', ['admin', 'client', 'technical'])->default('client');
			$table->boolean('authorized')->default(false);
			$table->string('ip_address');
			$table->string('country');
			$table->string('city');
			$table->string('remember_token')->nullable();
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
		Schema::dropIfExists('users');
	}

}
