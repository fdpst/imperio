<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ModelsApp\AppHorarioTienda;
use App\ModelsApp\AppTienda;
use App\Http\Resources\AppHorarioResource;

class HorarioAppController extends Controller
{
  public function getHorarioByTienda($tienda_id){
    $horario = AppHorarioTienda::orderBy('dia', 'ASC')->where('app_tienda_id', $tienda_id)->get();

    $horario_resource = AppHorarioResource::collection($horario);

    return response()->json($horario_resource, 200);
  }

  public function saveHorarioByTienda($tienda_id, Request $request){
    $horario = AppHorarioTienda::updateOrCreate(['app_tienda_id' => $tienda_id, 'dia' => $request->dia], $request->merge(['app_tienda_id' => $tienda_id])->all());
    return response()->json(new AppHorarioResource($horario), 200);
  }
}
