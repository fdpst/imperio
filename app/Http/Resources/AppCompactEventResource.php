<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppCompactEventResource extends JsonResource
{
    public function toArray($request){
      return [
          'id'           => $this->id,
          'usuario'      => $this->usuario->nombre,
          'start'        => $this->start->format('d-m-Y H:i'),
          'start_format' => $this->start->format('Y-m-d')
      ];
    }
}
