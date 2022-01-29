<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Resources\HorarioEmpleadoResource;
use App\Http\Resources\AppEmpleadosResource;
use App\Http\Resources\AppEmpleadoResource;
use App\Http\Controllers\Controller;
use App\Core\Contracts\HorarioAppEmpleado;
use App\Core\Contracts\FechaAppEmpleado;
use App\Core\Contracts\AppEmpleado;
use Illuminate\Http\Request;
use App\Core\Contracts\AppTienda;
use App\Core\Contracts\Tipo;
use Carbon\Carbon;

class EmpleadoAppController extends Controller
{
  public function getTipos(){
    return response()->json(Tipo::all(), 200);
  }

  public function getEmpleados(){
    $empleados = AppEmpleado::get();

    $empleados_resource = AppEmpleadosResource::collection($empleados);

    return response()->json($empleados_resource, 200);
  }

  public function getEmpleadosByDate($fecha, $tipo){
    $saved_tipo = Tipo::where('nombre', $tipo)->get()->first();

    $empleado = AppEmpleado::activo($fecha)->where('tipo_id', $saved_tipo->id)->get();

    return response()->json($empleado, 200);
  }

  public function getEmpleado($empleado_id){
    $empleado = AppEmpleado::with('fecha', 'vacaciones', 'horario', 'tienda')->where('id', $empleado_id)->get()->first();

    $tiendas = AppTienda::all();

    $empleado_resource = new AppEmpleadoResource($empleado);

    return response()->json([
      'empleado' => $empleado_resource,
      'tiendas'  => $tiendas
    ], 200);
  }

  public function saveEmpleado(Request $request){
    $empleado = AppEmpleado::updateOrCreate(['id' => $request->id], $request->merge(['is_active' => 1])->all());

    $empleado->tienda()->sync($request->tienda);

    if($request->tipo_libre == 'L'){
      $this->saveVacaciones($empleado, $request->lista_libres, 'L');
      return response()->json($empleado, 200);
    }

    if($request->tipo_libre == 'V'){
      $this->saveVacaciones($empleado, $request->lista_vacaciones, 'V');
      return response()->json($empleado, 200);
    }
  }

  private function saveVacaciones($empleado, $lista_dias_vacaciones, $tipo_libre){
    $empleado->vacaciones()->where('tipo', $tipo_libre)->delete();

    foreach($lista_dias_vacaciones as $fecha){
      $empleado->vacaciones()->create([
        'fecha' => $fecha,
        'tipo'  => $tipo_libre
      ]);
    }
  }

  public function deleteEmpleado($empleado_id){
    $empleado = AppEmpleado::findOrFail($empleado_id);
    $empleado->event()->delete();
    $empleado->horario()->delete();
    $empleado->vacaciones()->delete();
    $empleado->fecha()->delete();
    $empleado->tienda()->detach();
    $empleado->delete();
    return response()->json('empleado eliminado', 200);
  }

  public function deleteHorario($id){
    return response()->json(HorarioAppEmpleado::findOrFail($id)->delete(), 200);
  }

  public function savehorario($empleado_id, Request $request){
    $empleado = AppEmpleado::find($empleado_id);

    $horario = $empleado->horario()->updateOrCreate(['id' => $request->id], $request->except(['nombre_tienda']));

    return response()->json([
      'was_created' => $horario->wasRecentlyCreated,
      'horario' => new HorarioEmpleadoResource($horario)
    ], 200);
  }

  public function addHorario($empleado_id, Request $request){
    $empleado = AppEmpleado::find($empleado_id);

    $fechas = $request->fechas;

    foreach ($fechas as $key => $fecha) {
      $empleado->fecha()->create([
        'fecha'   => $fecha,
        'entrada' => $request->entrada,
        'salida' => $request->salida
      ]);
    }

    return response()->json($empleado->fecha, 200);
  }

  public function deleteFecha($id){
    return response()->json(FechaAppEmpleado::findOrFail($id)->delete(), 200);
  }
}
