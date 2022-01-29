<?php

namespace App\ModelsApp;

use Illuminate\Database\Eloquent\Model;

class AppServicioPelo extends Model {

	protected $table = 'app_servicio_pelo';

	protected $fillable = ['id_servicio', 'id_pelo'];

	
}