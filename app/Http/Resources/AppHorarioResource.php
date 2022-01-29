<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppHorarioResource extends JsonResource
{
    public function toArray($request)
    {
      return [
          'id'     => $this->id,
          'dia'    => $this->dia,
          'start'  => $this->start,
          'end'    => $this->end,
          'app_tienda_id' => $this->app_tienda_id
      ];
    }
}
