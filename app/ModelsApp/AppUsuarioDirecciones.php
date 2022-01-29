<?php
namespace App\ModelsApp;

use Illuminate\Database\Eloquent\Model;

class AppUsuarioDirecciones extends Model {

	protected $table = 'app_direccion_usuario';

	protected $fillable = ['app_usuario_id', 'nombre', 'direccion'];

	public function usuario(){
		return $this->belongsTo(AppUsuario::class, 'app_usuario_id');
	}
}