<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTitulacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('titulacion', function (Blueprint $table) {
            $table->bigIncrements('IdTitulacion');
            $table->string('PromedioEgreso',10)->nullable(false);
            $table->date('FechaInicioTramite')->nullable(false);
            $table->date('FechaFinTramite')->nullable(false);
            $table->boolean('EstadoTitulacion')->nullable(false);
            $table->string('ResultadoTitulacion',10)->nullable();
        
            /*Realaciones*/
            $table->unsignedBigInteger('IdGrupo')->nullable(false);
            $table->foreign('IdGrupo')->references('IdGrupo')->on('Grupo');

            $table->unsignedBigInteger('IdTrayectoria')->nullable(false);
            $table->foreign('IdTrayectoria')->references('IdTrayectoria')->on('Trayectoria');
            
            $table->unsignedBigInteger('IdPeriodoTitulacion')->nullable(false);
            $table->foreign('IdPeriodoTitulacion')->references('IdPeriodo')->on('Periodo');
            
            $table->unsignedBigInteger('IdModalidad')->nullable(false);
            $table->foreign('IdModalidad')->references('IdModalidad')->on('Modalidad');

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
        Schema::dropIfExists('titulacion');
    }
}
