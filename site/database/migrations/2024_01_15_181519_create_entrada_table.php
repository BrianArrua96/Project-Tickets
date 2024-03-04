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
        Schema::create('entradas', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->decimal('preu', 8, 2);
            $table->integer('quantitat');
            $table->boolean('nominal')->default(false);
            $table->integer('sessios_id');
            $table->foreign('sessios_id')->references('id')->on('sessios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entradas');
    }
};
