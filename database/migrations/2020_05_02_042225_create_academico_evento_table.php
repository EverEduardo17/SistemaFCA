<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademicoEventoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Academico_Evento', function (Blueprint $table) {
            $table->bigIncrements('Id_Academico_Evento');

            /*Realaciones*/
            $table->unsignedBigInteger('IdAcademico')->nullable(false);
            $table->foreign('IdAcademico')->references('IdAcademico')->on('Academico');
            $table->unsignedBigInteger('IdEvento')->nullable(false);
            $table->foreign('IdEvento')->references('IdEvento')->on('Evento');
            $table->unique(['IdAcademico','IdEvento']);


            $table->timestamp('CreatedAt')->useCurrent();
            $table->timestamp('UpdatedAt')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->timestamp('DeletedAt')->nullable();
            $table->unsignedBigInteger('CreatedBy')->nullable();
            $table->unsignedBigInteger('UpdatedBy')->nullable();

            $table->foreign('CreatedBy')->references('IdUsuario')->on('Usuario');
            $table->foreign('UpdatedBy')->references('IdUsuario')->on('Usuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Id_Academico_Evento');
    }
}
