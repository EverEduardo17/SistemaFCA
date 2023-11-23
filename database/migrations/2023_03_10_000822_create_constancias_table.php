<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Constancia', function (Blueprint $table) {
            $table->bigIncrements('IdConstancia');

            $table->string('NombreConstancia');
            $table->string('DescripcionConstancia');
            $table->date('VigenteHasta')->nullable();
            $table->string('EstadoConstancia')->default('PENDIENTE');
            $table->string('Motivo', 255)->nullable();

            $table->timestamp('CreatedAt')->useCurrent();
            $table->timestamp('UpdatedAt')->useCurrent();
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
        Schema::dropIfExists('Constancia');
    }
};
