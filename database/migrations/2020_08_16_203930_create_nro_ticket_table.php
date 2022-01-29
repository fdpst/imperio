<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNroTicketTable extends Migration
{
    public function up(){
        Schema::create('nro_ticket', function (Blueprint $table) {
            $table->id();
            $table->integer('venta_id');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('nro_ticket');
    }
}
