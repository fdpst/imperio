<?php

namespace App\ModelsApp;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Tipo extends Model {

	protected $table = 'tipo';

	public function empleados(){
		return $this->hasMany(AppEmpleado::class);
	}

	public function event(){
		return $this->hasMany(AppEvent::class);
	}
}
