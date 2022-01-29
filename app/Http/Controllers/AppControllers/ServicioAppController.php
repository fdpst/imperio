<?php

namespace App\Http\Controllers\AppControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ModelsApp\AppServicio;
use App\ModelsApp\Tipo;
use App\ModelsApp\AppServicioPelo;
use App\ModelsApp\AppServicioTamanyo;
use App\ModelsApp\AppServicioTipoMascota;

class ServicioAppController extends Controller
{
  public function getServicioByTipo($nombre){
    $saved_tipo = Tipo::where('nombre', $nombre)->get()->first();
    $servicios = AppServicio::where('tipo_id', $saved_tipo->id)->get();
    return response()->json($servicios, 200);
  }

  public function getServicios(){
      return response()->json(AppServicio::with('tipo')->get(), 200);
  }

  public function saveServicio(Request $request){
    $servicio = AppServicio::updateOrCreate(['id' => $request->id], $request->except(['tipo', 'tipos']));
    $servicio->tipo()->associate($request->tipo);
    $servicio->save();
      
    $encontrado = false;
    //Guardamos los datos de las caractarísticas del servicio
    /////////////////////////////////////tipo pelo///////////////////////////////////////////////////////
    //recorremos todos los servicios de la base de datos
    $serv_actual_tipo_pelo = AppServicioPelo::where('id_servicio', $servicio->id)->get();
    foreach ($serv_actual_tipo_pelo as $serv_pelo) {
      foreach ($request->tipos['tipo_pelo'] as $tipo_pelo) {
        if($tipo_pelo['id'] == $serv_pelo->id_servicio){
          $encontrado = true;
        }
      }
      //si está en la tabla pero no en el array que recibimos lo eliminamos
      if (!$encontrado){
        AppServicioPelo::findOrFail($serv_pelo->id)->delete();
      }
    }
    $encontrado = false;
    //recorremos el array de tipos y sino está en la tabla lo añadimos
    foreach ($request->tipos['tipo_pelo'] as $tipo_pelo) {
      foreach ($serv_actual_tipo_pelo as $serv_pelo) {
        if($tipo_pelo['id'] == $serv_pelo->id_servicio){
          $encontrado = true;
        }
      }
      if (!$encontrado){
        $servicio_pelo = new AppServicioPelo();
        $servicio_pelo->fill([
          'id_servicio'     => $servicio->id,
          'id_pelo'      => $tipo_pelo['id']
        ]);
        $servicio_pelo->save();
      }
    }

    /////////////////////////////////////tamaño mascota/////////////////////////////////////
    $encontrado = false;
    $serv_actual_tama= AppServicioTamanyo::where('id_servicio', $servicio->id)->get();
    foreach ($serv_actual_tama as $serv_tama) {
      foreach ($request->tipos['tipo_tamanyo'] as $tipo_tamanyo) {
        if($tipo_tamanyo['id'] == $serv_tama->id_servicio){
          $encontrado = true;
        }
      }
      //si está en la tabla pero no en el array que recibimos lo eliminamos
      if (!$encontrado){
        AppServicioTamanyo::findOrFail($serv_tama->id)->delete();
      }
    }
    $encontrado = false;
    //recorremos el array de tipos y sino está en la tabla lo añadimos
    foreach ($request->tipos['tipo_tamanyo'] as $tipo_tamanyo) {
      foreach ($serv_actual_tama as $serv_tama) {
        if($tipo_tamanyo['id'] == $serv_tama->id_servicio){
          $encontrado = true;
        }
      }
      if (!$encontrado){
        $servicio_tamanyo = new AppServicioTamanyo();
        $servicio_tamanyo->fill([
          'id_servicio'     => $servicio->id,
          'id_tamanyo'      => $tipo_tamanyo['id']
        ]);
        $servicio_tamanyo->save();
      }
    }
    /////////////////////////////////////tipo mascota/////////////////////////////////////
    $encontrado = false;
    $serv_actual_tipo= AppServicioTipoMascota::where('id_servicio', $servicio->id)->get();
    foreach ($serv_actual_tipo as $serv_tipo) {
      foreach ($request->tipos['tipo_mascota'] as $tipo_mascota) {
        if($tipo_mascota['id'] == $serv_tipo->id_servicio){
          $encontrado = true;
        }
      }
      //si está en la tabla pero no en el array que recibimos lo eliminamos
      if (!$encontrado){
        AppServicioTipoMascota::findOrFail($serv_tipo->id)->delete();
      }
    }
    $encontrado = false;
    //recorremos el array de tipos y sino está en la tabla lo añadimos
    foreach ($request->tipos['tipo_mascota'] as $tipo_mascota) {
      foreach ($serv_actual_tipo as $serv_tipo) {
        if($tipo_mascota['id'] == $serv_tipo->id_servicio){
          $encontrado = true;
        }
      }
      if (!$encontrado){
        $servicio_tipo = new AppServicioTipoMascota();
        $servicio_tipo->fill([
          'id_servicio'      => $servicio->id,
          'id_tipo_mascota'  => $tipo_mascota['id']
        ]);
        $servicio_tipo->save();
      }
    }
    
    return response()->json(['was_created' => $servicio->wasRecentlyCreated, 'servicio' => $servicio->load('tipo')], 200);
  }

  public function deleteServicio($servcio_id){
    $servicios_pelo = AppServicioPelo::where('id_servicio', $servcio_id)->get();
    foreach ($servicios_pelo as $servicio_pelo) {
      AppServicioPelo::findOrFail($servicio_pelo->id)->delete();
    }
    $servicios_tamanyo = AppServicioTamanyo::where('id_servicio', $servcio_id)->get();
    foreach ($servicios_tamanyo as $servicio_tamanyo) {
      AppServicioTamanyo::findOrFail($servicio_tamanyo->id)->delete();
    }
    $servicios_tipo = AppServicioTipoMascota::where('id_servicio', $servcio_id)->get();
    foreach ($servicios_tipo as $servicio_tipo) {
      AppServicioTipoMascota::findOrFail($servicio_tipo->id)->delete();
    }
    
    return response()->json(AppServicio::findOrFail($servcio_id)->delete(), 200);
  }
}
