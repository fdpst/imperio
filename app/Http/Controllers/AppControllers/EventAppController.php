<?php

namespace App\Http\Controllers\AppControllers;

use App\Http\Resources\AppEventoResource;
use App\ModelsApp\AppHistorialMascota;
use App\Http\Controllers\Controller;
use App\Http\Requests\AgendaRequest;
use App\ModelsApp\AppHorarioTienda;
use App\ModelsApp\AppEmpleado;
use App\Core\Contracts\AppServicio;
use App\ModelsApp\AppUsuario;
use App\Core\Contracts\Cliente;
use App\Core\Contracts\Stock;
use App\Core\Contracts\Venta;
use App\Core\Contracts\NroTicket;
use App\ModelsApp\AppTienda;
use App\ModelsApp\AppEvent;
use App\ModelsApp\Tipo;
use App\ModelsApp\AppMascota;
use App\ModelsApp\AppDireccionUsuario;
use App\Models\DataMail;
use Illuminate\Http\Request;
use App\Mail\NewPetDateMail;
use App\Mail\confirmCitaMail;
use Carbon\Carbon;
use App\Http\Controllers\ApiControllers\TicketApiController;
use Mail;
use Str;

class EventAppController extends Controller
{
  public function confirmarCita($evento_id){
    $evento = AppEvent::find($evento_id);
    $evento->confirmada = !$evento->confirmada;
    $evento->save();
    return response()->json(new AppEventoResource($evento), 200);
  }

  public function getEvents($fecha){
    $events = AppEvent::whereHas('empleado')->whereHas('usuario')
      ->whereBetween('start', [Carbon::parse($fecha)->startOfWeek(), Carbon::parse($fecha)->endOfWeek()])
      ->with('servicio', 'mascota')
      ->get();
    return response()->json(AppEventoResource::collection($events), 200);
  }

  public function getData($nombre_tipo, $tienda_id){
    $tipo = Tipo::where('nombre', $nombre_tipo)->get(['id'])->first();
    $empleados = AppEmpleado::with(['fecha', 'horario' => function($query) use ($tienda_id){
        $query->where('app_tienda_id', $tienda_id)->orderBy('entrada', 'ASC');
    }])->where('tipo_id', $tipo->id)->whereHas('tienda', function($q) use ($tienda_id){
        $q->where('app_tienda_id', $tienda_id);
    })->get();
    $clientes = Cliente::get();//AppUsuario::get();
    $servicios = AppServicio::get(['id','nombre', 'duracion', 'precio']);
    return response()->json([
      'clientes'  => $clientes,
      'empleados' => $empleados,
      'servicios' => $servicios,
    ], 200);
  }

  public function saveCita(AgendaRequest $request){

     $filename = $this->saveCitaTicket($request);
     $venta = Venta::where('url_ticket', $filename->getData())->first();
    //if (!isset ($request->id)) {            
      // Busca si la mascota tiene cita en el dia o dias posteriores
        /*$recent_event = AppEvent::where('app_mascota_id', $request->app_mascota_id)
                                ->whereDate('start', '>=', Carbon::parse($request->fecha))
                                ->get()->first();
      // Si tiene cita nos da una mensaje de error
      if($recent_event){
        return response()->json(['message' => 'Mascota tiene cita activa'], 301);
      }*/
      // si existe id en request lo busca y lo borra
      if($request->id){
      $existing_event = AppEvent::find($request->id);
      $existing_event->delete();
      }
      // Obtengo empleado
      $empleado = $this->getEmpleado($request->app_empleado_id);
      // Obtengo si la fecha es correcta
      $out_of_time = $this->isOutOfTime($request->app_tienda_id, $request->fecha, $request->start, $request->end);
      //return response()->json(['message' => $out_of_time], 301);
      if(!$out_of_time){
        if(isset($existing_event)){
          $existing_event->restore();
        }
      return response()->json(['message' => 'fuera de horario'], 301);
      }
      // Obtengo horas de empleado
      /*$events = $empleado->event;
      $fit = $this->fitInTime($events, $request->start, $request->end);
      // Verifico si hay hora disponible
      /if(!$fit){
        if(isset($existing_event)){
          $existing_event->restore();
        }
      return response()->json(['message' => 'hora no disponible en fit'], 301);
      }*/
      $event = new AppEvent();
      $event->fill([
      'app_empleado_id'     => $empleado['id'],
      'app_usuario_id'      => $request->app_usuario_id,
      'app_mascota_id'      => null,
      'app_tienda_id'       => $request->app_tienda_id,
      'start'               => $request->start,
      'end'                 => $request->end,
      'duracion'            => $request->duracion,
      'confirmada'          => $request->confirmada,
      'recogida'            => $request->recogida,
      'direccion_recogida'  => $request->direccion_recogida,
      'direccion_entrega'   => $request->direccion_entrega,
      'pago'                => $request->pago,
      'precio'              => $request->precio,
      'id_ticket'           => $venta->nro_ticket->id
      ]);

      // Actualizamos las observaciones de usuario
      $usuario = Cliente::updateOrCreate(['id' => $request->app_usuario_id], ['observaciones' => $request->observacionesUsuario]);
      // Actualizamos las observaciones de la mascota
     // $mascota = AppMascota::updateOrCreate(['id' => $request->app_mascota_id], ['observaciones' => $request->observaciones]);

      $tipo = Tipo::where('nombre', $request->tipo)->get(['id'])->first();
      $saved_event = $tipo->event()->save($event);
      $servicios = $this->returnIds($request->servicios);
      $saved_event->servicio()->sync($servicios);
      //return response()->json(['message' => $saved_event], 301);
      //$historial = $this->guardarHistorial($servicios, $saved_event->app_mascota_id);
      
      // Comprobamos si esta confirmada la cita para envio de mail 
      if($request->confirmada == '0'){
        
        $user = AppUsuario::where(['id' => $request->app_usuario_id])->get(['email','nombre'])->first();
        $userMail = $user->email;
        $userName = $user->nombre;
        /*$pet = AppMascota::where(['id' => $request->app_mascota_id])->get(['nombre'])->first();
        $petName = $pet->nombre;*/
        $date = AppEvent::where('app_usuario_id', $request->app_usuario_id)->get(['start','end'])->first();
        $dateStart = substr($date->start,0,16);
        $dateEnd = substr($date->end,0,16);
        $empleado = AppEmpleado::where('id', $empleado['id'])->get(['nombre'])->first();
        $empleadoName = $empleado->nombre;
        $tienda = AppTienda::where('id', $request->app_tienda_id)->get(['nombre'])->first();
        $tiendaName = $tienda->nombre;

        $dataMail = new DataMail;
        $dataMail ->fill([
          'userMail' => $userMail,
          'userName' => $userName,
          //'petName' => $petName,
          'dateStart' => $dateStart,
          'dateEnd' => $dateEnd,
          'empleadoName' => $empleadoName,
          'tiendaName' => $tiendaName,
          'confirmada' => 'SIN CONFIRMAR'
        ]);
        //Mail::to($userMail)->send(new NewPetDateMail($dataMail));
      }
      // Comprobamos si no esta confirmada la cita para envio de mail    
      if($request->confirmada == '1'){

        $user = Cliente::where(['id' => $request->app_usuario_id])->get(['email','nombre'])->first();
        $userMail = $user->email;
        $userName = $user->nombre;
        //$pet = AppMascota::where(['id' => $request->app_mascota_id])->get(['nombre'])->first();
        //$petName = $pet->nombre;
        $date = AppEvent::where('app_usuario_id', $request->app_usuario_id)->get(['start','end'])->first();
        $dateStart = substr($date->start,0,16);
        $dateEnd = substr($date->end,0,16);
        $empleado = AppEmpleado::where('id', $empleado['id'])->get(['nombre'])->first();
        $empleadoName = $empleado->nombre;
        $tienda = AppTienda::where('id', $request->app_tienda_id)->get(['nombre'])->first();
        $tiendaName = $tienda->nombre;

        $dataMail = new DataMail;
        $dataMail ->fill([
          'userMail' => $userMail,
          'userName' => $userName,
          //'petName' => $petName,
          'dateStart' => $dateStart,
          'dateEnd' => $dateEnd,
          'empleadoName' => $empleadoName,
          'tiendaName' => $tiendaName,
          'confirmada' => 'CONFIRMADA'
        ]);
        //Mail::to($userMail)->send(new NewPetDateMail($dataMail));
      } 

      /*return response()->json(new AppEventoResource($saved_event), 200);
    }*/
    /*else
    {            
      // Busca si la mascota tiene cita en el dia o dias posteriores
        $recent_event = AppEvent::where('app_mascota_id', $request->app_mascota_id)
                                ->whereDate('start', '>=', Carbon::parse($request->fecha))
                                ->get()->first();
      // si existe id en request lo busca y lo borra
      if($request->id){
        $existing_event = AppEvent::find($request->id);
        $existing_event->delete();
      }
      // Obtengo empleado
      $empleado = $this->getEmpleado($request->app_empleado_id);
      // Obtengo si la fecha es correcta
      $out_of_time = $this->isOutOfTime($request->app_tienda_id, $request->fecha, $request->start, $request->end);
      if(!$out_of_time){
        if(isset($existing_event)){
          $existing_event->restore();
        }
      return response()->json(['message' => 'fuera de horario'], 301);
      }
      // Obtengo horas de empleado
      $events = $empleado->event;
      $fit = $this->fitInTime($events, $request->start, $request->end);
      // Verifico si hay hora disponible
      if(!$fit){
        if(isset($existing_event)){
          $existing_event->restore();
        }
      return response()->json(['message' => 'hora no disponible en fit'], 301);
      }
      $event = new AppEvent();
      $event->fill([
      'app_empleado_id'     => $empleado['id'],
      'app_usuario_id'      => $request->app_usuario_id,
      'app_mascota_id'      => $request->app_mascota_id,
      'app_tienda_id'       => $request->app_tienda_id,
      'start'               => $request->start,
      'end'                 => $request->end,
      'duracion'            => $request->duracion,
      'confirmada'          => $request->confirmada,
      'recogida'            => $request->recogida,
      'direccion_recogida'  => $request->direccion_recogida,
      'direccion_entrega'   => $request->direccion_entrega,
      'pago'                => $request->pago
      ]);

      // Actualizamos las observaciones de usuario
      $usuario = AppUsuario::updateOrCreate(['id' => $request->app_usuario_id], ['observaciones' => $request->observacionesUsuario]);
      // Actualizamos las observaciones de la mascota
      $mascota = AppMascota::updateOrCreate(['id' => $request->app_mascota_id], ['observaciones' => $request->observaciones]);
      
      $tipo = Tipo::where('nombre', $request->tipo)->get(['id'])->first();
      $saved_event = $tipo->event()->save($event);
      $servicios = $this->returnIds($request->servicios);
      $saved_event->servicio()->sync($servicios);
      $historial = $this->guardarHistorial($servicios, $saved_event->app_mascota_id);
      // Comprobamos si esta confirmada la cita para envio de mail 
      if($request->confirmada == '0'){
        
        $user = AppUsuario::where(['id' => $request->app_usuario_id])->get(['email','nombre'])->first();
        $userMail = $user->email;
        $userName = $user->nombre;
        $pet = AppMascota::where(['id' => $request->app_mascota_id])->get(['nombre'])->first();
        $petName = $pet->nombre;
        $date = AppEvent::where('app_mascota_id', $request->app_mascota_id)->get(['start','end'])->first();
        $dateStart = substr($date->start,0,16);
        $dateEnd = substr($date->end,0,16);
        $empleado = AppEmpleado::where('id', $empleado['id'])->get(['nombre'])->first();
        $empleadoName = $empleado->nombre;
        $tienda = AppTienda::where('id', $request->app_tienda_id)->get(['nombre'])->first();
        $tiendaName = $tienda->nombre;

        $dataMail = new DataMail;
        $dataMail ->fill([
          'userMail' => $userMail,
          'userName' => $userName,
          'petName' => $petName,
          'dateStart' => $dateStart,
          'dateEnd' => $dateEnd,
          'empleadoName' => $empleadoName,
          'tiendaName' => $tiendaName,
          'confirmada' => 'SIN CONFIRMAR'
        ]);
        //Mail::to($userMail)->send(new NewPetDateMail($dataMail));
      }
      // Comprobamos si no esta confirmada la cita para envio de mail    
      if($request->confirmada == '1'){

        $user = AppUsuario::where(['id' => $request->app_usuario_id])->get(['email','nombre'])->first();
        $userMail = $user->email;
        $userName = $user->nombre;
        $pet = AppMascota::where(['id' => $request->app_mascota_id])->get(['nombre'])->first();
        $petName = $pet->nombre;
        $date = AppEvent::where('app_mascota_id', $request->app_mascota_id)->get(['start','end'])->first();
        $dateStart = substr($date->start,0,16);
        $dateEnd = substr($date->end,0,16);
        $empleado = AppEmpleado::where('id', $empleado['id'])->get(['nombre'])->first();
        $empleadoName = $empleado->nombre;
        $tienda = AppTienda::where('id', $request->app_tienda_id)->get(['nombre'])->first();
        $tiendaName = $tienda->nombre;

        $dataMail = new DataMail;
        $dataMail ->fill([
          'userMail' => $userMail,
          'userName' => $userName,
          'petName' => $petName,
          'dateStart' => $dateStart,
          'dateEnd' => $dateEnd,
          'empleadoName' => $empleadoName,
          'tiendaName' => $tiendaName,
          'confirmada' => 'CONFIRMADA'
        ]);
        //Mail::to($userMail)->send(new NewPetDateMail($dataMail));
      }*/

      return response()->json(new AppEventoResource($saved_event), 200);
    //}
  }

  public function saveCitaApp(Request $request){
                
      /*// Busca si la mascota tiene cita en el dia o dias posteriores
        $recent_event = AppEvent::where('app_mascota_id', $request->app_mascota_id)
                                ->whereDate('start', '>=', Carbon::parse($request->fecha))
                                ->get()->first();
      // si existe id en request lo busca y lo borra
      */
      //calculamos manualmente la finalización de la cita
      $fecha_end = Carbon::parse($request->start)->addMinute(60)->format('Y-m-d H:i');
      
      if($request->id){
      $existing_event = AppEvent::find($request->id);
      $existing_event->delete();
      }
      //return response()->json("hola", 200);
      // Obtengo empleado
      $empleado = $this->getEmpleado(51);
      // Obtengo si la fecha es correcta
      $out_of_time = $this->isOutOfTime(8, $request->fecha, $request->start, $fecha_end);
      
      if(!$out_of_time){
        if(isset($existing_event)){
          $existing_event->restore();
        }
        return response()->json(['message' => 'fuera de horario'], 301);
      }
      // Obtengo horas de empleado
      $events = $empleado->event;
      $fit = $this->fitInTime($events, $request->start, $fecha_end);
      // Verifico si hay hora disponible
      if(!$fit){
        if(isset($existing_event)){
          $existing_event->restore();
        }
      return response()->json(['message' => 'hora no disponible en fit'], 301);
      }
      $event = new AppEvent();
      $event->fill([
      'app_empleado_id' => $empleado['id'],
      'app_usuario_id'  => $request->app_usuario_id,
      //'app_mascota_id'  => $request->app_mascota_id,
      'app_tienda_id'   => 8,
      'start'           => $request->start,
      'end'             => $fecha_end,
      'duracion'        => 60,
      'confirmada'      => 1
      ]);

      /*// Actualizamos las observaciones de usuario
      $usuario = AppUsuario::updateOrCreate(['id' => $request->app_usuario_id], ['observaciones' => $request->observacionesUsuario]);
      // Actualizamos las observaciones de la mascota
      $mascota = AppMascota::updateOrCreate(['id' => $request->app_mascota_id], ['observaciones' => $request->observaciones]);*/

      $tipo = Tipo::where('nombre', 'peluqueria')->get(['id'])->first();
      $saved_event = $tipo->event()->save($event);
      $servicios = /*$this->returnIds($request->servicios);*/41;
      $saved_event->servicio()->sync($servicios);
      //$historial = $this->guardarHistorial($servicios, $saved_event->app_mascota_id);
      return response()->json("Cita creada correctamente", 200);
    
  }

  private function guardarItemsHistorial($servicios, $app_mascota_id){
    foreach ($servicios as $key => $servicio) {
       AppHistorialMascota::create(['app_servicio_id' => $servicio, 'app_mascota_id' => $app_mascota_id]);
    }
    return true;
  }

  private function guardarHistorial($servicios, $app_mascota_id){
    $historial = AppHistorialMascota::where('app_mascota_id', $app_mascota_id)->get();
    if($historial->isEmpty()){
       return $this->guardarItemsHistorial($servicios, $app_mascota_id);
    }
    /*comparar*/
    $servicios_totales = collect($historial)->map(function($element){
      return $element['app_servicio_id'];
    });
    $concatenated = $servicios_totales->concat($servicios)->unique()->take(-3);
    $historial->each->delete();
    return $this->guardarItemsHistorial($concatenated, $app_mascota_id);
  }

  private function restoreEvent($existing_event){
    if(isset($existing_event)){
      return $existing_event->restore();
    }
  }

  private function fitInTime($events, $inicio_evento, $final_evento){
    if(count($events) == 0){
      return true;
    }
    foreach($events as $key => $evento) {
      $is_between = Carbon::parse($inicio_evento)->betweenExcluded($evento['start'], $evento['end']);
      $is_between_end = Carbon::parse($final_evento)->betweenExcluded($evento['start'], $evento['end']);
      $is_envolving = Carbon::parse($inicio_evento)->lessThanOrEqualTo(Carbon::parse($evento['start'])) && Carbon::parse($final_evento)->greaterThanOrEqualTo(Carbon::parse($evento['end']));
      if($is_between){
        return false;
      }
      if($is_between_end){
        return false;
      }
      if($is_envolving){
        return false;
      }
    }
    return true;
  }

  private function getEmpleado($empleado_id){
    return AppEmpleado::with('event')->where('id', $empleado_id)->get()->first();
  }

  private function isOutOfTime($app_tienda_id, $fecha, $start, $end){
    $numero_dia = AppHorarioTienda::where('app_tienda_id', $app_tienda_id)->where('dia', Carbon::parse($start)->dayOfWeek)->get()->first();
    $hora_inicio = Carbon::parse($fecha . " " . $numero_dia['start'])->format('Y-m-d H:i');
    $hora_final = Carbon::parse($fecha . " " . $numero_dia['end'])->format('Y-m-d H:i');
    return $numero_dia;
    if( Carbon::parse($start)->lessThan(Carbon::parse($hora_inicio)) || Carbon::parse($end)->greaterThan(Carbon::parse($hora_final)) ){
      return false;
    }
    return true;
  }

  private function returnIds($servicios){
    return collect($servicios)->map(function($element){
      return $element['id'];
    });
  }

  public function eliminarCita($evento_id, $causa)
  {
    $event = AppEvent::find($evento_id);
    $ticket = NroTicket::find($event->id_ticket);
    $venta = Venta::find($ticket->venta_id);
    $cliente = Cliente::find($event->app_usuario_id);
    $productos = array();
    $totales = [
      'descuento' => 0,
      'iva' => 0,
      'porcentaje_descuento' => 0,
      'sub_total' => 0,
      'tipo' => 'ticket',
      'total' => 0,
      'total_sin_descuento' => 0,
      ];
    
    foreach($venta->productos as $stock)
    {
      $producto = Stock::where('id', $stock->producto_id)->with('iva')->first();
      $i = ($producto->tipo_iva / 100) + 1;
      $suma = $producto->precio - ($producto->precio / $i);
      $totales['iva'] = $totales['iva'] + $suma;
      $totales['sub_total'] = $totales['sub_total'] + ($producto->precio / $i);
      
      $producto = $producto->toArray();
      $producto['numero'] = -1;
      $producto['total'] = (float) $producto['precio'] * -1;
      $producto['precio'] = (float) $producto['precio'] * -1;
      array_push($productos, $producto);
    }
    $totales['total'] = $totales['sub_total'] + $totales['iva'];
    $totales['total_sin_descuento'] = ($totales['sub_total'] + $totales['iva']);
    $totales['sub_total'] = (float) number_format($totales['sub_total'], 2) * -1;
    $totales['total'] = (float) number_format($totales['total'], 2) *-1;
    $totales['iva'] = number_format($totales['iva'], 2) *-1;
    $totales['total_sin_descuento'] = (float) number_format($totales['total'], 2);

    $data = [
      'cliente' => $cliente->toArray(),
      'productos' => $productos,
      'totales' => $totales
    ];
    $objetoRequest = new \Illuminate\Http\Request();
    $objetoRequest->setMethod('POST');
    $objetoRequest->request->add($data);

    $ticketController = new TicketApiController();
    $ticketController->generarVenta($objetoRequest, 'ticket');

    $event->cancelada = $causa;
    $event->save();

    $event->servicio()->detach();
    $event->delete();
    return response()->json('cita eliminada', 200);
  }
  
  public function saveCitaTicket($request)
  {

    $cliente = Cliente::find($request->app_usuario_id);
    $productos = array();
    $totales = [
      'descuento' => 0,
      'iva' => 0,
      'porcentaje_descuento' => 0,
      'sub_total' => 0,
      'tipo' => 'ticket',
      'total' => 0,
      'total_sin_descuento' => 0,
      ];


    foreach($request->servicios as $stock)
    {
      $producto = Stock::where('codigo', $stock['id'])->with('iva')->first();
      $i = ($producto->tipo_iva / 100) +1 ;
      $suma = $producto->precio - ($producto->precio / $i);
      $totales['iva'] = $totales['iva'] + $suma;
      $totales['sub_total'] = $totales['sub_total'] + ($producto->precio / $i);
      
      $producto = $producto->toArray();
      $producto['numero'] = 1;
      $producto['total'] = (float) $producto['precio'];
      array_push($productos, $producto);
    }

    $totales['total'] = $totales['sub_total'] + $totales['iva'];
    $totales['total_sin_descuento'] = $totales['sub_total'] + $totales['iva'];
    $totales['total'] = (float)  number_format($totales['total'], 2);
    $totales['sub_total'] = (float)  number_format($totales['sub_total'], 2);
    $totales['iva'] = (float)  number_format($totales['iva'], 2);
    $totales['total_sin_descuento'] = (float)  number_format($totales['total'], 2);

    $data = [
      'cliente' => $cliente->toArray(),
      'productos' => $productos,
      'totales' => $totales
    ];
    $objetoRequest = new \Illuminate\Http\Request();
    $objetoRequest->setMethod('POST');
    $objetoRequest->request->add($data);

    $ticketController = new TicketApiController();
    return $ticketController->generarVenta($objetoRequest, 'ticket');
  }

  public function saveCitaWeb(Request $request)
  {
    $cliente = Cliente::where('telefono', $request->cliente['telefono'])->first();
    if(empty($cliente))
    {
      $data = $request->cliente;
      $data['dni'] = 0;
      $cliente = Cliente::updateOrCreate(['id' => null], $data);
    }
    $cita = $request->cita;
    $cita['app_usuario_id'] = $cliente->id;
    $objetoRequest = new AgendaRequest();
    $objetoRequest->setMethod('POST');
    $objetoRequest->request->add($cita);
    $this->saveCita($objetoRequest);

    $empleado = AppEmpleado::where('id', $cita['app_empleado_id'])->get(['nombre'])->first();
    $tienda = AppTienda::where('id', $cita['app_tienda_id'])->get(['nombre'])->first();
    $cita['nombre_empleado'] = $empleado->nombre;
    $cita['nombre_tienda'] = $tienda->nombre;
    $cita['nombre_cliente'] = $cliente->nombre;
    // Mail para el cliente
    Mail::to($cliente->email)->send(new confirmCitaMail($cita));
    // Mail para el administrador
    $admin_mail='info@imperiovaron.com';
    Mail::to($admin_mail)->send(new confirmCitaAdminMail($cita));;
  }
}
