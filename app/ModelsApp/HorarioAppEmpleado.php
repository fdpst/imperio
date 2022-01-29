<?php

namespace App\ModelsApp;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class HorarioAppEmpleado extends Model {

	protected $table = 'horario_app_empleado';

	protected $fillable = ['app_empleado_id', 'app_tienda_id', 'dia', 'entrada', 'salida'];

	protected $casts = [
    'dia' => 'integer',
	];

	public function empleado(){
		return $this->belongsTo(AppEmpleado::class, 'app_empleado_id');
	}

	public function tienda(){
		return $this->belongsTo(AppTienda::class, 'app_tienda_id');
	}
}
