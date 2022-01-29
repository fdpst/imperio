<?php

namespace App\Http\Controllers\AppControllers;

use App\ModelsApp\HorarioAppEmpleado;
use App\Http\Controllers\Controller;
use App\ModelsApp\AppEmpleado;
use App\ModelsApp\AppEmpleadoVacaciones;
use App\ModelsApp\FechaAppEmpleado;
use Illuminate\Http\Request;
use App\ModelsApp\AppTienda;
use App\ModelsApp\AppEvent;
use App\ModelsApp\Tipo;
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
    return $this->getEmpleados($id, $tipo_id, $week_day, $tienda_id, $request->fecha, $empleado_id);
    // $horarios = HorarioAppEmpleado::where('app_empleado_id', $empleado_id)
    //   ->where('app_tienda_id', $tienda_id)
    //   ->where('dia', $week_day)
    //   ->get();
    // $lista_minutos_totales = $this->listaHorasTrabajadas($horarios, $request->fecha);
    // $citas_empleado = AppEvent::where('id', '!=' , $id)
    //   ->where('app_empleado_id', $empleado_id)
    //   ->where('app_tienda_id', $tienda_id)
    //   ->where('tipo_id', $tipo_id)
    //   ->whereDate('start', $request->fecha)
    //   ->get();
    // $lista_minutos_ocupados = $this->listaHorasOcupadas($citas_empleado);
    // $collection = collect($lista_minutos_totales);
    // $diff = $collection->diff($lista_minutos_ocupados);
    // return response()->json([
    //   'diferencia'         => $diff->flatten(),
    //   'minutos_ocupados'   => $lista_minutos_ocupados,
    //   'minutos_trabajados' => $lista_minutos_totales,
    //   'horario'            => $horarios
    // ], 200);
  }

  private function getEmpleados($id, $tipo_id, $week_day, $tienda_id, $start, $empleado_id){
    if(!$empleado_id){

      $tienda = AppTienda::where('id', $tienda_id)->with(['empleado' => function($q) use ($tipo_id){
        $q->where('tipo_id', $tipo_id);
      }])->get()->first();

    }else{
      $tienda = AppTienda::find($tienda_id);
      $tienda->empleado = AppEmpleado::where('tipo_id', $tipo_id)->where('id', $empleado_id)->get();
    }

    $horarios = $this->difereciaPorEmpleado($tienda->empleado, $week_day, $start, $id, $tipo_id, $tienda_id);
    return $horarios;
  }

  private function difereciaPorEmpleado($empleados, $week_day, $start, $id, $tipo_id, $tienda_id){
    return $collection = collect($empleados)->map(function ($empleado) use ($week_day, $start, $id, $tipo_id, $tienda_id) {
  
      $vacaciones = false;
      if (AppEmpleadoVacaciones::where('app_empleado_id', $empleado->id)->whereDate('fecha', $start)->exists())
      {        
        $horariosv = AppEmpleadoVacaciones::where('app_empleado_id', $empleado->id)
        ->whereDate('fecha', $start)
        ->get();
        $horarios = $horariosv;
        $vacaciones = true;
        
      }
      elseif (FechaAppEmpleado::where('app_empleado_id', $empleado->id)->whereDate('fecha', $start)->exists())
      {
        $horariose = FechaAppEmpleado::where('app_empleado_id', $empleado->id)
        ->whereDate('fecha', $start)
        ->where('app_tienda_id', $tienda_id)
        ->get();
        $horarios = $horariose;
        
      }
      else 
      {
        $horariosh = HorarioAppEmpleado::where('app_empleado_id', $empleado->id)
        ->where('dia', $week_day)
        ->where('app_tienda_id', $tienda_id)
        ->get();
        $horarios = $horariosh;
        
      }
      
      $lista_minutos_totales = $this->listaHorasTrabajadas($horarios, $start);

      $citas_empleado = AppEvent::where('id', '!=' , $id)
          ->where('tipo_id', $tipo_id)
          ->where('app_empleado_id', $empleado->id)
          ->whereDate('start', $start)->get();

      $lista_minutos_ocupados = $this->listaHorasOcupadas($citas_empleado);
      //return  $citas_empleado;

      $collection = collect($lista_minutos_totales);

      $diff = $collection->diff($lista_minutos_ocupados);

      if ($vacaciones){
        $diff = ["00:00", "00:00"];
      }else{
        $diff =  $diff->flatten();
      }

      return [
        'start' => $start,
        'week_day' => $week_day,
        'horario query' => $horarios,        
        'app_empleado_id' => $empleado->id,
        'nombre_empleado' => $empleado->nombre,
        'diferencia'      => $diff
      ];
    });
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

  public function buscarDisponibleApp(Request $request){
    $tipo = Tipo::where('nombre', 'peluqueria')->get(['id'])->first();
    $week_day = Carbon::createFromDate($request->fecha)->dayOfWeek;
    $empleado_id = null;
    $tienda_id = 8;
    $tipo_id = $tipo->id;
    $id = $request->id;
    $duracion = 60;
    

    $empleados = $this->getEmpleados($id, $tipo_id, $week_day, $tienda_id, $request->fecha, $empleado_id);
    
    $horas=Array();
    $horas_empleados=Array();
    
    //Recorro todos los horarios de los empleados y compruebo si la cita cabe y no deja medias horas libres
    foreach ($empleados as $empleado) {
      
      if (sizeOf($empleado['diferencia'])>0 && $empleado['diferencia'][0]!="00:00"){
        //recorro todas las horas para ver si encaja la cita
        
        for($i=0; $i<sizeOf($empleado['diferencia']); $i++){
          //inicializamos variables
          $delante=false;
          $atras=false;
          $encaja = false;
          //confirmo cuantas posiciones me dura la cita
          $duracionPosiciones = ($duracion / 30) -1;

          //convertimos la fecha del for a objeto Carbon
          $fechaACtual = Carbon::createFromDate($request->fecha." ".$empleado['diferencia'][$i]);
         
          //si es el primer elemento o entre elemento actual y el anterior hay más de 30 minutos de diferencia significa que no tenemos que comprobar para atrás
          if ($i==0){
            
            //confirmo si sumo las posiciones el elemento existe 
            if (($duracionPosiciones + $i)<sizeOf($empleado['diferencia'])){
              //si el elemento existe compruebo que la diferencia de minutos sea la misma que la duración eso significa que los horarios son correlativos
              $fechaPosterior = Carbon::createFromDate($request->fecha." ".$empleado['diferencia'][$i+$duracionPosiciones])->addMinutes(30);
              $minutesDiff=$fechaACtual->diffInMinutes($fechaPosterior);
              
              //Si la diferencia entre minutos es igual a la duracion indico que encaja es true
              if ($minutesDiff == $duracion){
                $encaja = true;
              }
              
            }
            
            //una vez que se comprueba si encaja la cita hay que confirmar que no deja meida hora libre ni antes ni después como $i=0 solo delante
            if ($encaja){
              
              $idFinCita = $i + $duracionPosiciones;
              $idLibre = $idFinCita + 2;
              
              if($idLibre<sizeOf($empleado['diferencia'])){
                $fechaFinCita = Carbon::createFromDate($request->fecha." ".$empleado['diferencia'][$idFinCita])->addMinutes(30);
                $fechaLibre = Carbon::createFromDate($request->fecha." ".$empleado['diferencia'][$idLibre])->addMinutes(30);
               
                if ($fechaFinCita->diffInMinutes($fechaLibre) ==60){
                  //En este caso la hora es valida y atras también porque es la primera
                  $delante = true;
                  $atras = true;
                  
                }else{
                  $fechaPosterior = Carbon::createFromDate($request->fecha." ".$empleado['diferencia'][$idFinCita+1]);
                  
                  if($fechaFinCita->diffInMinutes($fechaPosterior) > 30){
                    $delante=true;
                    $atras = true;
                  }
                }
              }
            }
          }else{
            //confirmo si sumo las posiciones el elemento existe 
            if (($duracionPosiciones + $i)<sizeOf($empleado['diferencia'])){
             
              //si el elemento existe compruebo que la diferencia de minutos sea la misma que la duración eso significa que los horarios son correlativos
              $fechaPosterior = Carbon::createFromDate($request->fecha." ".$empleado['diferencia'][$i+$duracionPosiciones])->addMinutes(30);
              $minutesDiff=$fechaACtual->diffInMinutes($fechaPosterior);
              
              //Si la diferencia entre minutos es igual a la duracion indico que encaja es true
              if ($minutesDiff == $duracion){
                $encaja = true;
                
              }
              
            }
            //una vez que se comprueba si encaja la cita hay que confirmar que no deja media hora libre ni antes ni después 
            if ($encaja){
              
              $idFinCita = $i + $duracionPosiciones;
              $idLibre = $idFinCita + 2;
              if($idLibre<sizeOf($empleado['diferencia'])){
                $fechaFinCita = Carbon::createFromDate($request->fecha." ".$empleado['diferencia'][$idFinCita])->addMinutes(30);
                $fechaLibre = Carbon::createFromDate($request->fecha." ".$empleado['diferencia'][$idLibre])->addMinutes(30);
                
                if ($fechaFinCita->diffInMinutes($fechaLibre) ==60){
                  //En este caso la hora es valida
                  $delante=true;
                  
                }else{
                  $fechaPosterior = Carbon::createFromDate($request->fecha." ".$empleado['diferencia'][$idFinCita+1]);
                  
                  if($fechaFinCita->diffInMinutes($fechaPosterior) > 30){
                  
                    $delante=true;
                  }
                  
                }
              }else{
                
                if(($idFinCita + 1) == sizeOf($empleado['diferencia'])){
                  $delante=true;
                }
              }
              
              //compruebo atrás
              $idLibre = $i - 2;
              if(($i - ($duracionPosiciones+1))>=0 && $idLibre >=0){
                
                $fechaInicioCita = Carbon::createFromDate($request->fecha." ".$empleado['diferencia'][$i]);
                $idLibre = Carbon::createFromDate($request->fecha." ".$empleado['diferencia'][$idLibre]);
                
                if ($idLibre->diffInMinutes($fechaInicioCita) ==60){
                  //En este caso la hora es valida
                  $atras=true;
                }else{
                  $fechaInicioCita = Carbon::createFromDate($request->fecha." ".$empleado['diferencia'][$i]);
                  $fechaAnterior = Carbon::createFromDate($request->fecha." ".$empleado['diferencia'][$i-1]);
                  
                  if($fechaAnterior->diffInMinutes($fechaInicioCita) > 30){
                    $atras=true;
                  }
                }
              }
            }
            
          }
          if($delante && $atras){
            array_push($horas, $empleado['diferencia'][$i]);
          }
        }

        $hora_disponible_empleado = [
          "id_empleado" =>$empleado["app_empleado_id"],
          "nombre_empleado" => $empleado["nombre_empleado"],
          "horas_disponible" => $horas
        ];
        array_push($horas_empleados, $hora_disponible_empleado);

        $horas=Array();
        $hora_disponible_empleado = Array();
      }
    }
    return ($horas_empleados);
  }

}
