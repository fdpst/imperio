<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;

class CitaStock extends Model {

	protected $table = 'cita_stock';

	protected $fillable = ['cita_id', 'stock_id', 'cantidad'];

	public function cita(){
		return $this->belongsTo(Cita::class);
	}

	public function stock(){
		return $this->belongsTo(Stock::class);
	}
}
