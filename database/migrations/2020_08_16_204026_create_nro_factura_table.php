<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNroFacturaTable extends Migration
{
    public function up(){
        Schema::create('nro_factura', function (Blueprint $table) {
            $table->id();
            $table->integer('venta_id');
            $table->timestamps();
        });
    }
        
    public function down(){
        Schema::dropIfExists('nro_factura');
    }
}
