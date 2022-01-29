<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Core\Contracts\NroFactura;
use App\Core\Contracts\NroTicket;
use App\Core\Contracts\Stock;
use App\Core\Contracts\Venta;
use App\Core\Contracts\VentaProducto;
use App\Core\Contracts\AppServicio;
use Illuminate\Http\Request;
use DB;


class EstadisticaApiController extends Controller
  {

  public function getData($desde, $hasta){
      return response()->json(DB::table('venta')
                      ->where('url_ticket', '=', null)
                      ->orWhere('url_factura', '=', null)
                      ->orWhere('url_factura', '<>', null and 'url_ticket', '<>', null)
                      ->whereBetween('created_at', [$desde, $hasta])
                      ->get(), 200);
  }

  public function getVentasTotales($desde, $hasta){
    $ventas = (DB::table('venta')
                  ->where('url_ticket', '=', null)
                  ->orWhere('url_factura', '=', null)
                  ->orWhere('url_factura', '<>', null and 'url_ticket', '<>', null)
                  ->whereBetween('created_at', [$desde, $hasta])
                  ->get());

    $totMes[]=[];
    for ($i=0; $i <12 ; $i++) { 
      $totMes[$i]=0;
    }

    $tovMesTottMes[]=[];
    for ($i=0; $i <12 ; $i++) { 
      $vMesTot[$i]=0;
    }

    foreach ($ventas as $key => $venta) {
      $fecha = $venta -> created_at;
      $fechaInt = strtotime($fecha);
      $mes = (int)(date("m", $fechaInt));

      $totMes[$mes-1] = $totMes[$mes-1] + $venta->total;
    }

    for ($i=0; $i < 12 ; $i++) { 
      $vMesTot[$i]= ['TotalVenta' => $totMes[$i]];
    }
    return response()->json(($vMesTot),200);
  }

  public function getVentaData($desde, $hasta){

    $serviciosId = (DB::table('app_servicio')->select('app_servicio.id as IDServicio')->get());

    $VentaData = (DB::table('venta as venta')
                   ->select('venta.id as IDVenta',
                           'venta.created_at as FechaVenta',
                           'stock.codigo as CodigoArticulo',
                           'ventaproducto.producto_id as IdArticulo',
                           'ventaproducto.total as PvpArticulo',
                           'venta.porcentaje_descuento as Descuento',
                           'ventaproducto.cantidad as Cantidad',
                           'venta.total as TotalVenta')
                    ->join('venta_producto as ventaproducto', 'ventaproducto.venta_id', '=', 'venta.id')
                    ->join('stock as stock', 'stock.id', '=', 'ventaproducto.producto_id')
                    ->whereBetween('venta.created_at', [$desde, $hasta])
                    ->get());

    $totMesProductos[]=[];$totMesServicios[]=[];
    $totalProductos[]=[];$totalServicios[]=[];
    $totalVentasP[]=[];$totalVentasS[]=[];
    for ($i=0; $i <12 ; $i++) { 
      $totMesProductos[$i]=0; 
      $totMesServicios[$i]=0;
      $totalProductos[$i]=0;
      $totalServicios[$i]=0;
      $totalVentasP[$i]=0;
      $totalVentasS[$i]=0;
    }

    // Totales separados por servicio y producto
    foreach ($VentaData as $key => $venta) {
      // Obtenemos los meses
      $fecha = $venta -> FechaVenta;
      $fechaInt = strtotime($fecha);
      $mes = (int)(date("m", $fechaInt));

      // Obtenemos si es servicio o producto
      $producto = true;
      foreach ($serviciosId as $key => $servicio) {
        if($venta->CodigoArticulo == $servicio->IDServicio){
          $producto = false;          
        }

      }
      // Segun sea servicio o producto calculamos totales por mes , numero y grantotal

      if ($producto) {
        $totMesProductos[$mes-1] = $totMesProductos[$mes-1] + ( ( $venta->PvpArticulo ) - (( $venta->PvpArticulo * $venta->Descuento )/100 ) ) / $venta->Cantidad;
        // N Productos vendidos
        $totalProductos[$mes-1] = ($totalProductos[$mes-1]) + $venta->Cantidad;
      }
      else
      {
        $totMesServicios[$mes-1] = $totMesServicios[$mes-1] + ( ( $venta->PvpArticulo ) - (( $venta->PvpArticulo * $venta->Descuento )/100 ) ) / $venta->Cantidad;
        // N Servicios vendidos
        $totalServicios[$mes-1] = ($totalServicios[$mes-1]) + $venta->Cantidad;
      }    
    }

    for ($i=0; $i < 12 ; $i++) { 
      $labels = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio',
                         'Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
      $estadisticaTotales[$i] = [
        'Mes' => $labels[$i],
        'TotalArticulos' => $totalProductos[$i] + $totalServicios[$i],
        'NumP' => $totalProductos[$i],
        'TotalVentaP' => $totMesProductos[$i],
        'NumS' => $totalServicios[$i],
        'TotalVentaS' => $totMesServicios[$i], 
        'Total' => $totMesProductos[$i] + $totMesServicios[$i],
      ];
    } 
    return response()->json(($estadisticaTotales),200);
  }
  
  public function getProductData($desde, $hasta){
    // Obtenemos las Id de servicios
    $serviciosId = (DB::table('app_servicio')->select('app_servicio.id as IDServicio')->get());
    // Obtenemos stock
    $stock = (DB::table('stock')->select('stock.id as IDstock', 'stock.nombre as Nombre', 'stock.codigo as Codigo')->get());
    // Obtenemos ProductData
    $ProductData = (DB::table('venta as venta')
                   ->select(
                            'venta.id as IDVenta',
                            'venta.created_at as FechaVenta',
                            'ventaproducto.producto_id as IdArticulo',
                            'stock.codigo as CodigoArticulo',
                            'stock.categoria_id as CategoriaId',
                            'categoria.nombre as CategoriaNombre',
                            'ventaproducto.cantidad as Cantidad',
                            'venta.porcentaje_descuento as Descuento',
                            'ventaproducto.total as PvpArticulo',
                            'venta.total as TotalVenta'
                           )
                    ->join('venta_producto as ventaproducto', 'ventaproducto.venta_id', '=', 'venta.id')
                    ->join('stock as stock', 'stock.id', '=', 'ventaproducto.producto_id')
                    ->join('categoria as categoria', 'categoria.id', '=', 'stock.categoria_id')
                    ->whereBetween('venta.created_at', [$desde, $hasta])
                    ->orderBy('venta.id', 'asc')
                    ->get());

    // Obtenemos si es servicio o producto
    foreach ($stock as $key => $stockP) {
      $producto = true;
      foreach ($serviciosId as $key => $servicio) {
        if($stockP->Codigo == $servicio->IDServicio){
          $producto = false;   
        }
      }      
      if ($producto) {
        $productosCan[$stockP->IDstock] = 0;
        $productosTot[$stockP->IDstock] = 0;
      }       
    }    

    foreach ($ProductData as $key => $venta) {
      // Obtenemos si es servicio o producto en las ventas
      $producto = true;
      foreach ($serviciosId as $key => $servicio) {
        if($venta->CodigoArticulo == $servicio->IDServicio){
          $producto = false;          
        }
      }    
      // Segun sea servicio o producto calculamos totales por mes , numero
      if ($producto) {        
        // Total ventas Productos
        $productosTot[$venta->IdArticulo] = $productosTot[$venta->IdArticulo] + ( ( $venta->PvpArticulo ) - (( $venta->PvpArticulo * $venta->Descuento )/100 ) ) / $venta->Cantidad;
        // Productos
        $productosCan[$venta->IdArticulo] = ($productosCan[$venta->IdArticulo]) + $venta->Cantidad;
      }    
    }   

    $cont = 0;
    foreach ($stock as $key => $stockP) {
      $producto = true;
      foreach ($serviciosId as $key => $servicio) {
        if($stockP->Codigo == $servicio->IDServicio){
          $producto = false;          
        }
      }      
      if ($producto) { 
        if ($productosTot[$stockP->IDstock] != 0) {
          $estadisticaProductos[$cont] = [
            'NombreProducto' => $stockP->Nombre,
            'CantidadProducto' => $productosCan[$stockP->IDstock],
            'TotalVentaProducto' => $productosTot[$stockP->IDstock]
          ];
          $cont ++;
        }
      }
    } 

    return response()->json($estadisticaProductos,200);
  }

  public function getCategoData($desde, $hasta){
    // Obtenemos las Id de servicios
    $serviciosId = (DB::table('app_servicio')->select('app_servicio.id as IDServicio')->get());
    // Obtenemos las categoria
    $categoria = (DB::table('categoria')->select('categoria.id as IDCategoria', 'categoria.nombre as Nombre')->get());

    $ProductData = (DB::table('venta as venta')
                   ->select(
                            'venta.id as IDVenta',
                            'venta.created_at as FechaVenta',
                            'ventaproducto.producto_id as IdArticulo',
                            'stock.codigo as CodigoArticulo',
                            'stock.categoria_id as CategoriaId',
                            'categoria.nombre as CategoriaNombre',
                            'ventaproducto.cantidad as Cantidad',
                            'venta.porcentaje_descuento as Descuento',
                            'ventaproducto.total as PvpArticulo',
                            'venta.total as TotalVenta'
                           )
                    ->join('venta_producto as ventaproducto', 'ventaproducto.venta_id', '=', 'venta.id')
                    ->join('stock as stock', 'stock.id', '=', 'ventaproducto.producto_id')
                    ->join('categoria as categoria', 'categoria.id', '=', 'stock.categoria_id')
                    ->whereBetween('venta.created_at', [$desde, $hasta])
                    ->orderBy('venta.id', 'asc')
                    ->get());

    // Inicializamos array de datos de categoria
    foreach ($categoria as $key => $catego) {
      $totalesCat[$catego->IDCategoria] = 0;
      $cantidadCat[$catego->IDCategoria] = 0;
    }   

    foreach ($ProductData as $key => $venta) {
      // Obtenemos si es servicio o producto en las ventas
      $producto = true;
      foreach ($serviciosId as $key => $servicio) {
        if($venta->CodigoArticulo == $servicio->IDServicio){
          $producto = false;          
        }
      }    
      // Segun sea servicio o producto calculamos totales por mes , numero
      if ($producto) {
        // Total ventas Categorias
        $totalesCat[$venta->CategoriaId] = $totalesCat[$venta->CategoriaId] + ( ( $venta->PvpArticulo ) - (( $venta->PvpArticulo * $venta->Descuento )/100 ) ) / $venta->Cantidad;
        // N Productos totales por categoria
        $cantidadCat[$venta->CategoriaId] = ($cantidadCat[$venta->CategoriaId]) + $venta->Cantidad;
      }    
    }   

    $cont = 0;
    foreach ($categoria as $key => $catego) {
      if ($totalesCat[$catego->IDCategoria] != 0) {
        $estadisticaCategoria[$cont] = [
          'NombreCategoria' => $catego->Nombre,
          'CantidadCategoria' => $cantidadCat[$catego->IDCategoria],
          'TotalVentaCategoria' => $totalesCat[$catego->IDCategoria]
        ];
        $cont ++;
      }
    } 
    return response()->json(($estadisticaCategoria),200);
  }
  
  public function getServicioData($desde, $hasta){
    // Obtenemos las Id de servicios
    $serviciosId = (DB::table('app_servicio')->select('app_servicio.id as IDServicio')->get());
    // Obtenemos stock
    $stock = (DB::table('stock')->select('stock.id as IDstock', 'stock.nombre as Nombre', 'stock.codigo as Codigo')->get());
    // Obtenemos ServiceData
    $ServiceData = (DB::table('venta as venta')
                   ->select(
                            'venta.id as IDVenta',
                            'venta.created_at as FechaVenta',
                            'ventaproducto.producto_id as IdArticulo',
                            'stock.codigo as CodigoArticulo',
                            'stock.categoria_id as CategoriaId',
                            'categoria.nombre as CategoriaNombre',
                            'ventaproducto.cantidad as Cantidad',
                            'venta.porcentaje_descuento as Descuento',
                            'ventaproducto.total as PvpArticulo',
                            'venta.total as TotalVenta'
                           )
                    ->join('venta_producto as ventaproducto', 'ventaproducto.venta_id', '=', 'venta.id')
                    ->join('stock as stock', 'stock.id', '=', 'ventaproducto.producto_id')
                    ->join('categoria as categoria', 'categoria.id', '=', 'stock.categoria_id')
                    ->whereBetween('venta.created_at', [$desde, $hasta])
                    ->orderBy('venta.id', 'asc')
                    ->get());

    // Obtenemos si es servicio o producto
    foreach ($stock as $key => $stockP) {
      $producto = true;
      foreach ($serviciosId as $key => $servicio) {
        if($stockP->Codigo == $servicio->IDServicio){
          $producto = false;   
        }
      }      
      if (!$producto) {
        $serviciosCan[$stockP->IDstock] = 0;
        $serviciosTot[$stockP->IDstock] = 0;
      }       
    }    

    foreach ($ServiceData as $key => $venta) {
      // Obtenemos si es servicio o producto en las ventas
      $producto = true;
      foreach ($serviciosId as $key => $servicio) {
        if($venta->CodigoArticulo == $servicio->IDServicio){
          $producto = false;          
        }
      }    
      // Segun sea servicio o producto calculamos totales por mes , numero
      if (!$producto) {        
        // Total ventas servicios
        $serviciosTot[$venta->IdArticulo] = $serviciosTot[$venta->IdArticulo] + ( ( $venta->PvpArticulo ) - (( $venta->PvpArticulo * $venta->Descuento )/100 ) ) / $venta->Cantidad;
        // servicios
        $serviciosCan[$venta->IdArticulo] = ($serviciosCan[$venta->IdArticulo]) + $venta->Cantidad;
      }    
    }   

    $cont = 0;
    foreach ($stock as $key => $stockP) {
      $producto = true;
      foreach ($serviciosId as $key => $servicio) {
        if($stockP->Codigo == $servicio->IDServicio){
          $producto = false;          
        }
      }      
      if (!$producto) { 
        if ($serviciosTot[$stockP->IDstock] != 0) {
          $estadisticaservicios[$cont] = [
            'NombreProducto' => $stockP->Nombre,
            'CantidadProducto' => $serviciosCan[$stockP->IDstock],
            'TotalVentaServicio' => $serviciosTot[$stockP->IDstock]
          ];
          $cont ++;
        }
      }
    } 

    return response()->json($estadisticaservicios,200);
  }

  public function getCategoServData($desde, $hasta){
    // Obtenemos las Id de servicios
    $serviciosId = (DB::table('app_servicio')->select('app_servicio.id as IDServicio')->get());
    // Obtenemos las categoria
    $categoria = (DB::table('categoria')->select('categoria.id as IDCategoria', 'categoria.nombre as Nombre')->get());

    $ProductData = (DB::table('venta as venta')
                   ->select(
                            'venta.id as IDVenta',
                            'venta.created_at as FechaVenta',
                            'ventaproducto.producto_id as IdArticulo',
                            'stock.codigo as CodigoArticulo',
                            'stock.categoria_id as CategoriaId',
                            'categoria.nombre as CategoriaNombre',
                            'ventaproducto.cantidad as Cantidad',
                            'venta.porcentaje_descuento as Descuento',
                            'ventaproducto.total as PvpArticulo',
                            'venta.total as TotalVenta'
                           )
                    ->join('venta_producto as ventaproducto', 'ventaproducto.venta_id', '=', 'venta.id')
                    ->join('stock as stock', 'stock.id', '=', 'ventaproducto.producto_id')
                    ->join('categoria as categoria', 'categoria.id', '=', 'stock.categoria_id')
                    ->whereBetween('venta.created_at', [$desde, $hasta])
                    ->orderBy('venta.id', 'asc')
                    ->get());

    // Inicializamos array de datos de categoria
    foreach ($categoria as $key => $catego) {
      $totalesCat[$catego->IDCategoria] = 0;
      $cantidadCat[$catego->IDCategoria] = 0;
    }   

    foreach ($ProductData as $key => $venta) {
      // Obtenemos si es servicio o producto en las ventas
      $producto = true;
      foreach ($serviciosId as $key => $servicio) {
        if($venta->CodigoArticulo == $servicio->IDServicio){
          $producto = false;          
        }
      }    
      // Segun sea servicio o producto calculamos totales por mes , numero
      if (!$producto) {
        // Total ventas Categorias
        $totalesCat[$venta->CategoriaId] = $totalesCat[$venta->CategoriaId] + ( ( $venta->PvpArticulo ) - (( $venta->PvpArticulo * $venta->Descuento )/100 ) ) / $venta->Cantidad;
        // N Productos totales por categoria
        $cantidadCat[$venta->CategoriaId] = ($cantidadCat[$venta->CategoriaId]) + $venta->Cantidad;
      }    
    }   

    $cont = 0;
    foreach ($categoria as $key => $catego) {
      if ($totalesCat[$catego->IDCategoria] != 0) {
        $estadisticaCategoria[$cont] = [
          'NombreCategoria' => $catego->Nombre,
          'CantidadCategoria' => $cantidadCat[$catego->IDCategoria],
          'TotalVentaCategoria' => $totalesCat[$catego->IDCategoria]
        ];
        $cont ++;
      }
    } 
    return response()->json(($estadisticaCategoria),200);
  }
}