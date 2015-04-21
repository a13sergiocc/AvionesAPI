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
	public function update($idFabricante, $idAvion, Request $request)
	{
		$fabricante = Fabricante::find($idFabricante);

		if(!$fabricante) {
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un fabricante con ese código.'])],404);			
		}

		// Comprobamos si el avión es del fabricante
		$avion = $fabricante->aviones()->find($idAvion);

		if(!$avion) {
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un avión con ese código que pertenezca al fabricante.'])],404);			
		}

		// Listado de campos del formulario
		$modelo = $request->input('modelo');
		$longitud = $request->input('longitud');
		$capacidad = $request->input('capacidad');
		$velocidad = $request->input('velocidad');
		$alcance = $request->input('alcance');

		// Actualización parcial
		if($request->method()==='PATCH') {
			$bandera = false;

			if($modelo != null && $modelo !='') {
				$avion->modelo = $modelo;
				$bandera = true;
			}
			if($longitud != null && $longitud !='') {
				$avion->longitud = $longitud;
				$bandera = true;
			}
			if($capacidad != null && $capacidad !='') {
				$avion->capacidad = $capacidad;
				$bandera = true;
			}
			if($velocidad != null && $velocidad !='') {
				$avion->velocidad = $velocidad;
				$bandera = true;
			}
			if($alcance != null && $alcance !='') {
				$avion->alcance = $alcance;
				$bandera = true;
			}

			if($bandera) {
				$avion->save();
				return response()->json(['status'=>'ok' , 'data'=>$avion], 200);								
			}
			else {
				return response()->json(['errors'=>array(['code' => 304, 'message'=>'No se ha modificado ningún dato del avión'])], 304);
			}
		}

		// PUT (actualización total)
		if(!$modelo || !$longitud || !$capacidad || !$velocidad || !$alcance || !$capacidad) 
		{
			// 422 Unprocessable Entity
			return response()->json(['errors'=>array(['code' => 422, 'message'=>'Faltan valores para completar el procesamiento'])], 422);
		} 

		$avion->modelo = $modelo;
		$avion->longitud = $longitud;
		$avion->capacidad = $capacidad;
		$avion->velocidad = $velocidad;
		$avion->alcance = $alcance;

		$avion->save();

		return response()->json(['status'=>'ok' , 'data'=>$avion], 200);				
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($idFabricante)
	{
		// Compruebo si existe el fabricante.
		$fabricante=Fabricante::find($idFabricante);
		if (! $fabricante)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un fabricante con ese código.'])],404);
		}
		// Compruebo si existe el avion.
		$avion=$fabricante->aviones()->find($idAvion);
		if (! $avion)
		{
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un avión asociado a ese fabricante.'])],404);
		}
		// Borramos el avión.
		$avion->delete();
		// Devolvemos código 204 No Content.
		return response()->json(['code'=>204,'message'=>'Se ha eliminado el avión correctamente.'],204);
	}	}

}
