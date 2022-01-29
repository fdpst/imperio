<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;

class FacturaEmitida extends Model {

	protected $table = 'factura_emitida';

	protected $fillable = ['cliente_id', 'numero_factura', 'precio', 'retencion', 'total', 'url'];

	protected $dates = ['created_at'];

	protected $casts = ['created_at'  => 'date:d-m-Y'];

	public function cliente(){
		return $this->belongsTo(Cliente::class);
	}
}
