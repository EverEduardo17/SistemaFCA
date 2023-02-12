<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateEventoFechaSedeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Evento_Fecha_Sede', function (Blueprint $table) {
            $table->bigIncrements('Id_Evento_Fecha_Sede');

            /*Realaciones*/
            $table->unsignedBigInteger('IdEvento')->nullable(false);
            $table->foreign('IdEvento')->references('IdEvento')->on('Evento');
            $table->unsignedBigInteger('IdFechaEvento')->nullable(false);
            $table->foreign('IdFechaEvento')->references('IdFechaEvento')->on('FechaEvento');
            $table->unsignedBigInteger('IdSedeEvento')->nullable(false);
            $table->foreign('IdSedeEvento')->references('IdSedeEvento')->on('SedeEvento');
            $table->unique(['IdEvento','IdFechaEvento','IdSedeEvento']);

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
        Schema::dropIfExists('evento_fecha_sede');
    }
}
