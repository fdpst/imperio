<?php

namespace App\Http\Controllers\AppControllers;

use App\Http\Resources\HorarioEmpleadoResource;
use App\Http\Resources\AppEmpleadosResource;
use App\Http\Resources\AppEmpleadoResource;
use App\Http\Controllers\Controller;
use App\ModelsApp\HorarioAppEmpleado;
use App\ModelsApp\FechaAppEmpleado;
use App\ModelsApp\AppEmpleado;
use Illuminate\Http\Request;
use App\ModelsApp\AppTienda;
use App\ModelsApp\Tipo;
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

    $fecha = FechaAppEmpleado::where('app_empleado_id', $empleado_id)->whereDate('fecha', '>=', Carbon::now())->get();
    $empleado = AppEmpleado::with('vacaciones', 'horario', 'tienda')->where('id', $empleado_id)->get()->first();
   
    $empleado["fecha"] = $fecha;
    
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

    $horario = $empleado->horario()->updateOrCreate(['id' => $request->id], $request->except(['nombre_tienda', 'entrada2', 'salida2']));

    //Si metemos dos horarios seguidos lo añadimos de forma indivdual
    if ($request->entrada2!="00:00" && $request->salida2!="00:00"){
      $request2  = $request;
      $request2->merge([
        'entrada' => $request->entrada2,
        'salida' => $request->salida2
      ]);
     
      
      $horario2 = $empleado->horario()->updateOrCreate(['id' => ""], $request2->except(['nombre_tienda', 'entrada2', 'salida2']));
      return response()->json([
        'was_created' => $horario->wasRecentlyCreated,
        'was_created2' => $horario2->wasRecentlyCreated,
        'horario' => new HorarioEmpleadoResource($horario),
        'horario2' => new HorarioEmpleadoResource($horario2),
        'request original' => $request2->all()
      ], 200);

    }else{
      return response()->json([
        'was_created' => $horario->wasRecentlyCreated,
        'horario' => new HorarioEmpleadoResource($horario)
      ], 200);
    }    
  }


  public function addHorario($empleado_id, Request $request){
    $empleado = AppEmpleado::find($empleado_id);
    $fechas = $request->fechas;
      foreach ($fechas as $key => $fecha) {         
        $fechaAlmacenar = date("Y-m-d 8:i:s",strtotime($fecha));

        $empleado->fecha()->updateOrCreate(['id' => $request->id],
        [
          'app_tienda_id' => $request->app_tienda_id,
          'fecha'   => $fechaAlmacenar,
          // 'fecha'   => $fecha,
          'entrada' => $request->entrada,
          'salida' => $request->salida
        ]);

      //Si metemos dos horarios seguidos lo añadimos de forma indivdual
      if ($request->entrada2!="00:00" && $request->salida2!="00:00"){          
        $empleado->fecha()->updateOrCreate(
        [
          'id' => $request->id,
          'app_tienda_id' => $request->app_tienda_id,
          'fecha'   => $fechaAlmacenar,
          // 'fecha'   => $fecha,
          'entrada' => $request->entrada2,
          'salida' => $request->salida2
        ]);
      }

    }
    $empleado_fechas = $empleado->fecha;
    return response()->json($empleado_fechas, 200);
  }

  public function deleteFecha($id){
    return response()->json(FechaAppEmpleado::findOrFail($id)->delete(), 200);
  }
}
