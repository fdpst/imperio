<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model {

	protected $table = 'venta';

	protected $fillable = ['cliente_id', 'total_sin_descuento', 'sub_total', 'descuento', 'porcentaje_descuento', 'iva', 'total', 'url_factura', 'url_ticket', 'url_presupuesto'];

	protected $appends = ['nro_t', 'nro_f'];

	protected $casts = ['created_at'  => 'date:Y-m-d'];

	public function cliente(){
		return $this->belongsTo(Cliente::class);
	}

	public function nro_factura(){
		return $this->hasOne(NroFactura::class);
	}

	public function nro_ticket(){
		return $this->hasOne(NroTicket::class);
	}

	function getNroTAttribute(){
		return $this->nro_ticket != null ? str_pad($this->nro_ticket['id'], 4, '0', STR_PAD_LEFT) : null;
	}

	function getNroFAttribute(){
		return $this->nro_factura != null ? str_pad($this->nro_factura['nro_factura'], 4, '0', STR_PAD_LEFT) : null;
	}

	public function setPorcentajeDescuentoAttribute($value){
		return $this->attributes['porcentaje_descuento'] = $value == null ? 0 : $value;
	}

	public function productos(){
		return $this->hasMany(VentaProducto::class);
	}

	public function tickets(){
		return $this->hasMany(VentaTicket::class);
	}

	public function delete(){
		$this->productos()->delete();
    	return parent::delete();
  	}
}
