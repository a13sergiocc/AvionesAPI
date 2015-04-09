<?php

use Illuminate\Database\Seeder;
use App\Fabricante;
use Faker\Factory as Faker;

class FabricanteSeeder extends Seeder {
	public function run()
	{
		// Creamos una instancia de Faker
		$faker=Faker::create();

		// Cubrimos 5 fabricantes
		for ($i=0; $i < 5; $i++) { 
			Fabricante::create([
				'nombre'=>$faker->word(),
				'direccion'=>$faker->word(),
				'telefono'=>$faker->randomNumber()
			]);
		}
	}
}
