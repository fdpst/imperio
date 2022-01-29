<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Core\Contracts\Servicio;
use App\Core\Contracts\Tipo;

class ServicioApiController extends Controller
{
  public function getServicioByTipo($nombre){
    $saved_tipo = Tipo::where('nombre', $nombre)->get()->first();
    $servicios = Servicio::where('tipo_id', $saved_tipo->id)->get();
    return response()->json($servicios, 200);
  }

  public function getServicios(){
    return response()->json(Servicio::all(), 200);
  }

  public function saveServicio(Request $request){
    $servicio = Servicio::updateOrCreate(['id' => $request->id], $request->except(['tipo']));
    $servicio->tipo()->associate($request->tipo['id']);
    $servicio->save();
    return response()->json(['was_created' => $servicio->wasRecentlyCreated, 'servicio' => $servicio->load('tipo')], 200);
  }

  public function deleteServicio($servcio_id){
    return response()->json(Servicio::findOrFail($servcio_id)->delete(), 200);
  }
}
