<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Core\Contracts\Venta;
use Storage;

class PresupuestoApiController extends Controller
{
  public function getPresupuestos(){
    return response()->json(Venta::with('productos.producto')->whereNotNull('url_presupuesto')->orderBy('created_at', 'DESC')->take(50)->get(), 200);
  }

  public function deletePresupuesto($presupuesto_id){
    $presupuesto = Venta::find($presupuesto_id);

    if(Storage::disk('presupuestos')->exists($presupuesto->url_presupuesto)){
       Storage::disk('presupuestos')->delete($presupuesto->url_presupuesto);
    }

    if($presupuesto->url_ticket == null && $presupuesto->url_factura == null){
       $presupuesto->delete();
       return response()->json('se puede eliminar', 200);
    }

    $presupuesto->url_presupuesto = null;
    $presupuesto->save();
    return response()->json('presupuesto eliminado', 200);
  }
}
