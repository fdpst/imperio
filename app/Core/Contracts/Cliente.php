<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model {

	protected $table = 'cliente';

	protected $fillable = ['nombre', 'telefono', 'email', 'dni', 'direccion', 'provincia_id', 'codigo_postal', 'localidad'];

	protected $dates = ['fecha_nacimiento'];

	protected $casts = ['fecha_nacimiento'  => 'date:Y-m-d'];

	public function cita(){
		return $this->hasMany(Cita::class)->orderBy('created_at', 'DESC')->take(5);
	}

	public function provincia(){
		return $this->belongsTo(Provincia::class);
	}

	public function venta(){
		return $this->hasMany(Venta::class);
	}

}
