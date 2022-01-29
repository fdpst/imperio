<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class VentaTicket extends Model {

	protected $table = 'venta_nro_ticket';

	protected $fillable = ['venta_id', 'nro_ticket_id'];

	public function factura(){
		return $this->belongsTo(Venta::class);
	}

  public function is_on_factura(){
		return $this->belongsTo(NroTicket::class);
	}	
}
