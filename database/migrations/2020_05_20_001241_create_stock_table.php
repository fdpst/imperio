<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockTable extends Migration
{
    public function up(){
        Schema::create('stock', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 40)->nullable();
            $table->string('nombre', 120);
            // add column preciopvd and precio and art_profit and change types
            // add column %
            $table->double('art_profit')->nullable()->default('0');
            // END add column %
            // add column preciopvd and precio and change type
            $table->decimal('preciopvdsiva',5,2)->nullable()->default('0');
            $table->decimal('preciopvd',5,2)->nullable()->default('0');
            $table->decimal('preciosiva',5,2)->nullable()->default('0');
            $table->decimal('precio',5,2)->nullable()->default('0');
            // END add column preciopvd and precio and change type
            $table->integer('cantidad');
            $table->string('imagen_url', 120)->nullable();
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('stock');
    }
}
