<?php

namespace App\Http\Controllers\AppControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PromocionRequest;
use Illuminate\Http\Request;
use App\Models\Promocion;  
use App\Models\SeccionPromo;  
use Storage;
use File;
use DB;

class PromocionController extends Controller
{
  public function getAllpromociones(){
    $promociones = Promocion::orderBy('created_at', 'DESC')->get();
    
    foreach ($promociones as $promocion) {
      $seccionesPromo = (DB::table('app_promocion_seccion')->select('id_seccion')->where('id_promocion', '=', $promocion->id)->get());
      $secciones = array();
      
      foreach ($seccionesPromo as $seccion) {
        array_push($secciones, $seccion->id_seccion);
      }
      $promocion['secciones'] = $secciones;
    }
    
    return response()->json($promociones, 200);
  } 

  public function getPromocionApp(){
    $promocion = Promocion::orderBy('id', 'DESC')->first();
    if($promocion){
      return response()->json($promocion, 200);
    }else{
      return response()->json("No hay ninguna promoción activa", 200);
    }
  } 

  public function getPromocionById($promocion_id){
    $promocion = (Promocion::find($promocion_id));    
    $seccionpromo = (DB::table('app_promocion_seccion')->select('id_seccion')->where('id_promocion', '=', $promocion_id)->get()); 
    $seccionid = array();
    foreach ($seccionpromo as $key => $value) {
      array_push($seccionid, $value->id_seccion );
    }
    return response()->json(['promocion' => $promocion,'seccionpromo' => $seccionid],200);
  }

  public function deletePromocion($promocion_id){
    $promocion = Promocion::find($promocion_id);
    if(Storage::disk('promociones')->exists($promocion->file_name)){
       Storage::disk('promociones')->delete($promocion->file_name);
    }
    $promocion->delete();
    DB::table('app_promocion_seccion')->where('id_promocion', '=', $promocion_id)->delete();
    return response()->json('Promocion eliminada', 200);
  }

  public function changePromocionActive($promocion_id){
    $promocion = Promocion::find($promocion_id);
    $promocion->active = !$promocion->active;
    $promocion->save();
    return response()->json('Estado actualizado', 200);
  }

  public function savePromocion(PromocionRequest $request){
    $old_file = null;
    $promocion = Promocion::find($request->id);
    if($promocion){ $old_file = $promocion->file_name; }
    $has_promocion = (File::isFile($request->file_name)) ? true : false;

    try {
      $promocion = Promocion::updateOrCreate(['id' => $request->id], $request->except(['promocion_name', 'path']));

      if($old_file && $has_promocion)
      {
        if(Storage::disk('promociones')->exists($promocion->file_name) && Storage::disk('promociones')->exists($old_file))
        {
          Storage::disk('promociones')->delete($old_file);
        }
      }

      if ($request->secciones == null)
      {
        DB::table('app_promocion_seccion')->where('id_promocion', '=', $request->id)->delete();
      }
      else
      {
        DB::table('app_promocion_seccion')->where('id_promocion', '=', $request->id)->delete();
        $promoseccion = $request->secciones;
        $idpromo = $promocion->id;
        foreach ($promoseccion as $promsec) {
          SeccionPromo::create([
            'id_promocion' => $idpromo,
            'id_seccion'   => $promsec
          ]);
        }
      }
      
      return response()->json($promocion, 200);
    }
    catch (Exception $exception) {
      return response()->json('error', 301);
    }
  }
}
