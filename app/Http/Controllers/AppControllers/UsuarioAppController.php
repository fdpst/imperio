<?php

namespace App\Http\Controllers\AppControllers;

use App\Http\Requests\AppUsuarioRequest;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use App\ModelsApp\AppUsuario;
use App\ModelsApp\AppUsuariosArchivos;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class UsuarioAppController extends Controller
{
  public function login(Request $request){
    $user = AppUsuario::where('email', $request->email)->first();

    $credentials = $request->only('email', 'password');

    if (!$user || !Hash::check($request->password, $user->password)) {
      return response(['message' => ['Estas credenciales no coinciden con nuestros registros.']], 404);
    }

    $token = auth('android_users')->attempt($request->only('email', 'password'), ['exp' => Carbon::now()->addYear()->timestamp]);

    //return 'no token'. $token; <- esto no se muy bien que hace

    if(!$token){
    	return response()->json(['error' => 'Error Autenticando token'], 401);
    }

    $response = ['user' => $user, 'token' => $token];

    return response($response, 201);
  }

  public function getUsuarios(){
    return response()->json(AppUsuario::get(), 200);
  }

  public function getUsuariosAdoptantes(){
    return response()->json(AppUsuario::with('direccion')->where('adoptar',true)->get(), 200);
  }

  public function getUsuariosDonantes(){
    return response()->json(AppUsuario::with('direccion')->where('donar',true)->get(), 200);
  }

  public function getUsuario($usuario_id){
    return response()->json(AppUsuario::find($usuario_id), 200);
  }

  public function getArchivos($id){
    return response()->json(AppUsuariosArchivos::where('id_usuario', $id)->get(), 200);
  }

  public function getDieta($id){
    $dieta = AppUsuariosArchivos::where('id_usuario', $id)->where('tipo_archivo', 'dieta')->orderBy('id', 'desc')->first();

    if($dieta){
      return response()->json($dieta, 200);
    }else{
      return response()->json("No tienes ninguna dieta activada", 200);
    }
    
  }

  public function getEntrenamiento($id){
    $entrenamiento = AppUsuariosArchivos::where('id_usuario', $id)->where('tipo_archivo', 'entrenamiento')->orderBy('id', 'desc')->first();

    if($entrenamiento){
      return response()->json($entrenamiento, 200);
    }else{
      return response()->json("No tienes ningún entrenamiento activado", 200);
    }
    
  }

  public function getHistorial($id){
    $historial = AppUsuariosArchivos::where('id_usuario', $id)->where('tipo_archivo', 'entrenamiento')->orderBy('id', 'desc')->first();
    if($historial){
      return response()->json($historial, 200);
    }else{
      return response()->json("No tienes ningún historial activado", 200);
    }
  }

  public function saveUsuario(Request $request){
    
    $validator = Validator::make($request->all(), ['nombre' => 'required','telefono' => 'required']);

    if ($validator->fails()){
      $messages = $validator->errors()->all();
      $msg = $messages[0];
      return response()->json(['status' => false, 'mensaje' => $msg], 301);
    }
      $usuario = AppUsuario::updateOrCreate(['id' => $request->id], $request->all());
      return response()->json($usuario, 200);
  }

  public function deleteUsuario($usuario_id){
    $usuario = AppUsuario::find($usuario_id);
    $usuario->event()->delete();
    $usuario->mascota()->delete();
    $usuario->delete();
    return response()->json('usuario eliminado', 200);
  }
  
}
