<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Core\Contracts\Empleado;
use Illuminate\Http\Request;
use App\Core\Contracts\Cita;
use App\Core\Contracts\Tipo;
use Carbon\Carbon;

class EmpleadoApiController extends Controller
{
  public function getEmpleados(){
    return response()->json(Empleado::with('vacaciones')->get(), 200);
  }

  public function getEmpleado($empleado_id){
    return response()->json(Empleado::with('vacaciones')->where('id', $empleado_id)->get()->first(), 200);
  }

  public function saveEmpleado(Request $request){
    $empleado = Empleado::updateOrCreate(['id' => $request->id], $request->all());
    $this->saveVacaciones($empleado, $request->lista_vacaciones);
    return response()->json($empleado, 200);
  }

  private function saveVacaciones($empleado, $lista_dias_vacaciones){
    $empleado->vacaciones()->delete();
    foreach($lista_dias_vacaciones as $fecha){
      $empleado->vacaciones()->create([
        'fecha' => $fecha
      ]);
    }
  }

  public function deleteEmpleado($empleado_id){
    return response()->json(Empleado::findOrFail($empleado_id)->delete(), 200);
  }

}
