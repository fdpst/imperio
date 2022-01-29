<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;
use App\Core\Helpers\ImageBaseHelper;
use Storage;

class FacturaRecibida extends Model {

	protected $table = 'factura_recibida';

	protected $fillable = ['cliente', 'numero_factura','total', 'url'];

	protected $dates = ['created_at'];

	protected $casts = ['created_at'  => 'date:d-m-Y'];

	public function setUrlAttribute($img){
		$imagehelper = new ImageBaseHelper();
		$isvalid = $imagehelper->createImageFromBase($img);
		if (!$isvalid){
			 return null;
		}
		$this->attributes['url'] = $isvalid['filename'];
		Storage::disk('facturas_recibidas')->put($isvalid['filename'], $isvalid['image']);
	}
}
