<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

// Cargamos fabricante
use App\Avion;
use Response;

class AvionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$aviones = Cache::remember('cacheaviones', 15/60, function() {
			return Avion::all();
		});

		return response()->json(['status'=>'ok', 'data'=>$aviones], 200);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$avion = Avion::find($id);

		if(!$avion) 
		{
			return response()->json(['errors'=>['code'=>404, 'message'=>'No se encuentra un avión con ese código']], 404);
		}
		
		return response()->json(['status'=>'ok', 'data'=>$avion], 200);
	}


}
