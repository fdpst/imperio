<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformacionLegalTable extends Migration
{
    public function up(){
        Schema::create('informacion_legal', function (Blueprint $table) {
            $table->id();
            $table->text('informacion_legal');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('informacion_legal');
    }
}
