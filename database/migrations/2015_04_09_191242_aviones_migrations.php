<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AvionesMigrations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('aviones', function(Blueprint $table)
		{
			$table->increments('serie');
			$table->string('modelo');
			$table->float('longitud');
			$table->integer('capacidad');
			$table->integer('velocidad');
			$table->integer('alcance');

			// Foreign key
			$table->integer('fabricante_id')->unsigned();
			$table->foreign('fabricante_id')->references('id')->on('fabricantes');

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
		Schema::drop('aviones');
	}

}
