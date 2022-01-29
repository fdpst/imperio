<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIvaTable extends Migration
{
    public function up(){
        Schema::create('iva', function (Blueprint $table) {
            $table->id();
            $table->double('iva');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('iva');
    }
}
