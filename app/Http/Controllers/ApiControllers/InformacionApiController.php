<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Core\Contracts\InformacionLegal;

class InformacionApiController extends Controller
{
  public function getInformacion(){
    return response()->json(InformacionLegal::get()->first(), 200);
  }

  public function saveInformacion(Request $request){
    $informacion = InformacionLegal::updateOrCreate(['id' => $request->id], $request->all());
    return response()->json($informacion, 200);
  }

}
