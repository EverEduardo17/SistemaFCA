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
        Schema::create('constancias', function (Blueprint $table) {
            $table->bigIncrements('IdConstancia');

            $table->string('NombreConstancia');
            $table->string('DescripcionConstancia');
            $table->boolean('EstadoVigencia');
            $table->date('VigenteHasta');

            /*Relaciones*/
            $table->foreign('IdEstudiante')->references('IdEstudiante')->on('Estudiante');

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
        Schema::dropIfExists('constancias');
    }
};
