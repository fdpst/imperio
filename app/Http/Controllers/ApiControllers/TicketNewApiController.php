<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Core\Contracts\Cliente;
use App\Core\Contracts\Venta;
use App\Core\Contracts\VentaTicket;
use App\Core\Contracts\NroTicket;
use App\Core\Contracts\NroFactura;
use App\Core\Contracts\VentaProducto;
use App\Core\Contracts\InformacionLegal;
use App\Core\Helpers\FacturaCreator;
use PDF;
use App;
use DB;

class TicketNewApiController extends Controller
{
  public function getTickets($cliente_id){
    $tickets = Venta::where('cliente_id', $cliente_id)->whereNull('url_factura')->whereNull('url_presupuesto')->whereDoesntHave('nro_ticket.factura')->get();
    return response()->json($tickets, 200);
  }

  public function crearFactura(Request $request){
    $ids = $request->all();

    $tickets = Venta::with('productos', 'nro_ticket')->whereIn('id', $ids)->get();

    $venta = $this->sumarTickets($tickets);

    $venta_saved = $this->guardarVenta($venta, $tickets[0]['cliente_id']);

    $productos = $this->flatProductos($tickets);

    $this->saveProductosNewFactura($venta_saved['id'], $productos);

    $factura_creator = new FacturaCreator();

    $lista_iva = $factura_creator->getIva($venta_saved->productos->load('producto'), $venta_saved->porcentaje_descuento);

    $nombre_archivo = $factura_creator->generarFactura($venta_saved->load('productos.producto', 'nro_factura', 'cliente'), $lista_iva);

    $venta_saved->url_factura = $nombre_archivo;

    $venta_saved->save();

    $this->saveToTickets($venta_saved['id'], $tickets);

    return response()->json($nombre_archivo, 200);
  }

  private function saveToTickets($venta_saved_id, $tickets){
    foreach ($tickets as $key => $value) {
      VentaTicket::updateOrCreate([
        'venta_id' => $venta_saved_id, 'nro_ticket_id' => $value['nro_ticket']['id']
      ],
      [
        'venta_id' => $venta_saved_id, 'nro_ticket_id' => $value['nro_ticket']['id']
      ]);
    }
  }

  private function guardarVenta($data, $cliente_id){
    $venta = new Venta();

    $venta->fill($data);

    $venta->cliente_id = $cliente_id;

    $venta->save();

    $nro_factura = NroFactura::create(['venta_id' => $venta['id']]);

    $venta->nro_factura()->save($nro_factura);

    return $venta->load('nro_factura');
  }

  private function flatProductos($data){
    return $flattened = collect($data)->flatMap(function ($values) {
      return $values['productos'];
    });
  }

  private function sumProductos($productos){
    return $productos->groupBy('producto_id')->map(function($group){
          return $group->reduce(function($carry, $item){
                  return[
                    'producto_id' => $item['producto_id'],
                    'descripcion' => $item['descripcion'],
                    'cantidad' => $carry['cantidad'] + $item['cantidad'],
                    'total' => $carry['total'] + $item['total']
                  ];
          }, ['producto_id' => 0, 'descripcion' => null, 'cantidad' => 0, 'total' => 0]);
      });
  }

  private function saveProductosNewFactura($factura_id, $productos){
    $results = $this->sumProductos($productos);

    foreach ($results as $key => $producto) {
      VentaProducto::create([
        'venta_id' => $factura_id,
        'producto_id' => $producto['producto_id'],
        'descripcion' => $producto['descripcion'],
        'cantidad' => $producto['cantidad'],
        'total' => $producto['total']
      ]);
    }

  }

  private function sumarTickets($data){

    $item = collect($data)->reduce(function ($carry, $item) {
        return [
          'total_sin_descuento' => $carry['total_sin_descuento'] + $item['total_sin_descuento'],
          'sub_total' => $carry['sub_total'] + $item['sub_total'],
          'descuento' => $carry['descuento'] + $item['descuento'],
          'porcentaje_descuento' => $carry['porcentaje_descuento'] + $item['porcentaje_descuento'],
          'iva' => $carry['iva'] + $item['iva'],
          'total' => $carry['total'] + $item['total']
        ];
    },['total_sin_descuento' => 0, 'sub_total' => 0, 'descuento' => 0, 'porcentaje_descuento' => 0, 'iva' => 0, 'total' => 0]);


    if($item['descuento'] > 0){
      $descuento = ($item['descuento'] * 100) / $item['total_sin_descuento'];

      $item['porcentaje_descuento'] = number_format ((float) $descuento, 2);

      $item['descuento'] =  $item['total_sin_descuento'] - $item['descuento'];
    }

    return $item;
  }
}
