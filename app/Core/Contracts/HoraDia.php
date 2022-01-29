<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;

class HoraDia extends Model {

	protected $table = 'hora_dia';

	protected $fillable = ['dia', 'start', 'end', 'is_active'];

}
