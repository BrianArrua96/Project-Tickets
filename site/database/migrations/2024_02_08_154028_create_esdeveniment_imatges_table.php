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
        Schema::create('esdeveniment_imatges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('esdeveniments_id')->constrained('esdeveniments')->onDelete('cascade');
            $table->string('imatge'); // Ruta o nombre de archivo de la imagen
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('esdeveniment_imatges');
    }
};
