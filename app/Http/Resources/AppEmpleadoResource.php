<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\HorarioEmpleadoResource;

class AppEmpleadoResource extends JsonResource
{
    public function toArray($request){
      return [
          'id'       => $this->id,
          'nombre'   => $this->nombre,
          'email'    => $this->email,
          'telefono' => $this->telefono,
          'color'    => $this->color,
          'tipo_id'  => $this->tipo_id,
          'vacaciones'   => $this->vacaciones,
          'fechas'       => $this->fecha,
          'horario'      => HorarioEmpleadoResource::collection($this->horario),
          'tienda'       => $this->tienda->pluck('id'),
          'lista_libres' => $this->vacaciones->where('tipo', 'L')->pluck('fecha')
      ];
    }
}
