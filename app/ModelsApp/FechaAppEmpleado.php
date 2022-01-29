<?php

namespace App\ModelsApp;

use Illuminate\Database\Eloquent\Model;

class FechaAppEmpleado extends Model {

	protected $table = 'fecha_app_empleado';

	protected $fillable = ['app_empleado_id', 'fecha', 'entrada', 'salida', 'app_tienda_id'];

  public function empleado(){
    return $this->belongsTo(AppEmpleado::class, 'app_empleado_id');
  }

}
