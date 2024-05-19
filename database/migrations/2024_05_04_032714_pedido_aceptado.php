<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pedido_aceptado', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('id_pedido');
            $table->unsignedBigInteger('id_vendedor');
            $table->unsignedBigInteger('id_comprador');
            $table->boolean('status_pedido')->default(0);
            $table->timestamps();

            $table->foreign('id_pedido')->references('id')->on('pedido')->onDelete('cascade');
            $table->foreign('id_vendedor')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_comprador')->references('id')->on('users')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido_aceptado');
    }
};
