<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model {

	protected $table = 'tipo';

	public function empleados(){
		return $this->hasMany(AppEmpleado::class);
	}

	public function event(){
		return $this->hasMany(AppEvent::class);
	}
}
