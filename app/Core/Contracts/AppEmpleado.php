<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AppEmpleado extends Model {

	protected $table = 'app_empleado';

	protected $fillable = ['nombre', 'email', 'telefono', 'color', 'is_active', 'entrada', 'salida', 'tipo_id'];

	protected $appends = ['lista_vacaciones', 'lista_libres'];

	protected $dates = ['lista_vacaciones', 'lista_libres'];

	protected $casts = [
		'lista_vacaciones'  => 'date:Y-m-d',
		'lista_libres'  => 'date:Y-m-d'
	];

	public function tienda(){
		return $this->belongsToMany(AppTienda::class);
	}

	public function horario(){
		return $this->hasMany(HorarioAppEmpleado::class);
	}

	public function tipo(){
		return $this->belongsTo(Tipo::class);
	}

	public function event(){
		return $this->hasMany(AppEvent::class)->orderBy('start', 'ASC');
	}

	public function vacaciones(){
		return $this->hasMany(AppEmpleadoVacaciones::class);
	}

	public function fecha(){
		return $this->hasMany(FechaAppEmpleado::class);
	}

	public function getListaVacacionesAttribute(){
		return $this->vacaciones->where('tipo', 'V')->pluck('fecha');
	}

	public function getListaLibresAttribute(){
		return $this->vacaciones->where('tipo', 'L')->pluck('fecha');
	}

	public function scopeActivo($query, $fecha){
    return $query->whereDoesntHave('vacaciones', function($vacaciones_query) use ($fecha){
			 $vacaciones_query->where('fecha', Carbon::parse($fecha)->format('Y-m-d'));
		});
	}
}
