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
	public function destroy($id)
	{
		// Comprobamos si el fabricante existe	
		$fabricante = Fabricante::find($id);

		if(!$fabricante) {
			return response()->json(['errors'=>Array(['code'=>404, 'message' => 'no se encuentra fabricante con ese código'])], 404);			
		}

		$fabricante->delete();
		// Deolvemos código 204 "No content"
		return response()->json(['code'=> 204, 'message' => 'se ha borrado el fabricante'], 204);			
	}

}
