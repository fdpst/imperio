<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriaTable extends Migration
{
    public function up(){
        Schema::create('categoria', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('orden');
            // add column %
            $table->double('cat_profit')->nullable()->default('0');
            // END add column %
            $table->integer('imagen_url');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('categoria');
    }
}
