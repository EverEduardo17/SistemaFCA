<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePracticasEstudiantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Practica_Estudiante', function (Blueprint $table) {
            $table->bigIncrements('IdPractica');

            /*Realaciones*/
            $table->unsignedBigInteger('IdEmpresa')->nullable(false);
            $table->foreign('IdEmpresa')->references('IdEmpresa')->on('Empresa');

            $table->unsignedBigInteger('IdTrayectoria')->nullable(false)->unique();
            $table->foreign('IdTrayectoria')->references('IdTrayectoria')->on('Trayectoria');

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
        Schema::dropIfExists('Practica_Estudiante');
    }
}
