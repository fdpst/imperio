<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeccionRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules()
    {
        return [
          'nombre' => 'required|max:50',
        ];
    }

    public function messages()
    {
        return [
          'nombre.required' => 'Nombre es obligatorio',        
        ];
    }
}
