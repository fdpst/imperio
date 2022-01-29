<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Core\Contracts\Factura;
use App\Core\Contracts\Cliente;
use Illuminate\Http\Request;

class PosApiController extends Controller
{
  public function getClienteByDni($dni){
    return response()->json(Cliente::where('dni', $dni)->get()->first(), 200);
  }

  public function saveFactura(Request $request){
    return $request->all();
  }
}
