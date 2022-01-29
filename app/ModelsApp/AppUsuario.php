<?php

namespace App\ModelsApp;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Carbon\Carbon;
use App\Models\Seccion;
use Storage;
use File;

class AppUsuario extends Authenticatable implements JWTSubject {

	use Notifiable;

	public function getJWTIdentifier(){
		 return $this->getKey();
	}

	public function getJWTCustomClaims(){
		 return [];
	}

	protected $table = 'app_usuario';

	protected $fillable = [
		'nombre',
		'apellidos',
		'email',
		'telefono',
		'observaciones',
		'avatar',
		'password',
		'profesion',
		'direccion',
		'antecedentes',
		'consulta',
		'tratamiento',
		'fecha_nacimiento',
		'alergias',
		'ejercicio'
 	];

	protected $appends = ['avatar_name', 'avatar_path'];

	protected $hidden = ['password'];

	/*public function setPasswordAttribute($password){
		 $this->attributes['password'] = bcrypt($password);
	}*/

	public function event(){
		return $this->hasMany(AppEvent::class);
	}

	public function mascota(){
		return $this->hasMany(AppMascota::class);
	}

	/*public function direccion(){
		return $this->hasMany(AppUsuarioDirecciones::class);
	}*/

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

	public function adopcion(){
		return $this->belongsTo(Adopcion::class);
	}

    // public function suscripciones(){
	// 	return $this->belongsToMany(AppSuscripcion::class, 'app_suscripciones', 'seccion_id', 'usuario_id');
	// }

    public function seccion(){
		return $this->belongsToMany(Seccion::class,'app_suscripciones','usuario_id', 'seccion_id');
	}
}
