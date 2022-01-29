<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;
use Log;

class NroFactura extends Model {

	protected $table = 'nro_factura';

	protected $fillable = ['venta_id', 'nro_factura'];

	protected $casts = ['created_at'  => 'date:Y-m-d'];

	public function factura(){
		return $this->belongsTo(Venta::class);
	}

	public function setVentaIdAttribute($val){
		$contador = $this->get()->count();
		$this->attributes['nro_factura'] = $contador + 1;
		$this->attributes['venta_id'] = $val;
	}
}
