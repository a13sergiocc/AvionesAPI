<?php

use Illuminate\Database\Seeder;
use App\Avion;
use App\Fabricante;
use Faker\Factory as Faker;

class AvionSeeder extends Seeder {
	public function run()
	{
		// Creamos una instancia de Faker
		$faker=Faker::create();

		// Número de fabricantes 
		$cuantos=Fabricante::all()->count();

		// Cubrimos 5 fabricantes
		for ($i=0; $i < 20; $i++) { 
			Avion::create([
				'modelo'=>$faker->word(),
				'longitud'=>$faker->randomFloat(),
				'capacidad'=>$faker->randomNumber(),
				'velocidad'=>$faker->randomNumber(),
				'alcance'=>$faker->randomNumber(),
				'fabricante_id'=>$faker->numberBetween(1, $cuantos)
			]);
		}
	}

}
