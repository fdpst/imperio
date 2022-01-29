<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Core\Contracts\AppTienda;
use Illuminate\Http\Request;

class TiendaAppController extends Controller
{
  public function getTiendas(){
    return response()->json(AppTienda::all(), 200);
  }

  public function saveTienda(Request $request){
    $tienda = AppTienda::updateOrCreate(['id' => $request->id], $request->all());
    return response()->json(['was_created' => $tienda->wasRecentlyCreated, 'tienda' => $tienda], 200);
  }

  public function deleteTienda($tienda_id){
    return response()->json(AppTienda::findOrFail($tienda_id)->delete(), 200);
  }
}
