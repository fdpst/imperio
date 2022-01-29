<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicioTable extends Migration
{
    function up(){
        Schema::create('servicio', function (Blueprint $table) {
            $table->id();
            // create categoria_id 
            $table->integer('categoria_id');
            // END create categoria_id 
            $table->string('nombre', 60);
            $table->double('precio');
            $table->integer('duracion');
            $table->boolean('is_active');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('servicio');
    }
}
