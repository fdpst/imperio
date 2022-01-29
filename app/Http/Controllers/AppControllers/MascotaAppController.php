<?php

namespace App\Http\Controllers\AppControllers;

use App\Http\Resources\MascotaResource;
use App\Http\Controllers\Controller;
use App\ModelsApp\AppUsuario;
use App\ModelsApp\AppMascota;
use App\ModelsApp\AppServicioTipoMascota;
use App\ModelsApp\AppServicioTamanyo;
use App\ModelsApp\AppServicioPelo;
use App\Models\Adopcion; 
use App\Models\Seccion; 
use App\ModelsApp\AppServicio;
use App\ModelsApp\AppMascotaPelo;   
use App\ModelsApp\AppMascotaTamanyo; 
use Illuminate\Http\Request;
use Carbon\Carbon;

class MascotaAppController extends Controller
{
  public function getMascotas(){
    $mascotas = AppMascota::with('usuario', 'seccion')->orderBy('created_at', 'DESC')->get();
    return response()->json(MascotaResource::collection($mascotas), 200);
  }

  public function getMascotaById($mascota_id){
    $mascotaId = AppMascota::where('id', $mascota_id)->get();
    return response()->json($mascotaId, 200);
  }

  public function getMascotasByUser($usuario_id){
    $mascotas = AppMascota::with('historial.servicio','usuario')->where('app_usuario_id', $usuario_id)->get();
    return response()->json($mascotas, 200);
  }

  public function saveMascotaFromUser($usuario_id, Request $request){
    //return response()->json($request, 200);
    $usuario = AppUsuario::find($usuario_id);
    
    $mascota = $usuario->mascota()->updateOrCreate(['id' => $request->id], $request->all());

    if ($request->adoptable == 1) {
       $adopcion = Adopcion::create(
         [
           'id_tienda'      => 1,
           'id_mascota'     => $mascota->id,
           'id_adoptante'   => 0,
           'id_donante'     => $usuario->id,
           'fecha_donacion' => Carbon::now(),
           'fecha_adopcion' => 0,
         ]
       );
    }
    return response()->json($mascota, 200);
  }

  public function deleteMascota($id){
    return response()->json(AppMascota::find($id)->delete(), 200);
  }

  public function serviciosMascota($id){
    //obtenemos el la mascota para ver que características tiene y buscar los servicios que le correspnda
    $mascota = AppMascota::where('id', $id)->first();
    $serviciosTipoMascota = AppServicioTipoMascota::where('id_tipo_mascota', $mascota->seccion_id)->get();
    $serviciosTamanyoMascota = AppServicioTamanyo::where('id_tamanyo', $mascota->tamanyo)->get();
    $serviciosPeloMascota = AppServicioPelo::where('id_pelo', $mascota->pelo)->get();
    $error = "Tu mascota no tiene especificado los siguinetes campos: ";
    $errores = false;
    if (sizeof($serviciosTipoMascota)<=0){
      $error = $error."Tipo de mascota.";
      $errores = true;
    }
    if (sizeof($serviciosTamanyoMascota)<=0){
      $error = $error."Tamaño de mascota.";
      $errores = true;
    }
    if (sizeof($serviciosPeloMascota)<=0){
      $error = $error."Tipo de Pelo.";
      $errores = true;
    }
    if ($errores){
      $error = $error."Por favor, especifica los campos en la pantalla mascota para poder escoger la cita que mejor se adapte a tu mascota.";
      return response()->json($error, 404);
    }
    /*Utilizamos 2 variables de control para saber si el id de servicio coincide y cumple con todas las condiciones 
    y en el caso de que cumpla con todas las condiciones guardamos en array*/
    $tamanyo = false;
    $pelo = false;
    $servicios_mascota = array();
    //recorrremos todos los servicios que tengan el mismo tipo de mascota
    
    foreach ($serviciosTipoMascota as $servicioTipoMascota) {
      
      $tamanyo = false;
      $pelo = false;
      $id_servicio = $servicioTipoMascota->id_servicio;
      /*por cada servicio recorremos todos los servicios que coinciden con tamaño para ver si sus ids son iguales
      si lo son, se pone la variable de control a true*/
      foreach ($serviciosTamanyoMascota as $servicioTamanyoMascota) {
        if ($id_servicio == $servicioTamanyoMascota->id_servicio){
          $tamanyo = true;
        }
      }
      /*si la variable de control de tamanyo es true, recorremos todos los servicios de pelo para comprobar si coinciden con el de la mascota.
      si coincide seteamos la varibale de pelo a true*/
      if ($tamanyo == true){
        foreach ($serviciosPeloMascota as $servicioPeloMascota) {
          if ($id_servicio == $servicioPeloMascota->id_servicio){
            $pelo = true;
          }
        }
      }
      /*Si las dos varibales de control están en true significa que el servicio cumple con todas las características de la mascota y lo añadimos al array*/
      if ($pelo == true && $tamanyo == true){
        $servicio = AppServicio::where('id', $id_servicio)->get();
        array_push($servicios_mascota, $servicio);
      }
      
    }
    return response()->json($servicios_mascota, 200);
  }

  public function getTiposPelo(){
    $tiposPelo = AppMascotaPelo::get();
    return response()->json($tiposPelo, 200);
  }

  public function getTiposMascotas(){
    $tiposMascotas = Seccion::get();
    return response()->json($tiposMascotas, 200);
  }

  public function getTiposTamanyos(){
    $tiposTamanyos = AppMascotaTamanyo::get();
    return response()->json($tiposTamanyos, 200);
  }

  public function getServiciosTipoPelo($id){
    $servciosTiposPelo = AppServicioPelo::where('id_servicio', $id)->get();
    $servicios =array();
    foreach ($servciosTiposPelo as $servcioTipoPelo) {
      array_push($servicios, $servcioTipoPelo->id_pelo);
    }
    return response()->json($servicios, 200);
  }

  public function getServiciosTiposMascota($id){
    $servciosTiposMascota = AppServicioTipoMascota::where('id_servicio', $id)->get();
    $servicios =array();
    foreach ($servciosTiposMascota as $servcioTipoMascota) {
      array_push($servicios, $servcioTipoMascota->id_tipo_mascota);
    }
    return response()->json($servicios, 200);
  }

  public function getServiciosTiposTamanyos($id){
    $servciosTiposTamanyo = AppServicioTamanyo::where('id_servicio', $id)->get();
    $servicios =array();
    foreach ($servciosTiposTamanyo as $servcioTipoTamanyo) {
      array_push($servicios, $servcioTipoTamanyo->id_tamanyo);
    }
    return response()->json($servicios, 200);
  }

}