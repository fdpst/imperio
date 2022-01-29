<?php

namespace App\Http\Controllers\AppControllers;

use App\Http\Resources\MascotaResource;
use App\Http\Controllers\Controller;
use App\ModelsApp\AppUsuario;
use App\ModelsApp\AppMascota;
use App\ModelsApp\AppHistorialMascota;
use App\ModelsApp\AppServicio;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImport;

class ExcelController extends Controller
{
  public function leerExcel(){
    //importacion de mascotas por usuario  
    /*$collection = Excel::toCollection(new ExcelImport, 'mascotas.xlsx');
     foreach ($collection as $key => $value) {
      foreach ($value as $key => $value2) {
        $usuario = AppUsuario::where('codigo', $value2[0])->get(['id'])->first();
        
        $mascota = new AppMascota();
        $mascota->fill([
          'app_usuario_id'=> $usuario->id,
          'seccion_id'=> 1,
		      'nombre' => $value2[1],
		      'raza' => '',
		      'peso' => '',
		      'imagen' => '',
		      'observaciones' => '',
		      'codigo' => $value2[2]
        ]);
        $mascota->save();
        
      }
     }*/

     //importacion historial
     /*
     $collection = Excel::toCollection(new ExcelImport, 'historial.xlsx');
     foreach ($collection as $key => $value) {
      foreach ($value as $key => $value2) {
        $usuario = AppUsuario::where('codigo', $value2[0])->get(['id'])->first();
        $mascota = AppMascota::where('app_usuario_id', $usuario->id)->where('codigo', $value2[1])->get(['id'])->first();
        $servicio = AppServicio::where('codigo', $value2[2])->first();
        if ($mascota && $servicio){
          $historial = new AppHistorialMascota();
          $historial->fill([
            'app_mascota_id'=> $mascota->id,
            'app_servicio_id'=> $servicio->id
          ]);
          $historial->save();
        }
        
        
      }
     }*/

     $collection = Excel::toCollection(new ExcelImport, 'tiposc.xlsx');
     foreach ($collection as $key => $value) {
      foreach ($value as $key => $value2) {
        $usuario = AppUsuario::where('codigo', $value2[0])->get(['id'])->first();
        $pelo=null;
        $tamanyo=null;
        if($usuario){
          $mascota = AppMascota::where('app_usuario_id', $usuario->id)->where('codigo', $value2[1])->get()->first();
        if ($value2[2] == 2 || $value2[2] == 5 || $value2[2] == 6 || $value2[2] == 7 || $value2[2] == 9 || $value2[2] == 13 || $value2[2] == 15 || $value2[2] == 18 || $value2[2] == 20
           || $value2[2] == 10159 || $value2[2] == 70008 || $value2[2] == 70009 || $value2[2] == 89207){
             $pelo = 1;
        }else{
          $pelo = 2;
        }

        if ($value2[2] == 10158 || $value2[2] == 10159 || $value2[2] == 10160 || $value2[2] == 70008){
          $tamanyo = 4;
        }else if ($value2[2] == 5 || $value2[2] == 8 || $value2[2] == 9 || $value2[2] == 10 || $value2[2] == 70008){
          $tamanyo = 3;
        }else if ($value2[2] == 6 || $value2[2] == 11 || $value2[2] == 12 || $value2[2] == 13 || $value2[2] == 14 || $value2[2] == 15 || $value2[2] == 70008){
          $tamanyo = 2;
        }else if ($value2[2] == 4 || $value2[2] == 7 || $value2[2] == 16 || $value2[2] == 17 || $value2[2] == 18 || $value2[2] == 19 || $value2[2] == 20 || $value2[2] == 21 || $value2[2] == 10179
        || $value2[2] == 89207){
          $tamanyo = 1;
        }else{
          $tamanyo = 2;
        }
        if($mascota){
          $mascota->pelo = $pelo;
          $mascota->tamanyo = $tamanyo;
          $mascota->save();
        }
        }
        
        
        /*$servicio = AppServicio::where('codigo', $value2[2])->first();
        if ($mascota && $servicio){
          $historial = new AppHistorialMascota();
          $historial->fill([
            'app_mascota_id'=> $mascota->id,
            'app_servicio_id'=> $servicio->id
          ]);
          $historial->save();
        }*/
        
        
      }
     }
    
  }
}