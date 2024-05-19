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
        Schema::create('pedido', function(Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_usuario');
            $table->boolean('status_pedido')->default(0);
            $table->float('precio_pedido');
            $table->enum('metodo_pago', ['transferencia', 'efectivo'])->default('efectivo');
            $table->timestamps();

            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido');
    }
};
