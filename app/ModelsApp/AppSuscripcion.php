<?php

namespace App\ModelsApp;

use Illuminate\Database\Eloquent\Model;
use App\Models\Seccion;
use App\ModelsApp\AppUsuario;

class AppSuscripcion extends Model
{

    protected $table = 'app_suscripciones';

	protected $fillable = ['usuario_id', 'seccion_id', 'status'];

    public function seccion(){
		return $this->belongsTo(Seccion::class);
	}

    public function usuario(){
		return $this->belongsToMany(AppUsuario::class);
	}
}
