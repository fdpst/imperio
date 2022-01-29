<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EmpleadoVacaciones extends Model {

	protected $table = 'empleado_vacaciones';

	protected $fillable = ['empleado_id', 'fecha'];

	public function setFechaAttribute($fecha){
		 $this->attributes['fecha'] = Carbon::parse($fecha)->format('Y-m-d');
	}

	public function empleado(){
		return $this->belongsTo(Empleado::class);
	}
}
