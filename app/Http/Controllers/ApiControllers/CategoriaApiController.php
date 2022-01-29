<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Core\Contracts\Categoria;
use App\Core\Contracts\Servicio;

class CategoriaApiController extends Controller
{
  public function getCategorias(){
    return response()->json(Categoria::all(), 200);
  }

  public function getCategoriaWithStock(){
    return response()->json(Categoria::with('stock')->get(), 200);
  }

  public function getServicioWithStock(){
    return response()->json(Categoria::with('servicio')->get(), 200);

  }

  public function getCategoria($categoria_id){
    return response()->json(Categoria::find($categoria_id), 200);
  }

  public function saveCategoria(Request $request){
    $categoria = Categoria::updateOrCreate(['id' => $request->id], $request->all());
    return response()->json(['was_created' => $categoria->wasRecentlyCreated, 'categoria' => $categoria], 200);
  }

  public function deleteCategoria($categoria_id){
    return response()->json(Categoria::findOrFail($categoria_id)->delete(), 200);
  }

}
