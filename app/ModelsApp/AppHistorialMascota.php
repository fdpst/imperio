<?php

namespace App\ModelsApp;

use Illuminate\Database\Eloquent\Model;

class AppHistorialMascota extends Model {

	protected $table = 'app_historial_mascota';

	protected $fillable = ['app_mascota_id', 'app_servicio_id'];

	public function mascota(){
		return $this->belongsTo(AppMascota::class, 'app_mascota_id');
	}

	public function servicio(){
		return $this->belongsTo(AppServicio::class, 'app_servicio_id');
	}
}
