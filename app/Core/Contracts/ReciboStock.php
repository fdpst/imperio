<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;

class ReciboStock extends Model {

	protected $table = 'recibo_stock';

	protected $fillable = ['recibo_id', 'stock_id', 'cantidad', 'precio'];

  protected $dates = ['created_at'];

  public function recibo(){
    return $this->belongsTo(Recibo::class);
  }

  public function stock(){
    return $this->belongsTo(Stock::class);
  }
}
