<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateDatospersonalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DatosPersonales', function (Blueprint $table) {
            $table->bigIncrements('IdDatosPersonales');

            $table->string('NombreDatosPersonales', 100)->nullable(false);
            $table->string('ApellidoPaternoDatosPersonales', 100)->nullable(false);
            $table->string('ApellidoMaternoDatosPersonales', 100)->nullable();
            $table->date('FechaNacimientoDatosPersonales'/*, 100*/)->nullable();
            $table->string('Genero', 10)->nullable();

            $table->unsignedBigInteger('IdUsuario')->nullable()->unique();
            $table->foreign('IdUsuario')->references('IdUsuario')->on('Usuario');

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
        Schema::dropIfExists('datospersonales');
    }
}
