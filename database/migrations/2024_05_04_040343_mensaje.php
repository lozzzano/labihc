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
        Schema::create('mensaje', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('id_conversacion');
            $table->unsignedBigInteger('id_usuario');
            $table->text('mensaje');
            $table->timestamps();

            $table->foreign('id_conversacion')->references('id')->on('conversacion')->onDelete('cascade');
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensaje');
    }
};
