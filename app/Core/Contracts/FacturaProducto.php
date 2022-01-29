<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;

class FacturaProducto extends Model {

	protected $table = 'factura_producto';

	protected $fillable = ['factura_id', 'producto_id', 'descripcion', 'cantidad', 'total'];

	protected $casts = ['created_at'  => 'date:Y-m-d'];

	public function factura(){
		return $this->belongsTo(Factura::class);
	}

	public function producto(){
		return $this->belongsTo(Stock::class);
	}
}
