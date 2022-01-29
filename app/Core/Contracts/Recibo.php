<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;

class Recibo extends Model {

	protected $table = 'recibo';

	protected $fillable = ['factura_id', 'numero_recibo', 'proveedor', 'detalle', 'fecha', 'monto'];

  protected $dates = ['fecha', 'created_at'];

	protected $casts = ['fecha'  => 'date:Y-m-d'];

	public function recibo_stock(){
    return $this->hasMany(ReciboStock::class);
  }

	public function factura(){
		return $this->belongsTo(Factura::class);
	}

}
