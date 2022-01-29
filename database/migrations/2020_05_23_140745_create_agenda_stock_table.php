<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendaStockTable extends Migration
{
    public function up(){
        Schema::create('cita_stock', function (Blueprint $table) {
            $table->id();
            $table->integer('cita_id');
            $table->integer('stock_id');
            $table->integer('cantidad');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('cita_stock');
    }
}
