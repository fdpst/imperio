<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresupuestoTable extends Migration
{
    public function up(){
        Schema::create('presupuesto', function (Blueprint $table) {
            $table->id();
            $table->integer('cliente_id');
            $table->double('sub_total');
            $table->double('descuento');
            $table->double('porcentaje_descuento');
            $table->double('total');
            $table->string('url_presupuesto', 60);
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('presupuesto');
    }
}
