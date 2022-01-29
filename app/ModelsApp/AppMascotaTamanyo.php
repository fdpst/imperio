<?php

namespace App\ModelsApp;

use Illuminate\Database\Eloquent\Model;

class AppMascotaTamanyo extends Model {

	protected $table = 'app_tamanyo_mascota';

	protected $fillable = ['nombre', 'peso'];

	
}