<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AppTienda extends Model {

	protected $table = 'app_tienda';

	protected $fillable = ['nombre'];

	public $timestamps = false;

	public function empleado(){
		return $this->belongsToMany(AppEmpleado::class);
	}
}
