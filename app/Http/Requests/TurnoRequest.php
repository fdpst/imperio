<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TurnoRequest extends FormRequest
{
  public function authorize(){
      return true;
  }

  public function rules()
  {
      return [
        'nombre' => 'required',
        'hora_inicio' => 'required',
        'hora_final' => 'required'
      ];
  }

  public function messages()
  {
      return [
        'nombre.required' => 'Nombre es obligatorio',
        'hora_inicio.required' => 'Hora Inicio es obligatorio',
        'hora_final.required' => 'Hora Final obligatorio'
      ];
  }
}
