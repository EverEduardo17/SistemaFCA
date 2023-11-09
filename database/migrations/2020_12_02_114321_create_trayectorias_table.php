<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTrayectoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Trayectoria', function (Blueprint $table) {
            $table->bigIncrements('IdTrayectoria');
            $table->boolean('EstudianteRegular')->nullable(false);
            $table->integer('TotalPeriodos')->nullable();

            /*Realaciones*/
            //Se cambio de false a true para que no necesite almacenar IdGrupo
            //$table->unsignedBigInteger('IdGrupo')->nullable(false);
            $table->unsignedBigInteger('IdGrupo')->nullable(true);
            $table->foreign('IdGrupo')->references('IdGrupo')->on('Grupo');

            $table->unsignedBigInteger('IdEstudiante')->nullable(false);
            $table->foreign('IdEstudiante')->references('IdEstudiante')->on('Estudiante');

            $table->unsignedBigInteger('IdProgramaEducativo')->nullable(false);
            $table->foreign('IdProgramaEducativo')->references('IdProgramaEducativo')->on('Programa_Educativo');

            $table->unsignedBigInteger('IdModalidad')->nullable(false);
            $table->foreign('IdModalidad')->references('IdModalidad')->on('Modalidad');

            $table->unsignedBigInteger('IdCohorte')->nullable(false);
            $table->foreign('IdCohorte')->references('IdCohorte')->on('Cohorte');

            $table->unsignedBigInteger('IdDatosPersonales')->nullable(false);
            $table->foreign('IdDatosPersonales')->references('IdDatosPersonales')->on('DatosPersonales');

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
        Schema::dropIfExists('Trayectoria');
    }
}
