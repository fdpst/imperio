<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;

class CitaServicio extends Model {

	protected $table = 'cita_servicio';

	protected $fillable = ['cita_id', 'servicio_id'];

	public function cita(){
		return $this->belongsTo(Cita::class);
	}

	public function servicio(){
		return $this->belongsTo(Servicio::class);
	}
}
