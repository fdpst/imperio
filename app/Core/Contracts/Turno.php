<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model {

	protected $table = 'turno';

	protected $fillable = ['index', 'start', 'end'];

}
