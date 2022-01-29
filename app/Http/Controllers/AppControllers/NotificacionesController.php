<?php

namespace App\Http\Controllers\AppControllers;

use App\Http\Resources\AppCompactEventResource;
use App\Http\Resources\AppCompactEventAppResource;
use App\Http\Resources\AppCompactUsuarioEventAppResource;
use App\Http\Controllers\Controller;
use App\ModelsApp\AppEvent;
use App\ModelsApp\AppEmpleado;
use App\ModelsApp\AppTienda;
use Carbon\Carbon;

class NotificacionesController extends Controller
{
  public function getNotificaciones(){
    $sin_confirmar = AppEvent::with('usuario')->where('confirmada', 0)->get();
    return response()->json([
      'sin_confirmar' => AppCompactEventResource::collection($sin_confirmar)
    ], 200);
  }

  public function getcitas(){
    $cita = AppEvent::with('usuario')->where('confirmada', 1)->orwhere('confirmada', 0)->get();
    return response()->json([
      'cita' => AppCompactEventResource::collection($cita)
    ], 200);
  }

  public function getcitasByMascota($id_mascota){
    
    $cita = AppEvent::with('usuario')->where('app_mascota_id', $id_mascota)->where('start', '>=',  Carbon::now()->add(-30, 'day'))->get();
    return response()->json([
      'cita' => AppCompactEventResource::collection($cita)
    ], 200);
  }


  public function getCitasByUser($usuario_id){
    
    $citas = AppEvent::with('usuario')->where('app_usuario_id', $usuario_id)->whereDate('start', '>=', Carbon::now())->get();
    
    foreach ($citas as $cita) {
      $empleado = AppEmpleado::where('id', $cita['app_empleado_id'])->get()->first();
      $tienda = AppTienda::where('id', $cita['app_tienda_id'])->get()->first();
      $cita['nombre_empleado'] = $empleado->nombre;
      $cita['nombre_tienda'] = $tienda->nombre;
    }
    return response()->json([
      'cita' => AppCompactEventAppResource::collection($citas)
    ], 200);
  }

  public function getCitasByUserApp($usuario_id){
    
    $citas = AppEvent::with('usuario')->where('app_usuario_id', $usuario_id)->whereDate('start', '>=', Carbon::now())->get();
    
    foreach ($citas as $cita) {
      $empleado = AppEmpleado::where('id', $cita['app_empleado_id'])->get()->first();
      $tienda = AppTienda::where('id', $cita['app_tienda_id'])->get()->first();
      $cita['nombre_empleado'] = $empleado->nombre;
      $cita['nombre_tienda'] = $tienda->nombre;
    }
    if(sizeof($citas)>0){
      return response()->json([
        'cita' => AppCompactUsuarioEventAppResource::collection($citas)
      ], 200);
    }else{
      return response()->json("No hay ninguna cita activa", 200);
    }
    
  }
}
