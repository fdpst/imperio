<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Empleado extends Model {

	protected $table = 'empleado';

	protected $fillable = ['nombre', 'email', 'telefono', 'is_active'];

	protected $appends = ['lista_vacaciones'];

	protected $dates = ['lista_vacaciones'];

	protected $casts = [
		'lista_vacaciones'  => 'date:Y-m-d',
	];

	public function vacaciones(){
		return $this->hasMany(EmpleadoVacaciones::class);
	}

	public function getListaVacacionesAttribute(){
		return $this->vacaciones->pluck('fecha');
	}

	public function delete(){
		$this->vacaciones()->delete();  
    return parent::delete();
  }
}
