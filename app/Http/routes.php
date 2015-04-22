<?php

// Versiones de la API /api/v1.0/ruta
Route::group(array('prefix' => 'api/v1.0'), function() {
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
});

// Ruta inicial
Route::get('/', function() {
	return '<a href="/api/v1.0">Versión 1.0 de la API</a>';
});


