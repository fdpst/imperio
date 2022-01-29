<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;
use App\Core\Helpers\ImageBaseHelper;
use Storage;

class Categoria extends Model {

	protected $table = 'categoria';

	protected $fillable = ['nombre', 'orden', 'cat_profit', 'imagen_url'];

  public function getImagenUrlAttribute($value){
    return $value ? "archivos/categoria/{$value}" : "archivos/productos/default_img.jpg";
  }

	public function stock(){
		return $this->hasMany(Stock::class)->orderBy('created_at', 'DESC');
	}

	public function servicio(){
		return $this->hasMany(Servicio::class)->orderBy('created_at', 'DESC');
	}

	public function setImagenUrlAttribute($img){
		$imagehelper = new ImageBaseHelper();
		$isvalid = $imagehelper->createImageFromBase($img);
		if (!$isvalid){
			 return null;
		}
		$this->attributes['imagen_url'] = $isvalid['filename'];
		Storage::disk('categoria')->put($isvalid['filename'], $isvalid['image']);
	}

}
