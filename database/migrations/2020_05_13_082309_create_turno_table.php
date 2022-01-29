<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTurnoTable extends Migration
{
    public function up(){
        Schema::create('turno', function (Blueprint $table) {
            $table->id();
            $table->integer('index');
            $table->string('start');
            $table->string('end');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('turno');
    }
}
