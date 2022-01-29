<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules()
    {
        return [
          'old_password' => 'required',
          'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
          'old_password.required' => 'Contraseña antigua es obligatorio',
          'password.required' => 'Contraseña es obligatorio'
        ];
    }
}
