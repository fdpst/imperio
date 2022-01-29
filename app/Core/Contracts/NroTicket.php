<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class NroTicket extends Model {

	protected $table = 'nro_ticket';

	protected $fillable = ['venta_id'];

	protected $appends = ['fecha'];

	protected $casts = ['created_at'  => 'date:Y-m-d'];

	public function getFechaAttribute() {
  	return (new Carbon($this->created_at))->format('d-m-Y');
	}

	public function ticket(){
		return $this->belongsTo(Venta::class);
	}

	public function factura(){
		return $this->hasOne(VentaTicket::class);
	}

	public function delete(){
		$this->ticket()->delete();
    return parent::delete();
  }
}
