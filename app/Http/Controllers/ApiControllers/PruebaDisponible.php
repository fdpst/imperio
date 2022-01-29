<?php

namespace App\Http\Controllers\ApiControllers;

use App\Core\Contracts\HorarioAppEmpleado;
use App\Http\Controllers\Controller;
use App\Core\Contracts\AppEmpleado;
use Illuminate\Http\Request;
use App\Core\Contracts\AppEvent;
use App\Core\Contracts\Tipo;
use Carbon\Carbon;

class PruebaDisponible extends Controller
{
  public function buscarDisponible(Request $request){
    $tipo = Tipo::where('nombre', $request->tipo)->get(['id'])->first();

    $week_day = Carbon::createFromDate($request->fecha)->dayOfWeek;

    $empleado_id = $request->empleado_id;

    $tienda_id = $request->tienda_id;

    $tipo_id = $tipo->id;

    $id = $request->id;

    $horarios = HorarioAppEmpleado::where('app_empleado_id', $empleado_id)
      ->where('app_tienda_id', $tienda_id)
      ->where('dia', $week_day)
      ->get();

    $lista_minutos_totales = $this->listaHorasTrabajadas($horarios, $request->fecha);

    $citas_empleado = AppEvent::where('id', '!=' , $id)
      ->where('app_empleado_id', $empleado_id)
      ->where('app_tienda_id', $tienda_id)
      ->where('tipo_id', $tipo_id)
      ->whereDate('start', $request->fecha)
      ->get();

    $lista_minutos_ocupados = $this->listaHorasOcupadas($citas_empleado);

    $collection = collect($lista_minutos_totales);

    $diff = $collection->diff($lista_minutos_ocupados);

    return response()->json([
      'diferencia'         => $diff->flatten(),
      'minutos_ocupados'   => $lista_minutos_ocupados,
      'minutos_trabajados' => $lista_minutos_totales,
      'horario'            => $horarios
    ], 200);
  }

  private function listaHorasOcupadas($citas){
    $lista_minutos_totales = [];

    foreach ($citas as $key => $cita) {
      $entrada = Carbon::parse($cita['start']);

      $salida = Carbon::parse($cita['end']);

      $diferencia_por_dia = $entrada->diffInMinutes($salida);

      $intervalos = ($diferencia_por_dia / 30) - 1;

      foreach (range(0, $intervalos) as $numero) {
        $i = $numero * 30;
        $hora_disponible = $entrada->copy()->addMinutes($i)->format('H:i');
        array_push($lista_minutos_totales, $hora_disponible);
      }
    }
    return $lista_minutos_totales;
  }

  private function listaHorasTrabajadas($horarios, $fecha){
    $lista_minutos_totales = [];

    foreach ($horarios as $key => $horario) {
      $entrada = Carbon::parse($fecha . " " . $horario['entrada']);

      $salida = Carbon::parse($fecha . " " . $horario['salida']);

      $diferencia_por_dia = $entrada->diffInMinutes($salida);

      $intervalos = ($diferencia_por_dia - 30) / 30;

      foreach (range(0, $intervalos) as $numero) {
        $i = $numero * 30;
        $hora_disponible = $entrada->copy()->addMinutes($i)->format('H:i');
        array_push($lista_minutos_totales, $hora_disponible);
      }
    }

    return $lista_minutos_totales;
  }

}
