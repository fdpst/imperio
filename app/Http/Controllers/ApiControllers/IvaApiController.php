<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Core\Contracts\Iva;

class IvaApiController extends Controller
{
  public function getIvas(){
    return response()->json(Iva::all(), 200);
  }

  public function saveIva(Request $request){
    $iva = Iva::updateOrCreate(['id' => $request->id], $request->all());
    return response()->json($iva, 200);
  }

}
