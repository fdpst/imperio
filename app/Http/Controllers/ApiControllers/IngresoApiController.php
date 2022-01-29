<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Core\Contracts\Ingresos;

class IngresoApiController extends Controller
{
  public function getIngresos(){
    return response()->json(Ingresos::orderBy('created_at', 'DESC')->get(), 200);
  }

  public function saveIngreso(Request $request){
    $ingreso = Ingresos::create($request->all());
    return response()->json($ingreso, 200);
  }

}
