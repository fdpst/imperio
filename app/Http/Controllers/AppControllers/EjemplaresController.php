<?php

namespace App\Http\Controllers\AppControllers;

use App\Http\Resources\AppEjemplarResource;
use App\Http\Controllers\Controller;
use App\ModelsApp\AppEjemplar;
use App\Http\Requests\EjemplarRequest;
use App\ModelsApp\AppTienda;
use Illuminate\Http\Request;
use Carbon\Carbon;
// use Validator;

class EjemplaresController extends Controller
{
  public function getAllEjemplaresApp(){
    $ejemplares = AppEjemplar::where('activo', 1)->get();
    return response()->json(AppEjemplarResource::collection($ejemplares), 200);
  }

  public function indexEjemplaresApp(){
    $ejemplares = AppEjemplar::orderBy('id', 'desc')->get();
    return response()->json(AppEjemplarResource::collection($ejemplares), 200);
  }

  public function showEjemplaresApp($ejemplar_id){
    $ejemplar = AppEjemplar::where('id', $ejemplar_id)
                ->select('id','titulo','fecha','descripcion','imagen','tienda_id', 'activo')
                ->first();

    return response()->json($ejemplar, 200);
  }

  public function saveEjemplar(EjemplarRequest $request){

    $validated = $request->validated();

    $ejemplar = AppEjemplar::create($request->all());

    return response()->json($ejemplar, 200);
  }

  public function updateEjemplar($ejemplar_id, EjemplarRequest $request){

    $validated = $request->validated();

    $ejemplar = AppEjemplar::findOrFail($ejemplar_id);
    $ejemplar->tienda_id = $request->tienda_id;
    $ejemplar->imagen = $request->imagen;
    $ejemplar->titulo = $request->titulo;
    $ejemplar->fecha = $request->fecha;
    $ejemplar->descripcion = $request->descripcion;
    $ejemplar->activo = $request->activo;
    $ejemplar->save();

    $ejemplar_data = AppEjemplar::where('id',$ejemplar_id)->get();

    return response()->json(AppEjemplarResource::collection($ejemplar_data), 200);
  }

  public function deleteEjemplar($id){
    return response()->json(AppEjemplar::find($id)->delete(), 200);
  }


}
