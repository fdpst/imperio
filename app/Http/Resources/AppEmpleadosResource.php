<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppEmpleadosResource extends JsonResource
{

    public function toArray($request)
    {
      return [
          'id'       => $this->id,
          'nombre'   => $this->nombre,
          'email'    => $this->email,
          'telefono' => $this->telefono,
          'tipo'     => $this->tipo ? $this->tipo->nombre : 'N/A'
      ];
    }
}
