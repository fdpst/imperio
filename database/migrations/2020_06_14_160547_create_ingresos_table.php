<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngresosTable extends Migration
{
    public function up(){
        Schema::create('ingresos', function (Blueprint $table) {
            $table->id();
            $table->integer('cita_id')->nullable();
            $table->string('concepto');
            $table->string('codigo');
            $table->double('total');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('ingresos');
    }
}
