<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Core\Contracts\Cliente;

class ClienteApiController extends Controller
{
  public function getClientes(){
    return response()->json(Cliente::all(), 200);
  }

  public function getCliente($cliente_id){
    return response()->json(Cliente::where('id', $cliente_id)->get()->first(), 200);
  }

  public function saveCliente(Request $request){
    $cliente = Cliente::updateOrCreate(['id' => $request->id], $request->all());
    return response()->json($cliente, 200);
  }

  public function deleteCliente($cliente_id){
    return response()->json(Cliente::findOrFail($cliente_id)->delete(), 200);
  }

}
