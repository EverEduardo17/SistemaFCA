<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateReprobadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reprobado', function (Blueprint $table) {
            $table->bigIncrements('IdReprobado');
            
            /*Realaciones*/
            $table->unsignedBigInteger('IdGrupo')->nullable(false);
            $table->foreign('IdGrupo')->references('IdGrupo')->on('Grupo');

            $table->unsignedBigInteger('IdTrayectoria')->nullable(false);
            $table->foreign('IdTrayectoria')->references('IdTrayectoria')->on('Trayectoria');
            
            $table->unsignedBigInteger('IdPeriodo')->nullable(false);
            $table->foreign('IdPeriodo')->references('IdPeriodo')->on('Periodo');

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
        Schema::dropIfExists('reprobado');
    }
}
