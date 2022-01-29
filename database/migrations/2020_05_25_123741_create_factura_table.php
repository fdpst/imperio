<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturaTable extends Migration
{
    public function up(){
        Schema::create('factura', function (Blueprint $table) {
            $table->id();
            $table->integer('cliente_id');
            $table->double('sub_total');
            $table->double('descuento');
            $table->double('porcetaje_descuento');            
            $table->double('iva');
            $table->double('total');
            $table->string('url_factura');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('factura');
    }
}
