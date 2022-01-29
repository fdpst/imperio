<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Core\Contracts\AppServicio;
use App\Core\Contracts\Tipo;
use App\Core\Contracts\Stock;

class ServicioAppController extends Controller
{
  public function getServicioByTipo($nombre){
    $saved_tipo = Tipo::where('nombre', $nombre)->get()->first();
    $servicios = AppServicio::where('tipo_id', $saved_tipo->id)->get();
    return response()->json($servicios, 200);
  }

  public function getServicios(){
    return response()->json(AppServicio::with('tipo')->get(), 200);
  }

  public function getServicio($servicio_id){
    return response()->json(AppServicio::find($servicio_id), 200);
  }

  public function saveServicio(Request $request){
    //  Verificamos si es Update o Create del servicio
    $service_id = AppServicio::where('id', $request->id)->first();
    // Si Existe el servicio lo Updateamos y almacenamos en variable por si 
    // se necesita revertir los cambios por fallo al guardar en el Stock 
      if ($service_id) {
        $revert_data = $service_id;
        $stateService = 'update';
      }
      else
      {
        $stateService = 'new';
      }  
    // Creamos el servicio
    $servicio = AppServicio::updateOrCreate(['id' => $request->id], $request->except(['tipo']));
    $servicio->save();

    try {
      // Si el servicio se crea bien comprobamos Stock 
      $id = $servicio->id;
      $stock_id = Stock::where('codigo', $id)->first();
      // Updateo o creo Stock 
      if (!$stock_id){
        // creamos el stock desde el servicio creado
        $stock = Stock::create([
          'codigo'        => $servicio->id,
          'nombre'        => $servicio->nombre,
          'precio'        => $servicio->precio,
          'cantidad'      => 5000,
          'categoria_id'  => 5, 
          'iva_id'        => 1,
          'tipo_iva'      => 21,
        ]);
      }   
      else
      {
        //  Updateamos el ID existente
        $stock = Stock::updateOrCreate(['id' => $stock_id->id],
        ([
          'codigo'        => $servicio->id,
          'nombre'        => $servicio->nombre,
          'precio'        => $servicio->precio,
          'cantidad'      => 5000,
          'categoria_id'  => 5, 
          'iva_id'        => 1,
          'tipo_iva'      => 21,
        ]));
      }
    } 
    catch (\Illuminate\Database\QueryException $ex) {
        if ($stateService == 'new') {
          AppServicio::findOrFail($servicio->id)->delete();
          return response()->json(['delete' => $stateService, 'servicio' => $servicio], 400);
        }
        else
        {
          // si existe el servicio , revertimos los datos a los del estado inicial
          $servicio = AppServicio::updateOrCreate(['id' => $request->id],
          ([
            'nombre'        => $revert_data['nombre'],
            'precio'        => $revert_data['precio'],
            'duracion'      => $revert_data['duracion'],
            'is_active'     => $revert_data['is_active'],
            'tipo_id'       => $revert_data['tipo_id']
          ]));
          return response()->json(['update' => $stateService, 'revert_data' => $revert_data], 400);
        } 
      return response()->json(['error' => $ex],300);
    }  
    // Si todo sale bien mensaje ok  
    return response()->json(['was_created' => $servicio->wasRecentlyCreated, 'servicio' => $servicio->load('tipo')], 200);
  }

  public function deleteServicio($servicio_id){
    $id = $servicio_id;
    $stock_id = Stock::where('codigo', $id)->first();
    Stock::findOrFail($stock_id->id)->delete();
    return response()->json(AppServicio::findOrFail($servicio_id)->delete(), 200);
  }
}
