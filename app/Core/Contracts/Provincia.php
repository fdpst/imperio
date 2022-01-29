<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model {

	protected $table = 'provincia';

	protected $fillable = ['nombre'];

	public function cliente(){
		return $this->hasMany(Cliente::class);
	}
}
