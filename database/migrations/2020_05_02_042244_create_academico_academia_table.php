<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateAcademicoAcademiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Academico_Academia', function (Blueprint $table) {
            $table->bigIncrements('Id_Academico_Academia');

            /*Realaciones*/
            $table->unsignedBigInteger('IdAcademico')->nullable(false);
            $table->foreign('IdAcademico')->references('IdAcademico')->on('Academico');
            $table->unsignedBigInteger('IdAcademia')->nullable(false);
            $table->foreign('IdAcademia')->references('IdAcademia')->on('Academia');
            $table->unique(['IdAcademico','IdAcademia']);

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
        Schema::dropIfExists('Academico_Academia');
    }
}
