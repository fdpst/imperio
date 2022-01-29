<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentaNroTicketIdTable extends Migration
{
    public function up(){
        Schema::create('venta_nro_ticket', function (Blueprint $table) {
            $table->id();
            $table->integer('venta_id');
            $table->integer('nro_ticket_id');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('venta_nro_ticket');
    }
}
