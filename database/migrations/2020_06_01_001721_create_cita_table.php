<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitaTable extends Migration
{
    public function up(){
        Schema::create('cita', function (Blueprint $table) {
            $table->id();
            $table->integer('tipo_id');
            $table->integer('empleado_id');
            $table->integer('cliente_id');
            $table->string('fecha');
            $table->double('precio');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('cita');
    }
}
