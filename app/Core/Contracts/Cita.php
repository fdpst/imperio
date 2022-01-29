<?php

namespace App\Core\Contracts;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model {

	protected $table = 'cita';

	protected $fillable = ['tipo_id', 'empleado_id', 'cliente_id', 'fecha', 'precio', 'pagado', 'tiempo_real'];

	protected $dates = ['fecha'];

	protected $appends = ['lista_eventos', 'lista_nombre_servicios'];

	public function evento(){
		return $this->hasMany(Evento::class);
	}

	public function getListaEventosAttribute(){
		return $this->evento->pluck('turno_id');
	}

	public function getListaNombreServiciosAttribute(){
	  return $this->servicio->pluck('nombre');
	}

  public function cita_servicio(){
		return $this->hasMany(CitaServicio::class);
	}

	public function servicio(){
		return $this->belongsToMany(Servicio::class);
	}

	public function cita_stock(){
		return $this->hasMany(CitaStock::class);
	}

  public function tipo(){
    return $this->belongsTo(Tipo::class);
  }

	public function empleado(){
		return $this->belongsTo(Empleado::class);
	}

	public function cliente(){
		return $this->belongsTo(Cliente::class);
	}

	public function delete(){
		$this->evento()->delete();
    $this->cita_servicio()->delete();
		$this->cita_stock()->delete();
    return parent::delete();
  }
}
