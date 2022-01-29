<?php

namespace App\ModelsApp;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Storage;
use File;

class AppMascota extends Model {

	protected $table = 'app_mascota';

	protected $fillable = [
    	'app_usuario_id',
		'nombre',
		'fecha_nacimiento',
		'raza',
		'sexo',
		'tamanyo',
		'peso',
		'color',
		'adoptable',
    	'seccion_id',
		'imagen',
		'observaciones',
		'codigo',
		'pelo'
 	];

	protected $appends = ['imagen_path'];

	public function usuario(){
		return $this->belongsTo(AppUsuario::class, 'app_usuario_id');
	}

	public function cita(){
		return $this->hasMany(AppEvent::class);
	}

	public function historial(){
		return $this->hasMany(AppHistorialMascota::class);
	}

	public function seccion(){
		return $this->belongsTo('App\Models\Seccion');
	}

	public function getImagenPathAttribute(){
		 return  $this->imagen ? asset('storage/mascotas/' . $this->imagen) : asset('storage/mascotas/default.jpg');
	}

	public function setImagenAttribute($imagen){
  	$imagen_valida = $this->createImageFromBase($imagen);

  	if (!$imagen_valida){
  		 return null;
  	}

    $nombre_imagen = 'mascota_' . uniqid() . '.' . $imagen_valida['extension'];

    $this->attributes['imagen'] = $nombre_imagen;

  	Storage::disk('mascotas')->put($nombre_imagen, $imagen_valida['imagen']);
	}

	public function createImageFromBase($img){
			if (!$this->isBase64($img)){
			return false;
			}
			$parts = explode(',', $img);

			$imagen = base64_decode($parts[1]);

			return ['extension' => $this->getExtension($parts[0]), 'imagen' => $imagen];
	}

	private function getExtension($data){
			return explode('/', explode(':', substr($data, 0, strpos($data, ';')))[1])[1];
	}

	private function isBase64($a){
		return strpos($a, 'base64') !== false;
	}

	public function adopcion(){
		return $this->hasMany(Adopcion::class);
	}
}
