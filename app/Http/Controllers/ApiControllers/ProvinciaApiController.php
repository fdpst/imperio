<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Core\Contracts\Provincia;

class ProvinciaApiController extends Controller
{
  public function getProvincias(){
    return response()->json(Provincia::all(), 200);
  }
}
