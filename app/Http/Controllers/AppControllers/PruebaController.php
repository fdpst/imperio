<?php

namespace App\Http\Controllers\AppControllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\EmpleadoTurno;
use Illuminate\Http\Request;
use App\Events\ActualEvent;
use App\Models\Solicitud;
use App\Models\Empleado;
use App\Models\Seccion;
use App\Models\WebUser;
use App\Events\MyEvent;
use Carbon\Carbon;
use Auth;

class PruebaController extends Controller
{
  public function index(){
    return view('app.cliente_inicio');
  }

  public function empleados(){
    return view('app.empleado');
  }

  public function tienda(){
    $auth_user_name = Auth::user()->name;
    return view('app.tienda', compact('auth_user_name'));
  }

  public function turnoActual(){
    return view('app.turno_actual');
  }

  public function testAuth(){
    return 'success';
  }

  public function getEmpleados(){
    $auth_user = WebUser::find(Auth::id());

    $empleados = $auth_user->empleados()->with('secciones:id,nombre')->whereHas('is_active')->get();

    $solicitudes = Solicitud::with('seccion', 'empleado:id,nombre')->whereIn('status', ['pendiente', 'progreso'])->where('web_user_id', $auth_user->id)->orderBy('created_at', 'DESC')->get();

    $secciones = Seccion::all();

    return response()->json([
     'empleados' => $empleados,
     'clientes'  => $solicitudes,
     'secciones' => $secciones
   ], 200);
  }

  /* este es el turno que el empleado crea */
  public function createTurno(Request $request){
    $tiempo = Carbon::now()->toDateTimeString();

    $solicitud = Solicitud::create($request->merge([
      'status'        => 'progreso',
      'hora_inicio'   => $tiempo,
      'hora_progreso' => $tiempo,
      'tiempo_espera' => 0,
      'web_user_id'   => Auth::id()
    ])->all());

    $solicitud->load('seccion', 'empleado');

    event(new ActualEvent($solicitud));

    return response()->json(['solicitud' => $solicitud], 200);
  }

  public function setTurno(Request $request){
    $secciones_ids = collect($request->secciones)->map(function ($seccion) {
      return $seccion['id'];
    });

    $cliente_anterior = Solicitud::with('seccion', 'empleado')->where('empleado_id', $request->id)->where('status', 'progreso')->get()->first();

    if($cliente_anterior){
      $cliente_anterior->status = 'finalizado';

      $cliente_anterior->hora_final = Carbon::now()->toDateTimeString();

      //aqui pongo el tiempo de la consulta...

      $cliente_anterior->tiempo_consulta = $this->getDiff($cliente_anterior['hora_progreso'], $cliente_anterior['hora_final']);

      $cliente_anterior->save();
    }

    $cliente = Solicitud::whereIn('seccion_id', $secciones_ids)->where('status', 'pendiente')->get()->first();

    if($cliente){
      $cliente->empleado_id = $request->id;

      $cliente->status = 'progreso';

      $cliente->hora_progreso = Carbon::now()->toDateTimeString();

      $cliente->tiempo_espera = $this->getDiff($cliente['hora_inicio'], $cliente['hora_progreso']);

      $cliente->save();

      event(new ActualEvent());

      return response()->json([
        'cliente'  => $cliente->load('seccion', 'empleado'),
        'anterior' => $cliente_anterior
      ], 200);

    }

    event(new ActualEvent());

    return response()->json([
      'cliente'  => null,
      'anterior' => $cliente_anterior
    ], 200);

  }

  private function getDiff($hora_inicio, $hora_final){
    return Carbon::parse($hora_inicio)->floatDiffInMinutes($hora_final);
  }

  public function getClientesActuales(){
    $solicitudes = Solicitud::with('empleado:id,nombre')->where('status', 'progreso')->get();
    return response()->json($solicitudes, 200);
  }

  public function getSecciones(Request $request){
    $secciones = Seccion::get(['id', 'nombre']);
    return response()->json(['secciones' => $secciones], 200);
        
  }

  public function addToQueue(Request $request){
    $solicitud = Solicitud::create($request->merge([
       'status'      => 'pendiente',
       'web_user_id' => Auth::id(),
       'hora_inicio' => Carbon::now()->toDateTimeString()
    ])->all());

    $solicitud->load('seccion');

    event(new MyEvent($solicitud));

    return response()->json(['solicitud' => $solicitud], 200);
  }

  public function guardarTurno($empleado_id){
    $empleado = Empleado::find($empleado_id);

    $ultimo_turno = $empleado->ultimo_turno;

    if(!$ultimo_turno){
      return $this->nuevoTurno($empleado);
    }

    if(!$ultimo_turno->final){

       $ultimo_turno->final = Carbon::now()->toDateTimeString();

       $ultimo_turno->tiempo_trabajo = $this->getDiff($ultimo_turno['inicio'], $ultimo_turno['final']);

       $ultimo_turno->save();
    }else{
      return $this->nuevoTurno($empleado);
    }

    return response()->json(['empleado' => $empleado->load('ultimo_turno')], 200);
  }

  private function nuevoTurno(Empleado $empleado){
    $turno = $empleado->turno()->create([
      'inicio' => Carbon::now()->toDateTimeString()
    ]);
    return response()->json(['empleado' => $empleado->load('ultimo_turno')], 200);
  }

  public function getAuthUser(){
    $auth_user = WebUser::find(Auth::id());

    $empleados = $auth_user->empleados;

    return response()->json(['empleados' => $empleados->load('ultimo_turno')], 200);
  }

  public function cancelarCita($solicitud_id){
    $solicitud = Solicitud::find($solicitud_id);

    $solicitud->status = 'cancelado';

    $solicitud->save();

    return response()->json('cancelado', 200);
  }

  public function confirmarCita(Request $request){
    $solicitud = Solicitud::find($request['id']);

    $secciones = $request->secciones;

    if(empty($secciones)){
      return response()->json('vacio', 422);
    }

    foreach($secciones as $seccion){
      $new = $solicitud->replicate();
      $new->seccion_id = $seccion['id'];
      $new->save();
    }

    $solicitud->delete();

    return response()->json('guardado', 200);
  }

  public function notificarTurno(Request $request){
    $notification = array();
    $notification['title'] = $request->cliente;
    $notification['message'] = $request->empleado;
    $notification['image'] = '';
    $notification['action'] = '';
    $notification['action_destination'] = '';            
    $topic = "tienda-" .$request->tienda;
    $fields = array(
        'to' => '/topics/' . $topic,
        'data' => $notification,
    );
    // Set POST variables
    $url = 'https://fcm.googleapis.com/fcm/send';
    $headers = array(
                'Authorization: key=AAAAcuCXNio:APA91bGLYtA-1qTVcdhkTqFu5lh4kmwkzZcRvdG7-_OBJS_1J1Mp_Ec78OBjkZ2nCNojmPPCIvR_AkDwnhP0AB2jrZfd6cOBj1PaQS6nVUtyGoXOs2imj8bORb_EAtFpen1NIGkd0jvI',
                'Content-Type: application/json'
                );
                
    // Open connection
    $ch = curl_init();
    // Set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Disabling SSL Certificate support temporarily
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));       
    
    $result = curl_exec($ch);
    if($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
        return response()->json('Error', 400);
    }
    // Close connection
    curl_close($ch);
    return response()->json('Notificación enviada', 200);
  }
}
