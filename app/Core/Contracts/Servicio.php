<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model {

	protected $table = 'servicio';

	protected $fillable = ['nombre', 'precio', 'duracion', 'is_active'];

	/*public function agenda(){
		return $this->hasMany(CitaServicio::class);
	}

	public function tipo(){
		return $this->belongsTo(Tipo::class);
	}

	public function cita(){
		return $this->belongsToMany(Cita::class);
	}*/
}
