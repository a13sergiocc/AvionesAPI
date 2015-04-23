<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder {
	
	public function run()
	{
		User::create(
			[
			'email'=> 'test@test.com',
			'password' => Hash::make('abc123.')
			]
			);
	}

}
