<?php

namespace App\ModelsApp;

use Illuminate\Database\Eloquent\Model;

class AppHorarioTienda extends Model {

	protected $table = 'horario_app_tienda';

	protected $fillable = ['dia', 'app_tienda_id', 'start', 'end'];

}
