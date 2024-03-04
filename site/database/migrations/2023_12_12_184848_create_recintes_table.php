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
        Schema::create('recintes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('provincia');
            $table->string('lloc');
            $table->string('codi_postal');
            $table->unsignedInteger('capacitat');
            $table->string('carrer');
            $table->integer('numero');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recintes');
    }
};
