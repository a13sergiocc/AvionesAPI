<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


// Cargamos fabricante
use App\Fabricante;
use App\Avion;
use Response;

class FabricanteAvionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($idFabricante)
	{
		// Todos los aviones de un fabricante
		$fabricante = Fabricante::find($idFabricante);

		if(!$fabricante)
		{
			return response()->json(['errors'=>['code'=>404, 'message'=>'No se encuentra un fabricante con ese código']], 404);
		}

		return response()->json(['status'=>'ok', 'data'=>$fabricante->aviones()->get()], 200);
		/*
		Alternativa: 
		return response()->json(['status'=>'ok', 'data'=>$fabricante->aviones], 200);		
		*/
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($id, Request $request)
	{
		$modelo = $request->input('modelo');
		$longitud = $request->input('longitud');
		$capacidad = $request->input('capacidad');
		$velocidad = $request->input('velocidad');
		$alcance = $request->input('alcance');

		if(!$modelo || !$longitud || !$capacidad || !$velocidad || !$alcance)
		{
			return response()->json(['errors'=>array(['code'=>422, 'message' => 'Faltan datos necesarios para procesar el alta'])], 422);
		}

		$fabricante = Fabricante::find($id);

		if(!$fabricante) {
			return response()->json(['errors'=>Array(['code'=>404, 'message' => 'no se encuentra fabricante con ese código'])], 404);			
		}

		// Damos de alta el avión de ese fabricante
		$nuevoAvion = $fabricante->aviones()->create($request->all());

		$respuesta = Response::make(json_encode(['data'=>$nuevoAvion,]), 201)->header('Location', 'http://www.dominio.local/aviones/'.$nuevoAvion->serie)->header('Content-Type', 'application/json');

		return $respuesta;
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($idFabricante)
	{
		//
		$fabricante = Fabricante::find($idFabricante);

		$avion = $fabricante->aviones()->find($idAvion);
	}

}
