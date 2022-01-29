<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturaEmitidaTable extends Migration
{
    public function up(){
        Schema::create('factura_emitida', function (Blueprint $table) {
            $table->id();
            $table->integer('cliente_id')->nullable();
            $table->integer('numero_factura');
            $table->double('precio');
            $table->double('retencion');
            $table->double('total');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('factura_emitida');
    }
}
