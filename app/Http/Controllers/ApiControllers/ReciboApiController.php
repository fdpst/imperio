<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Core\Contracts\ReciboStock;
use App\Core\Contracts\Recibo;
use App\Core\Contracts\Stock;
use Illuminate\Http\Request;

class ReciboApiController extends Controller
{

  public function getRecibosWithoutFactura(){
    return response()->json(Recibo::all(), 200);
    //return response()->json(Recibo::whereDoesntHave('factura')->get(), 200);
  }

  public function getRecibos(){
    return response()->json(Recibo::all(), 200);
  }

  public function getRecibo($recibo_id){
    $recibo = Recibo::with('recibo_stock', 'recibo_stock.stock')->where('id', $recibo_id)->get()->first();
    return response()->json($recibo, 200);
  }

  public function saveRecibo(Request $request){
    $recibo = Recibo::updateOrCreate(['id' => $request->id], $request->only(['numero_recibo', 'proveedor', 'fecha', 'monto']));

    foreach ($request->recibo_stock as $stock) {
      if(empty($stock['id'])){
        $recibo->recibo_stock()->create([
          'stock_id' => $stock['stock']['id'],
          'cantidad' => $stock['cantidad'],
          'precio'   => $stock['precio']
        ]);

        $stock_saved = Stock::find($stock['stock']['id']);
        $stock_saved->cantidad = $stock_saved->cantidad + $stock['cantidad'];
        $stock_saved->save();
      }
    }
    return response()->json($recibo->load('recibo_stock'), 200);
  }

  public function deleteRecibo($recibo_id){
    $recibo = Recibo::with('recibo_stock')->where('id', $recibo_id)->get()->first();

    foreach ($recibo->recibo_stock as $stock) {

      $stock_saved = Stock::find($stock['stock_id']);
      $stock_saved->cantidad = $stock_saved->cantidad - $stock['cantidad'];
      $stock_saved->save();
      $stock->delete();

    }
    $recibo->delete();
    return response()->json('recibo eliminado', 200);
  }

  public function deleteReciboStock(Request $request){
    $recibo_stock = ReciboStock::find($request->id);
    $stock_saved = Stock::find($request->stock_id);
    $stock_saved->cantidad = $stock_saved->cantidad - $recibo_stock->cantidad;
    $stock_saved->save();
    $recibo_stock->delete();
    return response()->json('producto eliminado', 200);
  }
}
