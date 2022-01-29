<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CorsController extends Controller
{
  public function dummy(Request $request){
    return response()->json($request->all(), 200);
  }
}
