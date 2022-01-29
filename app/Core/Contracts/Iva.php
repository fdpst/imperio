<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;

class Iva extends Model {

	protected $table = 'iva';

	protected $fillable = ['iva'];

	public function stock(){
		return $this->hasMany(Stock::class);
	}

}
