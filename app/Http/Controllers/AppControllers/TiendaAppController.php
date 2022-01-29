<?php

namespace App\Http\Controllers\AppControllers;

use App\Http\Controllers\Controller;
use App\ModelsApp\AppTienda;
use Illuminate\Http\Request;

class TiendaAppController extends Controller
{
  public function getTiendas(){
    return response()->json(AppTienda::all(), 200);
  }

  public function getTiendasCita(){
    $tiendas = AppTienda::with('horario')->get();
    $data = array();
    foreach($tiendas as $tienda)
    {
        if($tienda->horario != '[]')
        {
          array_push($data, $tienda);
        }
      
    }
    return response()->json($data, 200);
  }

  public function saveTienda(Request $request){
    $tienda = AppTienda::updateOrCreate(['id' => $request->id], $request->all());
    return response()->json(['was_created' => $tienda->wasRecentlyCreated, 'tienda' => $tienda], 200);
  }

  public function deleteTienda($tienda_id){
    return response()->json(AppTienda::findOrFail($tienda_id)->delete(), 200);
  }
}
