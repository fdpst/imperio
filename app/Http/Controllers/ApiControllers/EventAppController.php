<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Resources\AppEventoResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\AgendaRequest;
use App\Core\Contracts\AppHorarioTienda;
use App\Core\Contracts\AppEmpleado;
use App\Core\Contracts\AppServicio;
use App\Core\Contracts\AppUsuario;
use App\Core\Contracts\Cliente;
use App\Core\Contracts\AppTienda;
use Illuminate\Http\Request;
use App\Core\Contracts\AppEvent;
use App\Core\Contracts\Tipo;
use Carbon\Carbon;

class EventAppController extends Controller
{
  public function confirmarCita($evento_id){
    $evento = AppEvent::find($evento_id);
    $evento->confirmada = !$evento->confirmada;
    $evento->save();
    return response()->json(new AppEventoResource($evento), 200);
  }

  public function getEvents($fecha){
    $events = AppEvent::whereHas('empleado')->whereHas('usuario')
      ->whereBetween('start', [Carbon::parse($fecha)->startOfWeek(), Carbon::parse($fecha)->endOfWeek()])
      ->with('servicio')
      ->get();
    return response()->json(AppEventoResource::collection($events), 200);
  }

  public function getData($nombre_tipo, $tienda_id){
    $tipo = Tipo::where('nombre', $nombre_tipo)->get(['id'])->first();

    $empleados = AppEmpleado::with(['fecha', 'horario' => function($query) use ($tienda_id){
        $query->where('app_tienda_id', $tienda_id)->orderBy('entrada', 'ASC');
    }])->where('tipo_id', $tipo->id)->whereHas('tienda', function($q) use ($tienda_id){
        $q->where('app_tienda_id', $tienda_id);
    })->get();

    $clientes = Cliente::get(['id', 'nombre']);

    $servicios = AppServicio::get(['id','nombre', 'duracion']);

    return response()->json([
      'clientes'  => $clientes,
      'empleados' => $empleados,
      'servicios' => $servicios,
    ], 200);
  }

  public function saveCita(AgendaRequest $request){
    /*$recent_event = AppEvent::where('app_mascota_id', $request->app_mascota_id)
      ->whereDate('start', '>=', Carbon::parse($request->fecha))
      ->get()->first();

    if($recent_event){
      return response()->json(['message' => 'Mascota tiene cita activa'], 301);
    }*/

    if($request->id){
      $existing_event = AppEvent::find($request->id);
      $existing_event->delete();
    }

    $empleado = $this->getEmpleado($request->app_empleado_id);

    $out_of_time = $this->isOutOfTime($request->app_tienda_id, $request->fecha, $request->start, $request->end);

    if(!$out_of_time){

      if(isset($existing_event)){
         $existing_event->restore();
      }

      return response()->json(['message' => 'fuera de horario'], 301);
    }

    $events = $empleado->event;

    $fit = $this->fitInTime($events, $request->start, $request->end);

    if(!$fit){

      if(isset($existing_event)){
         $existing_event->restore();
      }

      return response()->json(['message' => 'hora no disponible en fit'], 301);
    }

    if(isset($existing_event)){
       //$existing_event->servicio()->detach();
    }

    $event = new AppEvent();

    $event->fill([
      'app_empleado_id' => $empleado['id'],
      'app_usuario_id'  => $request->app_usuario_id,
      //'app_mascota_id'  => $request->app_mascota_id,
      'app_tienda_id'   => $request->app_tienda_id,
      'start'           => $request->start,
      'end'             => $request->end,
      'duracion'        => $request->duracion,
      'confirmada'      => 1
    ]);

    $tipo = Tipo::where('nombre', $request->tipo)->get(['id'])->first();

    $saved_event = $tipo->event()->save($event);

    $servicios = $this->returnIds($request->servicios);

    $saved_event->servicio()->sync($servicios);

    return response()->json(new AppEventoResource($saved_event), 200);
  
  }

  private function restoreEvent($existing_event){
    if(isset($existing_event)){
      return $existing_event->restore();
    }
  }

  private function fitInTime($events, $inicio_evento, $final_evento){
    if(count($events) == 0){
      return true;
    }

    foreach($events as $key => $evento) {

      $is_between = Carbon::parse($inicio_evento)->betweenExcluded($evento['start'], $evento['end']);

      $is_between_end = Carbon::parse($final_evento)->betweenExcluded($evento['start'], $evento['end']);

      $is_envolving = Carbon::parse($inicio_evento)->lessThanOrEqualTo(Carbon::parse($evento['start'])) && Carbon::parse($final_evento)->greaterThanOrEqualTo(Carbon::parse($evento['end']));

      if($is_between){
        return false;
      }

      if($is_between_end){
        return false;
      }

      if($is_envolving){
        return false;
      }
    }
    return true;
  }

  private function getEmpleado($empleado_id){
    return AppEmpleado::with('event')->where('id', $empleado_id)->get()->first();
  }

  private function isOutOfTime($app_tienda_id, $fecha, $start, $end){
    $numero_dia = AppHorarioTienda::where('app_tienda_id', $app_tienda_id)->where('dia', Carbon::parse($start)->dayOfWeek)->get()->first();

    $hora_inicio = Carbon::parse($fecha . " " . $numero_dia['start'])->format('Y-m-d H:i');

    $hora_final = Carbon::parse($fecha . " " . $numero_dia['end'])->format('Y-m-d H:i');

    if(Carbon::parse($start)->lessThan($hora_inicio) || Carbon::parse($end)->greaterThan($hora_final)){
      return false;
    }
    return true;
  }

  private function returnIds($servicios){
    return collect($servicios)->map(function($element){
      return $element['id'];
    });
  }

  public function eliminarCita($evento_id){
    $event = AppEvent::find($evento_id);

    $event->servicio()->detach();

    $event->delete();

    return response()->json('cita eliminada', 200);
  }

}
