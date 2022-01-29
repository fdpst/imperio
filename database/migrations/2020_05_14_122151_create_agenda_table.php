<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendaTable extends Migration
{
    public function up(){
        Schema::create('agenda', function (Blueprint $table) {
            $table->id();
            $table->integer('servicio_id');
            $table->integer('empleado_id');
            $table->string('cliente_nombre');
            $table->string('fecha');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('agenda');
    }
}
