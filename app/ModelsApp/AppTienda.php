<?php

namespace App\ModelsApp;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AppTienda extends Model {

	protected $table = 'app_tienda';

	protected $fillable = ['nombre'];

	public $timestamps = false;

	public function empleado(){
		return $this->belongsToMany(AppEmpleado::class);
	}

	public function cita(){
		return $this->hasMany(AppEvent::class);
	}	
	public function adopcion(){
		return $this->hasMany(Adopcion::class);
	}
	public function horario(){
		return $this->hasMany(HorarioAppEmpleado::class);
	}
}
