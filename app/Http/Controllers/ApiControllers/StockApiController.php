<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Core\Contracts\Stock;

class StockApiController extends Controller
{
  public function getStocks(){
    return response()->json(Stock::all(), 200);
  }

  public function getStock($stock_id){
    return response()->json(Stock::find($stock_id), 200);
  }

  public function saveStock(Request $request){
    $stock = Stock::updateOrCreate(['id' => $request->id], $request->all());
    return response()->json(['was_created' => $stock->wasRecentlyCreated, 'stock' => $stock], 200);
  }

  public function deleteStock($stock_id){
    return response()->json(Stock::findOrFail($stock_id)->delete(), 200);
  }

}
