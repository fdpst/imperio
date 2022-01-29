<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Core\Helpers\FacturaCreator;
use App\Core\Contracts\NroFactura;
use App\Core\Contracts\NroTicket;
use App\Core\Contracts\Stock;
use App\Core\Contracts\Venta;
use App\Core\Contracts\VentaProducto;
use Illuminate\Http\Request;
use Storage;
use DB;
use PDF;

class FacturaApiController extends Controller
{
  public function getFacturas(){
    return response()->json(Venta::whereHas('nro_factura')->with('cliente')->orderBy('created_at', 'DESC')->take(50)->get(), 200);
  }

  public function getTickets(){
    return response()->json(Venta::whereHas('nro_ticket')->with('cliente')->orderBy('created_at', 'DESC')->take(50)->get(), 200);
  }

  public function getFactura($factura_id){
    return response()->json(Venta::where('id', $factura_id)->with('cliente', 'productos.producto')->get()->first(), 200);

  }

  public function crearFacturaFromTicket($ticket_id, $cliente_id){
    $nro_ticket = NroTicket::find($ticket_id);

    $nro_factura = NroFactura::updateOrcreate(['venta_id' => $nro_ticket['venta_id']]);

    $venta = Venta::find($nro_ticket['venta_id']);

    $factura_creator = new FacturaCreator();

    $lista_iva = $factura_creator->getIva($venta->productos->load('producto'), $venta->porcentaje_descuento);

    if($cliente_id != 'null'){
      $venta->cliente_id = $cliente_id;
    }

    $venta->save();

    $nombre_archivo = $factura_creator->generarFactura($venta->load('productos.producto', 'nro_factura', 'cliente'), $lista_iva);

    $venta->url_factura = $nombre_archivo;

    $venta->save();

    return response()->json(['ticket' => $venta->load('cliente'), 'nombre_archivo' => $nombre_archivo], 200);
  }

  private function getIva($productos, $porcentaje_descuento){
    $data = collect($productos);
    return $result = $data->groupBy('tipo_iva')
        ->map(function($group) use ($porcentaje_descuento){
           return $group->reduce(function($carry, $item) use ($porcentaje_descuento){

                $total = ($porcentaje_descuento > 0) ? ($item['total'] - (($item['total'] * $porcentaje_descuento) / 100)) : $item['total'];

                $iva = ($item['tipo_iva'] / 100) + 1;

                $sub_total = $total / $iva;

                $total_sin_iva = $carry['total_sin_iva'] + $sub_total;

                $total_otro = $total - $sub_total;

                $total_iva = $carry['total_iva'] + $total_otro;

                return [
                  'total_sin_iva' => number_format ((float) $total_sin_iva, 2),
                  'total_iva' =>  number_format ((float) $total_iva, 2)
                ];

           }, ['total_sin_iva' => 0, 'total_iva' => 0]);
    });
  }

  public function deleteFactura($venta_id){
    // Obtenemos Id de venta
    $venta = Venta::find($venta_id);
    // Obtenemos productos vendidos
    $ventaProducto = VentaProducto::where('venta_id' , $venta_id)->get()->all();
    // Verificamos que es factura
    if($venta->url_ticket != null || $venta->presupuesto != null){
      // Localizamos Venta
      $venta = Venta::find($venta_id);
      // Borramos la venta
      $venta->delete();
      return response()->json('factura eliminada', 200);
    }
    // Verificamos que existe PDF en el Disk
    $data = Storage::disk('facturas')->exists($venta->url_factura); 
    // Si existe PDF lo eliminamos
    if($data){
      Storage::disk('facturas')->delete($venta->url_factura);
		}
    // Eliminamos Factura y su numero en BD
    $venta->nro_factura()->delete();
    // Borramos venta
    $venta->delete();
    // Reponemos Stock de productos de venta eliminados
    foreach ($ventaProducto as $venta) {
      // obtengo los datos de cada linea de la venta
      // obtengo el dato del stock de producto en almacen
      $producto = Stock::where('id' , $venta->producto_id)->get()->first();
      // calculo la cantidad de stock sumando la venta
      $comprado = $venta->cantidad;
      $almacen = $producto->cantidad;
      $reponestock = ($comprado)+($almacen);
      // almaceno stock nuevo en almacen
      $stocktotal=  Stock::updateOrCreate(['id' => $venta->producto_id], ['cantidad' => $reponestock]);     
    }
    // Devolvemos mensaje de eliminacion
    return response()->json('factura eliminada', 200);
  }

  public function deleteTicket($venta_id){
    // Obtenemos Id de venta    
    $venta = Venta::find($venta_id); 
    // Obtenemos productos vendidos
    $ventaProducto = VentaProducto::where('venta_id' , $venta_id)->get()->all(); 
    // Verificamos que es factura
    if($venta->url_factura != null || $venta->url_presupuesto != null){
      // Localizamos Venta
      $venta = Venta::find($venta_id);
      // Borramos la venta
      $venta->delete();
      return response()->json('ticket eliminado', 200);
    }
    // Verificamos que existe PDF en el Disk
    $data = Storage::disk('tickets')->exists($venta->url_ticket);
    // Si existe PDF lo eliminamos
    if($data){
			 Storage::disk('tickets')->delete($venta->url_ticket);
		}
    // Eliminamos Ticket y su numero en BD
    $venta->nro_ticket()->delete();
    // Borramos venta
    $venta->delete();
    // Reponemos Stock de productos de venta eliminados
    foreach($ventaProducto as $venta) {
      // obtengo los datos de cada linea de la venta
      // obtengo el dato del stock de producto en almacen
      $producto = Stock::where('id' , $venta->producto_id)->get()->first();
      // calculo la cantidad de stock sumando la venta
      $comprado = $venta->cantidad;
      $almacen = $producto->cantidad;
      $reponestock = ($comprado)+($almacen);
      // almaceno stock nuevo en almacen
      $stocktotal=  Stock::updateOrCreate(['id' => $venta->producto_id], ['cantidad' => $reponestock]);      
    }
    // Devolvemos mensaje de eliminacion
    return response()->json('ticket eliminado', 200);
  }

  public function editarFactura(Request $request, $factura_id){
    DB::beginTransaction();
    try {
        $factura = Venta::find($factura_id);

        $nro_factura = NroFactura::updateOrcreate(['venta_id' => $factura['id']]);

        $factura->update($request->except(['cliente', 'productos']));

        $factura->productos()->delete();

        $productos = $this->generarProductos($request->productos);

        $factura->productos()->saveMany($productos);

        $factura->cliente_id = $request->cliente_id;

        $factura->save();

        $factura_creator = new FacturaCreator();

        $lista_iva = $factura_creator->getIva($factura->productos->load('producto'), $factura->porcentaje_descuento);

        $nombre_archivo = $factura_creator->generarFactura($factura->load('productos.producto', 'nro_factura', 'cliente'), $lista_iva);

        $factura->url_factura = $nombre_archivo;

        $factura->save();
        DB::commit();
        return response()->json($nombre_archivo, 200);
      }
      catch (Exception $exception) {
        DB::rollback();
        return response()->json('error', 301);
      }
      return response()->json('error', 500);
  }

  private function deleteProductosFromFactura($venta){
    return $venta->productos()->delete();
  }

  private function generarProductos($data){
     return collect($data)->map(function ($item, $key) {
       return new VentaProducto([
         'producto_id' => $item['producto_id'],
         'descripcion' => $item['descripcion'],
         'cantidad' => $item['cantidad'],
         'total' => $item['precio_unitario'] * $item['cantidad'],
       ]);
    });
  }

  public function generaInforme(Request $request,$desde,$hasta){
    $data = $request->all();    
    $pdf = PDF::loadView('pdf.reporte', compact('data','desde','hasta'));
    $file_name = uniqid() . '.pdf';
    Storage::disk('reportes')->put($file_name, $pdf->output());
    return $file_name;
  }
  
}