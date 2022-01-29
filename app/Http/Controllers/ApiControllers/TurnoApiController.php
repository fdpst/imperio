<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Core\Contracts\Turno;
use App\Core\Contracts\HoraDia;
use Carbon\Carbon;

class TurnoApiController extends Controller
{
  public function getHorasDia(){
    return response()->json(HoraDia::all(), 200);
  }

  public function saveHoraDia(Request $request){
    $hora = HoraDia::updateOrCreate(['id' => $request->id], $request->all());
    return response()->json($hora, 200);
  }

  public function getTurnosByDay($fecha){
    $dia = HoraDia::where('dia', Carbon::parse($fecha)->dayOfWeek)->get()->first();

    $start_turno = Turno::where('start', $dia->start)->get()->first();
    $end_turno = Turno::where('start', $dia->end)->get()->first();

    $turnos = Turno::whereBetween('index', [$start_turno['index'], $end_turno['index']])->get();

    return response()->json($turnos, 200);
  }

  public function getTurnos(){
    return response()->json(Turno::all(), 200);
  }

  public function saveTurnos(Request $request){
    Turno::truncate();
    $turnos = $request->all();
    foreach($turnos as $turno){
      Turno::create([
        'index' => $turno['index'],
        'start' => $turno['start'],
        'end'   => $turno['end']
      ]);
    }
    return response()->json(Turno::all(), 200);
  }
}
