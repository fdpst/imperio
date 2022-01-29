<?php

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

/*Rutas servicios*/
Route::get('getserviciosbytipo/{nombre}', 'ServicioAppController@getServicioByTipo');
Route::get('getservicios', 'ServicioAppController@getServicios');
Route::post('saveservicio', 'ServicioAppController@saveServicio');
Route::get('deleteservicio/{servicio_id}', 'ServicioAppController@deleteServicio');

/*Rutas tiendas*/
Route::get('gettiendas', 'TiendaAppController@getTiendas');
Route::get('gettiendascita', 'TiendaAppController@getTiendasCita');
Route::post('savetienda', 'TiendaAppController@saveTienda');
Route::get('deletetienda/{id}', 'TiendaAppController@deleteTienda');

/*Rutas usuarios*/
Route::get('getusuarios', 'UsuarioAppController@getUsuarios');
Route::get('getusuario/{id}', 'UsuarioAppController@getUsuario');
Route::get('getarchivos/{id}', 'UsuarioAppController@getArchivos');
Route::get('getdieta/{id}', 'UsuarioAppController@getDieta');
Route::get('getentrenamiento/{id}', 'UsuarioAppController@getEntrenamiento');
Route::get('gethistorial/{id}', 'UsuarioAppController@getHistorial');
Route::post('saveusuario', 'UsuarioAppController@saveUsuario');
Route::get('deleteusuario/{usuario_id}', 'UsuarioAppController@deleteUsuario');

Route::post('login-app-user', 'UsuarioAppController@login');

/*Rutas para nuevo calendario*/
Route::post('savecita', 'EventAppController@saveCita');
Route::post('saveCitaWeb', 'EventAppController@saveCitaWeb');
Route::post('savecitaapp', 'EventAppController@saveCitaApp');
Route::get('getdata/{nombre_tipo}/{tienda_id}', 'EventAppController@getData');
Route::get('eliminarcita/{evento_id}/{causa}', 'EventAppController@eliminarCita');
// Route::get('eliminarcita/{evento_id}', 'EventAppController@eliminarCita');
//Route::get('geteventsbymonth/{nombre_tipo}/{tienda_id}/{month}/{end_month}', 'EventAppController@getEvents');
Route::get('geteventsbymonth/{fecha}', 'EventAppController@getEvents');
Route::get('confirmar-cita/{evento_id}', 'EventAppController@confirmarCita');


/*Rutas para el horario de cada tienda*/
Route::get('get-horario-by-tienda/{tienda_id}', 'HorarioAppController@getHorarioByTienda');
Route::post('save-horario-by-tienda/{tienda_id}', 'HorarioAppController@saveHorarioByTienda');

Route::post('buscar-horario-disponible', 'PruebaDisponible@buscarDisponible');
Route::get('buscar-horario-disponible-app', 'PruebaDisponible@buscarDisponibleApp');

/*Rutas mascotas*/
Route::get('get-mascotas', 'MascotaAppController@getMascotas');
Route::get('get-mascotas-by-user/{usuario_id}', 'MascotaAppController@getMascotasByUser');
Route::get('get-mascotas-by-id/{mascota_id}', 'MascotaAppController@getMascotaById');
Route::post('save-mascota-from-user/{usuario_id}', 'MascotaAppController@saveMascotaFromUser');
Route::get('delete-mascota/{id}', 'MascotaAppController@deleteMascota');
Route::get('get-servicios-mascota/{id}', 'MascotaAppController@serviciosMascota');
Route::get('get-tipos-pelo', 'MascotaAppController@getTiposPelo');
Route::get('get-tipos-mascotas', 'MascotaAppController@getTiposMascotas');
Route::get('get-tipos-tamanyos', 'MascotaAppController@getTiposTamanyos');
Route::get('get-servicios-tipos-pelo/{id}', 'MascotaAppController@getServiciosTipoPelo');
Route::get('get-servicios-tipos-mascota/{id}', 'MascotaAppController@getServiciosTiposMascota');
Route::get('get-servicios-tipos-tamanyos/{id}', 'MascotaAppController@getServiciosTiposTamanyos');

/*Rutas notificaciones*/
Route::get('get-notificaciones', 'NotificacionesController@getNotificaciones');

/*Rutas citas busqueda*/
Route::get('getcitas', 'NotificacionesController@getCitas');
Route::get('getcitasbymascota/{mascota_id}', 'NotificacionesController@getCitasByMascota');
Route::get('getcitasbyuser/{usuario_id}', 'NotificacionesController@getCitasByUser');
Route::get('getcitasbyuserapp/{usuario_id}', 'NotificacionesController@getCitasByUserApp');

/*Rutas Promo*/
Route::get('get-all-promociones', 'PromocionController@getAllpromociones')/*->middleware(['auth:api', 'hasrole:1,2'])*/;
Route::get('get-promocion-by-id/{promocion_id}', 'PromocionController@getPromocionById')->middleware(['auth:api', 'hasrole:1']);
Route::get('delete-promocion/{promocion_id}', 'PromocionController@deletePromocion')->middleware(['auth:api', 'hasrole:1,2']);
Route::get('change-promocion-active/{promocion_id}', 'PromocionController@changePromocionActive')->middleware(['auth:api', 'hasrole:1']);
Route::post('save-promocion', 'PromocionController@savePromocion')->middleware(['auth:api', 'hasrole:1']);
Route::get('get-promocion-app', 'PromocionController@getPromocionApp');

/*Rutas Adopciones*/
Route::get('get-all-adopciones', 'AdopcionController@getAlladopciones');
Route::get('get-all-adopciones-app', 'AdopcionController@getAlladopcionesApp');
Route::get('getusuarios/adoptantes', 'UsuarioAppController@getUsuariosAdoptantes');
Route::get('getusuarios/donantes', 'UsuarioAppController@getUsuariosDonantes');
Route::get('get-adopcion-fechas', 'AdopcionController@getAdopcionFechas');
Route::get('delete-adopcion/{adopcion_id}', 'AdopcionController@deleteAdopcion')->middleware(['auth:api', 'hasrole:1,2']);
Route::get('save-adopcion/{usuario_id}/{mascota_id}', 'AdopcionController@saveAdopcion')->middleware(['auth:api', 'hasrole:1,2']);

/*Rutas excel*/
Route::get('leerexcel', 'ExcelController@leerExcel');

/*Rutas direcciones usuario*/
Route::get('get-direcciones-by-user/{usuario_id}', 'DireccionUsuarioController@getDireccionByUser');
Route::post('save-direccion-from-user', 'DireccionUsuarioController@saveDireccionFromUser');
Route::get('delete-direccion/{id}', 'DireccionUsuarioController@deleteDireccion');

/*Rutas peces*/
Route::get('get-all-ejemplares-app', 'EjemplaresController@getAllEjemplaresApp');
Route::get('index-ejemplares', 'EjemplaresController@indexEjemplaresApp');
Route::get('show-ejemplares/{ejemplar_id}', 'EjemplaresController@showEjemplaresApp');
Route::post('save-ejemplares', 'EjemplaresController@saveEjemplar');
Route::put('update-ejemplares/{ejemplar_id}', 'EjemplaresController@updateEjemplar');
Route::delete('delete-ejemplares/{ejemplar_id}', 'EjemplaresController@deleteEjemplar');

/*Suscripciones App*/
Route::get('getsuscripcionesbyuser/{id_usuario}', 'SuscripcionesController@showSuscripciones');

Route::post('savesuscripcionesbyuser/{id_usuario}', 'SuscripcionesController@saveSuscripciones');

