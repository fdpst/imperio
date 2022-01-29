<?php

namespace App\ModelsApp;

use Illuminate\Database\Eloquent\Model;

class AppServicioTamanyo extends Model {

	protected $table = 'app_servicio_tamanyo';

	protected $fillable = ['id_servicio', 'id_tamanyo'];

	
}