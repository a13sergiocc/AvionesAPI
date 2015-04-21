<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// Cargamos fabricante
use App\Fabricante;
use Response;

use Illuminate\Http\Request;

class FabricanteController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Devolvemos JSON con todos los fabricantes
		return response()->json(['status'=>'ok', 'data'=>Fabricante::all()], 200);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	/*
	public function create()
	{
		//
	}
	*/
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		// Llamado al hacer un post
		// Comprobamos que recibimos todos los campos
		if (!$request->input('nombre') || !$request->input('direccion') || !$request->input('telefono')) {
			return response()->json(['errors'=>array(['code'=>422, 'message' => 'Faltan datos necesarios para procesar el alta'])], 422);
		}

		// Insertamos datos en la tabla
		$nuevoFabricante = Fabricante::create($request->all());

		// Devolvemos response 201 (creado) + los datos del nuevo fabricante + una cabecera de Location
		$respuesta = Response::make(json_encode(['data'=>$nuevoFabricante,]), 201)->header('Location', 'http://www.dominio.local/fabricantes/'.$nuevoFabricante->id)->header('Content-Type', 'application/json');

		return $respuesta;
	}	

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$fabricante = Fabricante::find($id);

		if(!$fabricante)
			return response()->json(['errors'=>Array(['code'=>404, 'message' => 'no se encuentra fabricante con ese código'])], 404);			

		return response()->json(['status'=>'ok', 'data'=>$fabricante], 200);

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		// Comprobación si existe fabricante
		$fabricante = Fabricante::find($id);

		if(!$fabricante) 
		{
			// Deolvemos error
			return response()->json(['errors'=>array(['code' => 404, 'message'=>'No se encuentra un fabricante con ese código'])], 404);
		}

		$nombre = $request->input('nombre');
		$direccion = $request->input('direccion');
		$telefono = $request->input('telefono');

		// Comprobación si recibimos petición path (parcial) o put (total)
		if($request->method() == 'PATCH')
		{
			$bandera = false;
			
			// Actualización parcial de datos
			if($nombre!=null && $nombre!='') 
			{
				$fabricante->nombre = $nombre;
				$bandera = true;
			}
			
			if($direccion!=null && $direccion!='') 
			{
				$fabricante->direccion = $direccion;
				$direccion = true;
			}
			
			if($telefono!=null && $telefono!='') 
			{
				$fabricante->telefono = $telefono;
				$bandera = true;
			}

			if($bandera) 
			{
				$fabricante->save();
				return response()->json(['status'=>'ok' , 'data'=>$fabricante], 200);				
			}
			else
			{
				return response()->json(['errors'=>array(['code' => 304, 'message'=>'No se ha modificado ningún dato del fabricante'])], 304);
			}
		}

		// Método put, actualizamos todos los campos

		if(!$nombre || !$direccion || !$telefono) 
		{
			// 422 Unprocessable Entity
			return response()->json(['errors'=>array(['code' => 422, 'message'=>'Faltan valores para completar el procesamiento'])], 422);
		} 

		// Actualzación de los 3 campos
		$fabricante->nombre = $nombre;
		$fabricante->direccion = $direccion;
		$fabricante->telefono = $telefono;

		$fabricante->save();

		return response()->json(['status'=>'ok' , 'data'=>$fabricante], 200);				
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// Comprobamos si el fabricante existe	
		$fabricante = Fabricante::find($id);

		if(!$fabricante) {
			return response()->json(['errors'=>Array(['code'=>404, 'message' => 'no se encuentra fabricante con ese código'])], 404);			
		}

		// Comprobamos si tiene aviones. Si es así, sacamos un mensaje de error
		$aviones = $fabricante->aviones;

		if(sizeof($aviones)>0) {
			// Para borrar todos los aviones del fabricante
			// $fabricante->aviones->delete();
			
			// Código 409 Conflict
			return response()->json(['errors'=>Array(['code'=>409, 'message' => 'este fabricante tiene aviones y no puede ser borrado'])], 409);			
		}

		$fabricante->delete();
		// Deolvemos código 204 "No content"
		return response()->json(['code'=> 204, 'message' => 'se ha borrado el fabricante'], 204);			
	}

}
