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
        Schema::connection('imageDB')->create('images', function (Blueprint $table) {
            $table->id();
            $table->string('imageMovil');
            $table->string('imageTablet');
            $table->string('imageOrdenador');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('imageDB')->dropIfExists('images');
    }
};
