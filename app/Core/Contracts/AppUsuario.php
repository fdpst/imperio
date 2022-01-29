<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Storage;
use File;

class AppUsuario extends Model {

	protected $table = 'app_usuario';

	protected $fillable = [
		'nombre',
		'apellidos',
		'email',
		'telefono',
		'codigo',
		'observaciones',
		'avatar'
 	];

	protected $appends = ['avatar_name', 'avatar_path'];

	public function event(){
		return $this->hasMany(AppEvent::class);
	}

	public function mascota(){
		return $this->hasMany(AppMascota::class);
	}

	public function getAvatarPathAttribute(){
		 return asset('storage/avatar_usuario/' . $this->avatar);
	}

	public function getAvatarNameAttribute(){
		return substr($this->avatar, strpos($this->avatar, '-') + 1);
	}

	public function setAvatarAttribute($imagen){
  	$imagen_valida = $this->createImageFromBase($imagen);

  	if (!$imagen_valida){
  		 return null;
  	}

    $nombre_imagen = 'avatar_' . uniqid() . '.' . $imagen_valida['extension'];

    $this->attributes['avatar'] = $nombre_imagen;

  	Storage::disk('avatar_usuario')->put($nombre_imagen, $imagen_valida['imagen']);
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
