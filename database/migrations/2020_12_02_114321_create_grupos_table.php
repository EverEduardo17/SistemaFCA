<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateGruposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grupo', function (Blueprint $table) {
            $table->bigIncrements('IdGrupo');
            $table->string('NombreGrupo', 150)->nullable(false);
            $table->string('DescripcionGrupo', 100)->nullable(false);
            $table->integer('TotalEstudiantesGrupo')->nullable(false);
            $table->integer('EstudiantesActivos')->nullable();
            $table->integer('EstudiantesInactivos')->nullable();
            $table->integer('EstudiantesStandBy')->nullable();
            $table->integer('EstudiantesEgresados')->nullable();

            /*Realaciones*/
            $table->unsignedBigInteger('IdProgramaEducativo')->nullable(false);
            $table->foreign('IdProgramaEducativo')->references('IdProgramaEducativo')->on('Programa_Educativo');
            
            $table->unsignedBigInteger('IdCohorte')->nullable(false);
            $table->foreign('IdCohorte')->references('IdCohorte')->on('Cohorte');
            
            $table->unsignedBigInteger('IdPeriodoInicio')->nullable(false);
            $table->foreign('IdPeriodoInicio')->references('IdPeriodo')->on('Periodo');
            
            $table->unsignedBigInteger('IdPeriodoActivo')->nullable(false);
            $table->foreign('IdPeriodoActivo')->references('IdPeriodo')->on('Periodo');

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
        Schema::dropIfExists('grupo');
    }
}
