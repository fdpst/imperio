<?php

namespace App\ModelsApp;

use Illuminate\Database\Eloquent\Model;

class AppServicioTipoMascota extends Model {

	protected $table = 'app_servicio_tipo_mascota';

	protected $fillable = ['id_servicio', 'id_tipo_mascota'];

	
}