<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBajasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Baja', function (Blueprint $table) {
            $table->bigIncrements('IdBaja');

            /*Realaciones*/
            $table->unsignedBigInteger('IdGrupo')->nullable(false);
            $table->foreign('IdGrupo')->references('IdGrupo')->on('Grupo');

            $table->unsignedBigInteger('IdTrayectoria')->nullable(false);
            $table->foreign('IdTrayectoria')->references('IdTrayectoria')->on('Trayectoria');
            
            $table->unsignedBigInteger('IdPeriodoBaja')->nullable(false);
            $table->foreign('IdPeriodoBaja')->references('IdPeriodo')->on('Periodo');
            
            $table->string('TipoBaja')->nullable(false);
            
            $table->unsignedBigInteger('IdMotivo')->nullable(false);
            $table->foreign('IdMotivo')->references('IdMotivo')->on('Motivo');
            
            $table->unsignedBigInteger('IdPeriodoTramite')->nullable(false);
            $table->foreign('IdPeriodoTramite')->references('IdPeriodo')->on('Periodo');
            
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
        Schema::dropIfExists('Baja');
    }
}
