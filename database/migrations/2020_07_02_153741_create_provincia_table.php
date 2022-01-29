<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvinciaTable extends Migration
{
    public function up(){
        Schema::create('provincia', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 60);
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('provincia');
    }
}
