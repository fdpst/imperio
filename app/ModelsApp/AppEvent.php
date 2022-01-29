<?php

namespace App\ModelsApp;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Core\Contracts\Cliente;

class AppEvent extends Model {

	use SoftDeletes;

	protected $table = 'app_event';

	protected $fillable = [
		  	'tipo_id',
			'app_empleado_id',
			'app_usuario_id',
			'app_mascota_id',
			'app_tienda_id',
			'start',
			'end',
		  	'duracion',
			'confirmada',
			'recogida',
			'direccion_recogida',
			'direccion_entrega',
			'pago',
			'precio',
			'id_ticket'
	];

	protected $appends = ['name', 'lista_nombre_servicios'];

	protected $dates = ['deleted_at', 'start', 'end'];

	public function tipo(){
		return $this->belongsTo(Tipo::class);
	}

	public function empleado(){
		return $this->belongsTo(AppEmpleado::class, 'app_empleado_id');
	}

	public function usuario(){
		return $this->belongsTo(Cliente::class, 'app_usuario_id');
	}

	public function mascota(){
		return $this->belongsTo(AppMascota::class, 'app_mascota_id');
	}

	public function tienda(){
		return $this->belongsTo(AppTienda::class, 'app_tienda_id');
	}

	public function getNameAttribute(){
		return $this->usuario ? $this->usuario->nombre : 'N/A';
	}

	public function servicio(){
    return $this->belongsToMany(AppServicio::class);
  }

	public function getListaNombreServiciosAttribute(){
	  return $this->servicio->pluck('nombre');
	}

	public function delete(){
		return parent::delete();
	}
}
