<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;
use App\Core\Helpers\ImageBaseHelper;
use Storage;

class Stock extends Model {

	protected $table = 'stock';

	protected $fillable = ['categoria_id', 'iva_id', 'codigo', 'nombre', 'preciopvd', 'preciopvdsiva', 
						   'precio', 'preciosiva', 'art_profit', 'cantidad', 'imagen_url'];

	protected $appends = ['total', 'numero', 'tipo_iva'];

	public function getTotalAttribute(){
			return 0;
	}

	public function getNumeroAttribute(){
			return 0;
	}

	public function getImagenUrlAttribute($value){
			return $value ? "archivos/productos/{$value}" : "archivos/productos/default_img.jpg";
	}

	public function getTipoIvaAttribute($value){
			return $this->iva ? $this->iva['iva'] : 21;
	}

	public function setImagenUrlAttribute($img){
		$imagehelper = new ImageBaseHelper();
		$isvalid = $imagehelper->createImageFromBase($img);
		if (!$isvalid){
			 return null;
		}
		$this->attributes['imagen_url'] = $isvalid['filename'];
		Storage::disk('productos')->put($isvalid['filename'], $isvalid['image']);
	}

	public function recibo_stock(){
		return $this->hasMany(ReciboStock::class);
	}

	public function categoria(){
		return $this->belongsTo(Categoria::class);
	}

	public function iva(){
		return $this->belongsTo(Iva::class);
	}

	public function venta_producto(){
		return $this->hasMany(ventaProducto::class);
	}

}
