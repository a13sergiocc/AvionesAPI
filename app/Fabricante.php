<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Fabricante extends Model {

	// tabla mysql que usa el modelo
	protected $table = 'fabricantes';

	// Atributos de la tabla rellenables de forma masiva
	protected $fillable = array('nombre', 'direccion', 'telefono');

	// Ocultamos los campos de timestamps en las consultas
	protected $hidden = ['created_at', 'updated_at'];

	// Relación de fabricante con aviones
	public function aviones() {
		return $this->hasMany('App\Avion');
	}
}
