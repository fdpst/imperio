<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Core\Contracts\Tipo;

class TipoApiController extends Controller
{
  public function getTipos(){
    return response()->json(Tipo::all(), 200);
  }

}
