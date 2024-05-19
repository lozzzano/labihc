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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('categoria_producto');
            $table->string('nombre_producto');
            $table->string('descripcion_producto');
            $table->string('imagen_producto');
            $table->float('precio_producto', 5, 2);
            $table->integer('stock_producto');
            $table->boolean('status_producto')->default(0);
            $table->timestamps();

            $table->foreign('categoria_producto')->references('id')->on('categorias');
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
