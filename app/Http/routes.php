<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
*/

// Ruta inicial
Route::get('/', function() {
	return 'Bienvenido API RESTful de aviones.';
});

// Creamos rutas nuevas para los controllers
Route::resource('fabricantes', 'FabricanteController', ['except' => ['create', 'edit']]);

// Recurso anidado fabricantes aviones
Route::resource('fabricantes.aviones', 'FabricanteAvionController', ['except' => ['create', 'edit', 'show']]);

// Ruta aviones
Route::resource('aviones', 'AvionController', ['only' => ['index', 'show']]);