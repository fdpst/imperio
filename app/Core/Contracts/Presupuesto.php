<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model {

	protected $table = 'presupuesto';

	protected $fillable = ['cliente_id', 'total', 'url_presupuesto'];

	protected $casts = ['created_at'  => 'date:Y-m-d'];

}
