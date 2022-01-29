<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model {

	protected $table = 'empresa';

	protected $fillable = ['nombre', 'cif', 'direccion', 'telefono'];

	public function factura(){
		return $this->hasMany(Factura::class);
	}

}
