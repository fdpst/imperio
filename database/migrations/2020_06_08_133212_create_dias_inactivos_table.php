<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiasInactivosTable extends Migration
{
    public function up(){
        Schema::create('dias_inactivos', function (Blueprint $table) {
            $table->id();
            $table->integer('hora_dia_id');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('dias_inactivos');
    }
}
