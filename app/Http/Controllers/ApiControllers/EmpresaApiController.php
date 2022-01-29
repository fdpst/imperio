<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Core\Contracts\Empresa;

class EmpresaApiController extends Controller
{
  public function getEmpresas(){
    return response()->json(Empresa::all(), 200);
  }

  public function getEmpresa($empresa_id){
    return response()->json(Empresa::with('factura')->where('id', $empresa_id)->get()->first(), 200);
  }

  public function saveEmpresa(Request $request){
    $cliente = Empresa::updateOrCreate(['id' => $request->id], $request->all());
    return response()->json($cliente, 200);
  }

  public function deleteEmpresa($empresa_id){
    return response()->json(Empresa::findOrFail($empresa_id)->delete(), 200);
  }
}
