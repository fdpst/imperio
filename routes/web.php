<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('main');
});

Route::group(['middleware' => ['cors']], function() {
  Route::post('api/v1/prueba-potencial', 'WebControllers\CorsController@dummy');
});

/*
  alter table `venta` add column `url_presupuesto` varchar(80) null default 'NULL' AFTER `url_factura` ,comment = 'utf8mb4_unicode_ci' 
*/
