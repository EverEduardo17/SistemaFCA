<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProgramaEducativoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programa_educativo', function (Blueprint $table) {
            $table->bigIncrements('IdProgramaEducativo');
            
            /*Realaciones*/
            $table->unsignedBigInteger('IdFacultad')->nullable(false);
            $table->foreign('IdFacultad')->references('IdFacultad')->on('Facultad');
            
            $table->string('NombreProgramaEducativo', 100)->nullable(false)->unique();
            $table->string('AcronimoProgramaEducativo', 10)->nullable(false)->unique();

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
        Schema::dropIfExists('programa_educativo');
    }
}
