<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HorarioEmpleadoResource extends JsonResource
{
    public function toArray($request){
      return [
        'id'            => $this->id,
        'app_tienda_id' => $this->app_tienda_id,
        'nombre_tienda' => $this->tienda ? $this->tienda->nombre : 'N/A',
        'dia'           => (int) $this->dia,
        'entrada'       => $this->entrada,
        'salida'        => $this->salida
      ];
    }
}
