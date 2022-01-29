<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoTable extends Migration
{
    public function up(){
        Schema::create('tipo', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->timestamps();
        });
    }
    
    public function down(){
        Schema::dropIfExists('tipo');
    }
}
