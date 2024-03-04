<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessioTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sessios', function (Blueprint $table) {
            $table->id();
            $table->dateTime("data");
            $table->dateTime("tancament");
            $table->integer('aforament');
            $table->boolean('estado');
            $table->integer('esdeveniments_id');
            $table->foreign('esdeveniments_id')->references('id')->on('esdeveniments')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('sessios');
    }
}
