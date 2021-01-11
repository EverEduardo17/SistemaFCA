<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCambiosGruposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Cambio_Grupo', function (Blueprint $table) {
            $table->bigIncrements('IdCambioGrupo');
            
            /*Realaciones*/
            $table->unsignedBigInteger('IdGrupoOrigen')->nullable(false);
            $table->foreign('IdGrupoOrigen')->references('IdGrupo')->on('Grupo');
            
            $table->unsignedBigInteger('IdGrupoDestino')->nullable(false);
            $table->foreign('IdGrupoDestino')->references('IdGrupo')->on('Grupo');

            $table->unsignedBigInteger('IdTrayectoria')->nullable(false);
            $table->foreign('IdTrayectoria')->references('IdTrayectoria')->on('Trayectoria');
            
            $table->unsignedBigInteger('IdPeriodoCambioGrupo')->nullable(false);
            $table->foreign('IdPeriodoCambioGrupo')->references('IdPeriodo')->on('Periodo');

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
        Schema::dropIfExists('Cambio_Grupo');
    }
}
