<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaTable extends Migration
{
    public function up(){
        Schema::create('empresa', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 120);
            $table->string('cif', 20);
            $table->string('direccion', 150);
            $table->string('telefono', 30);
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('empresa');
    }
}
