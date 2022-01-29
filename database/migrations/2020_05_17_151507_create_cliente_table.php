<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClienteTable extends Migration
{
    public function up(){
        Schema::create('cliente', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 60);
            $table->string('telefono', 30)->nullable();
            $table->string('email', 40)->nullable();
            $table->string('fecha_nacimiento')->nullable();
            $table->text('otros')->nullable();
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('cliente');
    }
}
