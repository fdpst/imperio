<?php

namespace App\Http\Controllers\ApiControllers;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Core\Contracts\Venta;
use App\Core\Contracts\NroFactura;
use App\Core\Contracts\NroTicket;
use App\Core\Contracts\VentaProducto;
use App\Core\Contracts\FacturaProducto;
use App\Core\Contracts\InformacionLegal;
use App\Core\Contracts\Stock;
use Illuminate\Http\Request;
use PDF;
use App;
use DB;

class TicketApiController extends Controller
{
  public function generarVenta(Request $request, $tipo){
    DB::beginTransaction();
    try {
          $factura = $this->guardarVenta($request->totales);

          $model = ($tipo == 'ticket') ? NroTicket::class : NroFactura::class;

          if($tipo != 'presupuesto'){
            $nro_venta = $this->guardarNro($factura['id'], $model);
          }

          $productos = $this->generarProductos($request->productos);

          $factura->productos()->saveMany($productos);

          $factura->cliente_id = $request->cliente ? $request->cliente['id'] : null;

          // Actualizamos stock en BD
          if ($tipo != 'presupuesto') {
            foreach ($productos as $producto) {
              $finalstock = $producto->producto->cantidad - $producto->cantidad;
              Stock::where(['id' => $producto->producto_id])->update(['cantidad' => $finalstock]);
            }
          }          

          $factura->save();
          if($producto->cantidad <= 0)
          {
            $iva = $this->getIvaNegativo($factura->productos->load('producto'), $factura['porcentaje_descuento']);
          }
          else
          {
            $iva = $this->getIva($factura->productos->load('producto'), $factura['porcentaje_descuento']);

          }

          if($tipo == 'ticket'){
             $nombre_archivo = $this->generarTicket($factura->load('productos.producto', 'nro_ticket', 'cliente'), $iva);
             $factura->url_ticket = $nombre_archivo;
          }

          if($tipo == 'factura'){
             $nombre_archivo = $this->generarFactura($factura->load('productos.producto', 'nro_factura', 'cliente'), $iva);
             $factura->url_factura = $nombre_archivo;
          }

          if($tipo == 'presupuesto'){
             $nombre_archivo = $this->generarPresupuesto($factura->load('productos.producto', 'nro_factura', 'cliente'), $iva);
             $factura->url_presupuesto = $nombre_archivo;
          }

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

  private function guardarVenta($data){
    return Venta::create($data);
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

  private function getIvaNegativo($productos, $porcentaje_descuento){
    $data = collect($productos);
    return $result = $data->groupBy('tipo_iva')
        ->map(function($group) use ($porcentaje_descuento){
           return $group->reduce(function($carry, $item) use ($porcentaje_descuento){

                $total = ($porcentaje_descuento > 0) ? ($item['total'] - (($item['total'] * $porcentaje_descuento) / 100)) : $item['total'];

                $iva = ($item['tipo_iva'] / 100) + 1;

                $sub_total = $total / $iva;

                $total_sin_iva = $carry['total_sin_iva'] + $sub_total;

                $total_sin_iva = $total_sin_iva*-1;

                $total_otro = $total - $sub_total;

                $total_iva = $carry['total_iva'] + $total_otro;
                $total_iva = $total_iva *-1;

                return [
                  'total_sin_iva' => number_format ((float) $total_sin_iva, 2),
                  'total_iva' =>  number_format ((float) $total_iva, 2)
                ];

           }, ['total_sin_iva' => 0, 'total_iva' => 0]);
    });
  }

  private function guardarNro($venta_id, $model){
    return $model::create(['venta_id' => $venta_id]);
  }

  private function generarTicket($factura, $iva){
    $legal = InformacionLegal::get()->first();

    $pdf = App::make('dompdf.wrapper');

    $pdf->loadView('pdf.ticket', compact('factura', 'legal', 'iva'));

    $dom_pdf = $pdf->getDomPDF();

    $pdf->setPaper([0, 0, 210, 800000]);

    $pdf->setOptions(['dpi' => 72]);

    $GLOBALS['bodyHeight'] = 0;

    $dom_pdf->setCallbacks([
        'myCallbacks' => [
            'event' => 'end_frame', 'f' => function ($infos) {
            $frame = $infos["frame"];
            if (strtolower($frame->get_node()->nodeName) === "body") {
                $padding_box = $frame->get_padding_box();
                $GLOBALS['bodyHeight'] += $padding_box['h'];
            }
         }
      ]
    ]);

    $dom_pdf->render();

    $new_pdf = PDF::loadView('pdf.ticket', compact('factura', 'legal', 'iva'));

    $new_pdf->setPaper([0, 0, 210, $GLOBALS['bodyHeight'] + 20]);

    $new_pdf->setOptions(['dpi' => 72]);

    $file_name = uniqid() . '.pdf';

    Storage::disk('tickets')->put($file_name, $new_pdf->output());

    return $file_name;
  }

  private function generarFactura($factura, $lista_iva){
    $legal = InformacionLegal::get()->first();
    $pdf = PDF::loadView('pdf.factura', compact('factura', 'legal', 'lista_iva'));
    $file_name = uniqid() . '.pdf';
    Storage::disk('facturas')->put($file_name, $pdf->output());
    return $file_name;
  }

  private function generarPresupuesto($factura){
    $legal = InformacionLegal::get()->first();
    $pdf = PDF::loadView('pdf.presupuesto', compact('factura', 'legal'));
    $file_name = uniqid() . '.pdf';
    Storage::disk('presupuestos')->put($file_name, $pdf->output());
    return $file_name;
  }

  private function generarProductos($data){
     return collect($data)->map(function ($item, $key) {
       return new VentaProducto([
         'producto_id' => $item['id'],
         'descripcion' => $item['nombre'],
         'cantidad' => $item['numero'],
         'total' => $item['total'] * $item['numero'],
       ]);
    });
  } 

}
