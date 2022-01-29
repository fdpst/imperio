<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model {

	protected $table = 'evento';

	protected $fillable = ['cita_id', 'turno_id'];	

	public function cita(){
    $this->belongsTo(Cita::class)->lists('id');
	}

	public function scopeGetByDate($query, $fecha){
    return $query->whereDate('cita.fecha', $fecha);
	}
}
