<?php

namespace App\Http\Controllers\AppControllers;

use App\Http\Controllers\Controller;
use App\ModelsApp\AppUsuarioDirecciones;
use Illuminate\Http\Request;

class DireccionUsuarioController extends Controller
{
  
  public function getDireccionByUser($usuario_id){
    $direcciones = AppUsuarioDirecciones::where('app_usuario_id', $usuario_id)->get();
    return response()->json($direcciones, 200);
  }

  public function saveDireccionFromUser(Request $request){
    $direcion = AppUsuarioDirecciones::updateOrCreate(['id' => $request->id], $request->all());
    $direcciones = AppUsuarioDirecciones::where('app_usuario_id', $request->app_usuario_id)->get();
    return response()->json($direcciones, 200);
  }

  public function deleteDireccion($id){
    $direccion = AppUsuarioDirecciones::find($id)->delete();
    return response()->json($direccion, 200);
  }
}
