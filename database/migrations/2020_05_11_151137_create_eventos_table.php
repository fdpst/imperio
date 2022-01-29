<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventosTable extends Migration
{
    public function up(){
        Schema::create('evento', function (Blueprint $table) {
            $table->id();
            $table->integer('empleado_id');
            $table->integer('servicio_id');
            $table->string('start');
            $table->string('end');
            $table->string('color')->nullable();
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('evento');
    }
}
