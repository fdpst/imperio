<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppEventoResource extends JsonResource
{
    public function toArray($request){
      return [
          'id'          => $this->id,
          'tipo_id'     => $this->tipo_id,
          'usuario'     => $this->usuario->nombre,
          'empleado'    => $this->empleado->nombre,
          'color'       => $this->empleado->color,
          'start'       => $this->start->format('Y-m-d H:i'),
          'end'         => $this->end->format('Y-m-d H:i'),
          'duracion'    => $this->duracion,
          'servicios'   => $this->servicio,
          'app_empleado_id' => $this->empleado->id,
          'app_mascota_id'  => $this->app_mascota_id,
          'app_usuario_id'  => $this->usuario->id,
          'confirmada'      => $this->confirmada
      ];
    }
}
