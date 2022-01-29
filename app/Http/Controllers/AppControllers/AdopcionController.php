<?php

namespace App\Http\Controllers\AppControllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppMascotaAdoptarResource;
use App\Http\Requests\AdopcionRequest;
use Illuminate\Http\Request;
use App\Models\Adopcion;  
use App\ModelsApp\AppUsuario;
use App\ModelsApp\AppMascota;
use App\ModelsApp\AppTienda;
use Carbon\Carbon;
use Storage;
use File;
use DB;

class AdopcionController extends Controller
{
  public function getAdopcionById($adopcion_id){
    $adopcion = (Adopcion::find($adopcion_id));    
    return response()->json(['adopcion' => $adopcion],200);
  }

  public function getAlladopciones(){
    $adopciones = Adopcion::with('mascota')->with('usuarioDonante')->with('tienda')
                          ->where('fecha_adopcion', '=', 0)
                          ->orderBy('created_at', 'DESC')->get();

    return response()->json($adopciones, 200);
  } 

  public function getAlladopcionesApp(){
    $adopciones = Adopcion::with('mascota')->with('usuarioDonante')->with('tienda')
                          ->where('fecha_adopcion', '=', 0)
                          ->orderBy('created_at', 'DESC')->get();
    
    return response()->json(AppMascotaAdoptarResource::collection($adopciones), 200);
  } 

  public function getAdopcionFechas(Request $request){
    return response()->json(
      Adopcion::with('mascota')->with('usuarioDonante')->with('usuarioAdoptante')->with('tienda')
                ->whereBetween('fecha_adopcion', [$request->desde , $request->hasta])
                ->orderBy('fecha_adopcion', 'DESC')->get(), 200);
  }

  public function deleteAdopcion($adopcion_id){
    $adopcion = Adopcion::find($adopcion_id);
    if(Storage::disk('adopciones')->exists($adopcion->file_name)){
       Storage::disk('adopciones')->delete($adopcion->file_name);
    }
    $adopcion->delete();
    return response()->json('Adopcion eliminada', 200);
  }

  public function saveAdopcion($usuario_id,$mascota_id){
    $fechaCompleta = Carbon::now();
    $fecha = substr($fechaCompleta,0,10);

    $user = AppUsuario::find(['id' => $usuario_id]);
    $id = intval($user[0]->id);

    $usuario = AppUsuario::updateOrCreate(['id' => $usuario_id], ['adoptar' => true]);

    $mascota = AppMascota::updateOrCreate(['id' => $mascota_id], ['app_usuario_id' => $usuario_id,'adoptable' => false]);

    $adopcion = Adopcion::where(['id_mascota' => $mascota_id])->get()->first();
    $adopcion->id_adoptante = $id;
    $adopcion->fecha_adopcion = $fecha;
    $adopcion->update();

    return response()->json(['usuario' => $usuario,'mascota' => $mascota,'adopcion' => $adopcion], 200);
  }
}
