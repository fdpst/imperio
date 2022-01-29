<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;

class Ingresos extends Model {

	protected $table = 'ingresos';

	protected $fillable = ['cita_id', 'concepto', 'codigo', 'total'];

  protected $dates = ['created_at'];

	public function cita(){
		return $this->belongsTo(Cliente::class);
	}
}
