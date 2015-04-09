<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Avion extends Model {

	// Nombre de la tabla
	protected $table='aviones';
 
	// Clave primaria
	protected $primaryKey = 'serie';
 
	// Atributos que se pueden asignar de manera masiva
	protected $fillable = array('modelo','longitud','capacidad','velocidad','alcance');
 
	// Campos ocultos
	protected $hidden = ['created_at','updated_at']; 

	// Relación de Avión con Fabricante
	public function fabricante() {
		return $this->belongsTo('App\Fabricante');
	}
}
