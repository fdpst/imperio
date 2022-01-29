<?php

namespace App\ModelsApp;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Storage;
use File;

class AppUsuariosArchivos extends Model {

	protected $table = 'app_usuarios_archivos';

	protected $fillable = [
    	'id_usuario',
		'tipo_archivo',
		'url',
		'filename',
	];

	protected $appends = ['imagen_path'];

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

	
}
