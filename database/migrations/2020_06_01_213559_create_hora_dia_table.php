<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHoraDiaTable extends Migration
{
    public function up(){
        Schema::create('hora_dia', function (Blueprint $table) {
            $table->id();
            $table->string('dia', 1);
            $table->string('start', 6);
            $table->string('end', 6);
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('hora_dia');
    }
}
