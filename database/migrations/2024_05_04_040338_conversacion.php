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
        Schema::create('conversacion', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('id_pedido_aceptado');
            $table->unsignedBigInteger('id_comprador');
            $table->unsignedBigInteger('id_vendedor');
            $table->boolean('status_conversacion')->default(0);
            $table->timestamps();

            $table->foreign('id_comprador')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_vendedor')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_pedido_aceptado')->references('id')->on('pedido_aceptado')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversacion');
    }
};
