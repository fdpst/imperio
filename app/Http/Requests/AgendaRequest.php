<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgendaRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules()
    {
      return [
        'app_usuario_id' => 'required',
        'app_empleado_id' => 'required',
        'duracion'        => 'required',
        'servicios' => 'required',
      ];
    }
}
