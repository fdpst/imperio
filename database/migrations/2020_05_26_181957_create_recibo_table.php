<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReciboTable extends Migration
{
    public function up(){
        Schema::create('recibo', function (Blueprint $table) {
            $table->id();
            $table->integer('factura_id')->nullable();
            $table->string('numero_recibo', 30);
            $table->string('detalle', 200);
            $table->string('fecha');
            $table->double('monto');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('recibo');
    }
}
