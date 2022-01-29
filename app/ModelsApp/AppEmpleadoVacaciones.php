<?php

namespace App\ModelsApp;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AppEmpleadoVacaciones extends Model {

	protected $table = 'app_empleado_vacaciones';

	protected $fillable = ['app_empleado_id', 'fecha', 'tipo'];

	public function setFechaAttribute($fecha){
		 $this->attributes['fecha'] = Carbon::parse($fecha)->format('Y-m-d');
	}

	public function empleado(){
		return $this->belongsTo(AppEmpleado::class);
	}

}
