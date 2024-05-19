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
        Schema::create('pedido_carrito', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pedido');
            $table->unsignedBigInteger('id_producto');
            $table->unsignedBigInteger('cantidad');
            $table->float('precio', 5, 2);
            $table->timestamps();

            $table->foreign('id_pedido')->references('id')->on('pedido')->onDelete('cascade');
            $table->foreign('id_producto')->references('id')->on('productos')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido_carrito');
    }
};
