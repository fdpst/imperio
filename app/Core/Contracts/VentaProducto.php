<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;

class VentaProducto extends Model {

	protected $table = 'venta_producto';

	protected $fillable = ['venta_id', 'producto_id', 'descripcion', 'cantidad', 'total'];

	protected $casts = ['created_at'  => 'date:Y-m-d'];

	protected $appends = ['tipo_iva'];

	public function factura(){
		return $this->belongsTo(Venta::class);
	}

	public function producto(){
		return $this->belongsTo(Stock::class);
	}

	public function getTipoIvaAttribute($value){
			return $this->producto->iva ? (integer) $this->producto->iva['iva'] : 21;
	}
}
