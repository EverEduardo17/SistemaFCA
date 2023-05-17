<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('constancia_estudiante', function (Blueprint $table) {
            $table->id();
            $table->foreignId('constancia_id')->references('IdConstancia')->on('Constancia');
            $table->foreignId('estudiante_id')->references('IdEstudiante')->on('Estudiante');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('constancia_estudiante');
    }
};
