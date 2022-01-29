<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model {

	/*protected $table = 'factura';

	protected $fillable = ['cliente_id', 'sub_total', 'descuento', 'iva', 'total', 'url_factura'];

	protected $casts = ['created_at'  => 'date:Y-m-d'];

	protected $appends = ['nro_orden'];

	public function cliente(){
		return $this->belongsTo(Cliente::class);
	}

	public function productos(){
		return $this->hasMany(FacturaProducto::class);
	}

	function getNroOrdenAttribute(){
    return str_pad($this->id, 4, '0', STR_PAD_LEFT);
	}

	public function delete(){
		$this->productos()->delete();
    return parent::delete();
  }*/
}
