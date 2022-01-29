<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Core\Contracts\FacturaRecibida;
use App\Core\Contracts\Venta;
use Illuminate\Http\Request;
use Storage;

class FacturaEmitidaApiController extends Controller
{
  public function getFacturasEmitidas(){
    return response()->json(FacturaRecibida::orderBy('created_at', 'DESC')->get(), 200);
  }

  // Create Query get bill between date
  public function getFacturasfechas(Request $request){
    return response()->json(Venta::whereBetween('created_at', [$request->desde , $request->hasta])->with('cliente')->orderBy('created_at', 'DESC')->get(), 200);
  }
  // END Create Query get bill between date

  public function createFactura(Request $request){
    $factura = FacturaRecibida::updateOrCreate(['id' => $request->id], $request->all());
    return response()->json($factura, 200);
  }

  public function deleteFactura($factura_id){
    $factura = FacturaRecibida::findOrFail($factura_id);
    if(Storage::disk('facturas_recibidas')->exists($factura->url)){
       Storage::disk('facturas_recibidas')->delete($factura->url);
    }
    $factura->delete();
    return response()->json('factura eliminada', 200);
  }
}
