<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadoTable extends Migration
{
    public function up(){
        Schema::create('empleado', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('email', 100);
            $table->string('telefono', 80)->nullable();
            $table->string('color', 30);
            $table->boolean('is_active');
            $table->timestamps();
        });
    }


    public function down(){
        Schema::dropIfExists('empleado');
    }
}
