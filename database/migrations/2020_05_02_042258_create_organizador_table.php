<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateOrganizadorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Organizador', function (Blueprint $table) {
            $table->bigIncrements('IdOrganizador');

            /*Realaciones*/
            $table->unsignedBigInteger('IdAcademico')->nullable(false);
            $table->foreign('IdAcademico')->references('IdUsuario')->on('Usuario');
            $table->unsignedBigInteger('IdEvento')->nullable(false);
            $table->foreign('IdEvento')->references('IdEvento')->on('Evento');
            $table->unsignedBigInteger('IdTipoOrganizador')->nullable(false);
            $table->foreign('IdTipoOrganizador')->references('IdTipoOrganizador')->on('TipoOrganizador');
            $table->unique(['IdAcademico','IdEvento','IdTipoOrganizador']);

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
        Schema::dropIfExists('Organizador');
    }
}
