<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AgendaRequest;
use App\Core\Contracts\CitaStock;
use App\Core\Contracts\Empleado;
use App\Core\Contracts\Evento;
use App\Core\Contracts\CitaServicio;
use App\Core\Contracts\HoraDia;
use App\Core\Contracts\Turno;
use App\Core\Contracts\Ingresos;
use App\Core\Contracts\Cita;
use Illuminate\Http\Request;
use App\Core\Contracts\Tipo;
use Carbon\Carbon;

class EventoApiController extends Controller
{
  public function getEventos($fecha, $tipo){
    $saved_tipo = Tipo::where('nombre', $tipo)->get()->first();

    $eventos = Cita::with(['cita_stock', 'servicio', 'cita_stock.stock', 'cliente', 'empleado'])->where('tipo_id', $saved_tipo->id)->whereDate('fecha', $fecha)
              ->whereHas('empleado', function($empleado_query) use ($fecha){
                   $empleado_query->activo($fecha);
              })->get();

    return response()->json($eventos, 200);
  }

  public function getEmpleado($lista_turnos, $fecha, $tipo_id){

    $empleados = Empleado::with(['cita' => function($cita_query) use ($fecha){
              $cita_query->with('evento')->whereDate('fecha', $fecha)->get();
    }])->where('tipo_id', $tipo_id)->activo($fecha)->get();

    $items = collect($empleados)->map(function ($item, $key) {
      return ['empleado' => $item, 'eventos' => $item->cita->flatMap(function($cita, $key){
          return $cita->evento;
      })];
    });

    foreach($items as $item){

      $collection = collect($item['eventos']);

      $implode = $collection->implode('turno_id', ', ');

      $lista_eventos_activos = explode(', ', $implode);

      if (empty(array_intersect($lista_eventos_activos, $lista_turnos))){
         return $item['empleado'];
      }

    }
    return false;

  }

  private function getTurnos($hora, $duracion, $lista_turnos_del_dia){
    $turno_primero = Turno::where('start', $hora)->get(['index'])->first(); //1

    $last = $lista_turnos_del_dia['last'];

    $cantidad_turnos = $duracion / 5;

    $ultimo_turno = ($turno_primero['index'] + $cantidad_turnos) - 1;

    return ['lista_turnos' => range($turno_primero['index'], $last), 'excede_horas' => $ultimo_turno > $last];
  }

  private function getTurnoByHour($hora, $duracion){
    $turno = Turno::where('start', $hora)->get()->first();
    $turnos = $duracion / 5;
    $end_turnos = ($turno->index + $turnos) - 1;
    return $lista_turnos = range($turno->index, $end_turnos);
  }

  public function getTurnosByDay($fecha){
    $dia = HoraDia::where('dia', Carbon::parse($fecha)->dayOfWeek)->get()->first();
    $start_turno = Turno::where('start', $dia->start)->get()->first();
    $end_turno = Turno::where('start', $dia->end)->get()->first();
    $turnos = Turno::whereBetween('index', [$start_turno['index'], $end_turno['index']])->get();
    return ['turnos' => $turnos, 'count' => $turnos->count(), 'first' => $start_turno['index'], 'last' => $end_turno['index']];
  }

  private function getTotalDuration($servicios){
    return collect($servicios)->reduce(function ($carry, $item) {
        return $carry + $item['duracion'];
    }, 0);
  }

  private function getTurnosByHour($hora_inicial, $duracion_total){
    $turno_inicial = Turno::where('start', $hora_inicial)->get()->first();

    $turno_final = ($turno_inicial['index'] + $duracion_total / 5) - 1;

    $lista_turnos = range($turno_inicial['index'], $turno_final);

    return $lista_turnos;
  }

  public function saveEvento(AgendaRequest $request){

    $duracion_total = $request->tiempo_real;

    $fecha = $request->fecha;

    $saved_tipo = Tipo::where('nombre', $request->tipo)->get()->first();

    $lista_turnos_del_dia = $this->getTurnosByDay($request->fecha);

    /*esto solo es para validar que los turnos seleccionados no lleguen al final*/
    $lista_turnos = $this->getTurnos($request->hora, $duracion_total, $lista_turnos_del_dia);

    if($lista_turnos['excede_horas']){
      return response()->json('hora no disponible', 301);
    }

    $lista_turnos_que_ocupara = $this->getTurnoByHour($request->hora, $duracion_total);

    $empleado = $this->getEmpleado($lista_turnos_que_ocupara, $fecha, $saved_tipo->id);

    if ($empleado == false){
       return response()->json('no hay empleado disponible', 301);
    }

    $lista_turnos = $this->getTurnosByHour($request->hora, $duracion_total);

    $cita = Cita::create([
      'tipo_id'        => $saved_tipo->id,
      'empleado_id'    => $empleado->id,
      'cliente_id'     => $request->cliente['id'],
      'fecha'          => $fecha,
    ]);

    foreach ($request->servicios as $key => $servicio) {
      CitaServicio::create([
        'cita_id' =>  $cita['id'],
        'servicio_id'  => $servicio['id']
      ]);
    }

    foreach ($lista_turnos as $turno) {
      Evento::create([
        'cita_id' =>  $cita['id'],
        'turno_id'  => $turno
      ]);
    }

    return response()->json($cita->load('evento', 'servicio', 'cliente', 'empleado'), 200);

  }

  public function deleteCita($cita_id){
    $cita = Cita::find($cita_id);
    $cita->delete();
    return response()->json('agenda y eventos eliminados', 200);
  }

  public function finalizarCita(Request $request){
    $boolean_cita = $this->updateAgendaPrice($request->cita);

    $ingreso = $this->saveIngreso($request->cita);

    $items = $this->addAgendaStock($request->items, $request->cita['id']);

    return response()->json($ingreso, 200);
  }

  private function addAgendaStock($items, $cita_id){
    CitaStock::where('cita_id', $cita_id)->delete();
    foreach($items as $item){
      CitaStock::create([
        'cita_id' => $item['cita_id'],
        'stock_id'  => $item['stock_id'],
        'cantidad'  => $item['cantidad']
      ]);
    }
    return true;
  }

  private function updateAgendaPrice($cita){
    return Cita::where('id', $cita['id'])->update(['precio' => $cita['precio'], 'pagado' => $cita['pagado']]);
  }

  private function saveIngreso($cita){
    $concepto = $this->getConcepto($cita['lista_nombre_servicios'], $cita['cliente']);
    return Ingresos::updateOrCreate(['cita_id' => $cita['id']], ['concepto' => $concepto, 'codigo' => uniqid(), 'total' => $cita['pagado']]);
  }

  private function getConcepto($lista_nombre_servicios, $cliente){
    $nombres_string = implode(", ", $lista_nombre_servicios);
    return $cliente['nombre'] . " - " . $nombres_string;
  }
}
