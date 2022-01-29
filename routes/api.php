<?php

use Illuminate\Support\Facades\Route;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

Route::post('/login', function (Request $request) {

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response([
            'message' => ['These credentials do not match our records.']
        ], 404);
    }

    $token = $user->createToken('my-app-token')->plainTextToken;

    $response = [
        'user' => $user,
        'token' => $token
    ];

    return response($response, 201);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'ApiControllers'], function() {

  /*Rutas empleado*/
  Route::get('getempleados', 'EmpleadoApiController@getEmpleados');
  Route::get('getempleadosbydate/{fecha}/{tipo}', 'EmpleadoApiController@getEmpleadosByDate');
  Route::get('getempleado/{empleado_id}', 'EmpleadoApiController@getEmpleado');
  Route::post('saveempleado', 'EmpleadoApiController@saveEmpleado');
  Route::get('deleteempleado/{empleado_id}', 'EmpleadoApiController@deleteEmpleado');
  /*Rutas empleado*/

  /*Rutas cliente*/
  Route::get('getclientes', 'ClienteApiController@getClientes');
  Route::get('getcliente/{cliente_id}', 'ClienteApiController@getCliente');
  Route::post('savecliente', 'ClienteApiController@saveCliente');
  Route::get('deletecliente/{cliente_id}', 'ClienteApiController@deleteCliente');
  /*Rutas cliente*/

  /*Rutas empresa*/
  Route::get('getempresas', 'EmpresaApiController@getEmpresas');
  Route::get('getempresa/{empresa_id}', 'EmpresaApiController@getEmpresa');
  Route::post('saveempresa', 'EmpresaApiController@saveEmpresa');
  Route::get('deleteempresa/{empresa_id}', 'EmpresaApiController@deleteEmpresa');
  /*Rutas empresa*/

  /*Rutas servicios*/
  /*Route::get('getserviciosbytipo/{nombre}', 'ServicioApiController@getServicioByTipo');
  Route::get('getservicios', 'ServicioApiController@getServicios');
  Route::post('saveservicio', 'ServicioApiController@saveServicio');
  Route::get('deleteservicio/{servicio_id}', 'ServicioApiController@deleteServicio');*/
  Route::get('getserviciosbytipo/{nombre}', 'ServicioAppController@getServicioByTipo');
  Route::get('getservicios', 'ServicioAppController@getServicios');
  Route::post('saveservicio', 'ServicioAppController@saveServicio');
  Route::get('deleteservicio/{servicio_id}', 'ServicioAppController@deleteServicio');
  // Ruta Get Servicio ID
  Route::get('getServicio/{servicio_id}', 'ServicioAppController@getServicio');
  // END Ruta Get Servicio ID

  /*Rutas servicios*/

  /*Rutas eventos*/
  Route::post('saveevento', 'EventoApiController@saveEvento');
  Route::get('geteventos/{fecha}/{tipo}', 'EventoApiController@getEventos');
  Route::get('getempleadotest', 'EventoApiController@getEmpleado');
  Route::get('deletecita/{cita_id}', 'EventoApiController@deleteCita');
  /*Rutas eventos*/

  /*Rutas turno*/
  Route::get('getturnos', 'TurnoApiController@getTurnos');
  Route::get('getturnosbydate/{fecha}', 'TurnoApiController@getTurnosByDay');
  Route::post('saveturnos', 'TurnoApiController@saveTurnos');
  Route::get('gethoradia', 'TurnoApiController@getHorasDia');
  Route::post('savehoradia', 'TurnoApiController@saveHoraDia');
  /*Rutas turno*/

  /*Rutas stock*/
  Route::get('getstocks', 'StockApiController@getStocks');
  Route::get('getstock/{stock_id}', 'StockApiController@getStock');
  Route::post('savestock', 'StockApiController@saveStock');
  Route::get('deletestock/{stock_id}', 'StockApiController@deleteStock');
  /*Rutas stock*/

  Route::post('finalizarcita', 'EventoApiController@finalizarCita');

  /*Rutas tipo*/
  //Route::get('gettipos', 'TipoApiController@getTipos');

  /*Rutas recibo*/
  Route::get('getReciboswithoutfactura', 'ReciboApiController@getRecibosWithoutFactura');
  Route::get('getrecibo/{recibo_id}', 'ReciboApiController@getRecibo');
  Route::get('getrecibos', 'ReciboApiController@getRecibos');
  Route::post('saverecibo', 'ReciboApiController@saveRecibo');
  Route::get('deleterecibo/{recibo_id}', 'ReciboApiController@deleteRecibo');
  Route::post('deleterecibostock', 'ReciboApiController@deleteReciboStock');

  /*Rutas factura*/
  Route::get('getfacturas', 'FacturaApiController@getFacturas');
  Route::get('gettickets', 'FacturaApiController@getTickets');
  Route::post('generar-factura/{ticket_id}/{cliente_id?}', 'FacturaApiController@crearFacturaFromTicket');
  Route::get('deletefactura/{factura_id}', 'FacturaApiController@deleteFactura');
  Route::get('deleteticket/{factura_id}', 'FacturaApiController@deleteTicket');
  Route::get('getfacturabyid/{factura_id}', 'FacturaApiController@getFactura');
  Route::post('editar-factura/{factura_id}', 'FacturaApiController@editarFactura');
// Create Route generate inform PDF
  Route::post('generar-informe/{desde}/{hasta}', 'FacturaApiController@generaInforme');
// END Create Route generate inform PDF
// Create Route generate inform EXCEL

// END Create Route generate inform EXCEL


  /*Rutas informacion*/
  Route::get('getinformacion', 'InformacionApiController@getInformacion');
  Route::post('saveinformacion', 'InformacionApiController@saveInformacion');

  Route::get('getfacturasemitidas', 'FacturaEmitidaApiController@getFacturasEmitidas');
  Route::post('createfactura', 'FacturaEmitidaApiController@createfactura');
  Route::get('deletefacturaemitida/{factura_id}', 'FacturaEmitidaApiController@deleteFactura');
// Create Route get between date
  Route::get('getFacturasfechas', 'FacturaEmitidaApiController@getFacturasfechas');
// END Create Route get between date


  /*Rutas ingresos*/
  Route::get('getingresos', 'IngresoApiController@getIngresos');

  /*Rutas provincias*/
  Route::get('getprovincias', 'ProvinciaApiController@getProvincias');

  /*Rutas facturas*/
  Route::get('savefactura', 'PosApiController@saveFactura');
  Route::get('getclientebydni/{dni}', 'PosApiController@getClienteByDni');

  /*Rutas tickets*/
  Route::post('generar-ticket/{tipo}', 'TicketApiController@generarVenta');

  /*Rutas categoria*/
  Route::get('getcategorias', 'CategoriaApiController@getCategorias');
  Route::post('savecategoria', 'CategoriaApiController@saveCategoria');
  Route::get('getcategoriaswithstock', 'CategoriaApiController@getCategoriaWithStock');

  // servicios with stock
  Route::get('getservicioswithstock', 'CategoriaApiController@getServicioWithStock');
  // END servicios with stock
  
  /*Rutas iva*/
  Route::get('getivas', 'IvaApiController@getIvas');
  Route::post('saveiva', 'IvaApiController@saveIva');

  /*Rutas presupuestos*/
  Route::get('getpresupuestos', 'PresupuestoApiController@getPresupuestos');
  Route::post('guardar-presupuesto', 'PresupuestoApiController@guardarPresupuesto');
  Route::get('deletepresupuesto/{presupuesto_id}', 'PresupuestoApiController@deletePresupuesto');

  Route::get('getticketsfromcliente/{cliente_id}', 'TicketNewApiController@getTickets');
  Route::post('createfacturafromtickets', 'TicketNewApiController@crearFactura');

  /*Rutas tiendas*/
    Route::get('gettiendas', 'TiendaAppController@getTiendas');
    Route::post('savetienda', 'TiendaAppController@saveTienda');
    Route::get('deletetienda/{id}', 'TiendaAppController@deleteTienda');

    /*Rutas empleado*/
    Route::get('gettipos', 'EmpleadoAppController@getTipos');
    Route::get('getempleados', 'EmpleadoAppController@getEmpleados');
    Route::get('getempleadosbydate/{fecha}/{tipo}', 'EmpleadoAppController@getEmpleadosByDate');
    Route::get('getempleado/{empleado_id}', 'EmpleadoAppController@getEmpleado');
    Route::post('saveempleado', 'EmpleadoAppController@saveEmpleado');
    Route::get('deleteempleado/{empleado_id}', 'EmpleadoAppController@deleteEmpleado');

    /*Rutas para el horario*/
    Route::post('savehorario/{empleado_id}', 'EmpleadoAppController@savehorario');
    Route::post('deletehorario/{id}', 'EmpleadoAppController@deleteHorario');
    Route::post('add-horario/{empleado_id}', 'EmpleadoAppController@addHorario');
    Route::get('delete-horario/{id}', 'EmpleadoAppController@deleteFecha');

    /*Rutas para nuevo calendario*/
    Route::post('savecita', 'EventAppController@saveCita');
    Route::get('getdata/{nombre_tipo}/{tienda_id}', 'EventAppController@getData');
    Route::get('eliminarcita/{evento_id}', 'EventAppController@eliminarCita');
    //Route::get('geteventsbymonth/{nombre_tipo}/{tienda_id}/{month}/{end_month}', 'EventAppController@getEvents');
    Route::get('geteventsbymonth/{fecha}', 'EventAppController@getEvents');
    Route::get('confirmar-cita/{evento_id}', 'EventAppController@confirmarCita');

    /*Rutas para el horario de cada tienda*/
    Route::get('get-horario-by-tienda/{tienda_id}', 'HorarioAppController@getHorarioByTienda');
    Route::post('save-horario-by-tienda/{tienda_id}', 'HorarioAppController@saveHorarioByTienda');

    Route::post('buscar-horario-disponible', 'PruebaDisponible@buscarDisponible');

    /*Rutas estadisticas*/
    Route::get('getventastotales/{desde}/{hasta}', 'EstadisticaApiController@getVentasTotales');
    Route::get('getestadisticas/{desde}/{hasta}', 'EstadisticaApiController@getData');
    Route::get('getventadata/{desde}/{hasta}', 'EstadisticaApiController@getVentaData');
    Route::get('getproductdata/{desde}/{hasta}', 'EstadisticaApiController@getProductData');
    Route::get('getcategodata/{desde}/{hasta}', 'EstadisticaApiController@getCategoData');
    Route::get('getserviciodata/{desde}/{hasta}', 'EstadisticaApiController@getServicioData');
    Route::get('getcategoservdata/{desde}/{hasta}', 'EstadisticaApiController@getCategoServData');
});
