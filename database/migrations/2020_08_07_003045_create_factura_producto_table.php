<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturaProductoTable extends Migration
{
    public function up(){
        Schema::create('factura_producto', function (Blueprint $table) {
            $table->id();
            $table->integer('factura_id');
            $table->integer('producto_id');
            $table->string('descripcion');
            $table->double('cantidad');
            $table->double('total');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('factura_producto');
    }
}
