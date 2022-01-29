<?php

namespace App\Core\Helpers;
use App\Core\Contracts\InformacionLegal;
use Storage;
use PDF;

class FacturaCreator {

	public function generarFactura($factura, $lista_iva){
    $legal = InformacionLegal::get()->first();
    $pdf = PDF::loadView('pdf.factura', compact('factura', 'legal', 'lista_iva'));
    $file_name = uniqid() . '.pdf';
    Storage::disk('facturas')->put($file_name, $pdf->output());
    return $file_name;
  }

	public function getIva($productos, $porcentaje_descuento){
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

}
