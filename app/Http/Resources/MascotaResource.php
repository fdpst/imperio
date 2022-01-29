<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MascotaResource extends JsonResource
{
  public function toArray($request){
    return [
      'id'             => $this->id,
      'nombre_usuario' => $this->usuario->nombre,
      'nombre_seccion' => $this->seccion->nombre,
      'nombre'         => $this->nombre
    ];
  }
}
