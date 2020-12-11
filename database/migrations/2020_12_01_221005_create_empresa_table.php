<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa', function (Blueprint $table) {
            $table->bigIncrements('IdEmpresa');
            $table->string('NombreEmpresa', 150)->nullable(false)->unique();
            $table->string('DireccionEmpresa', 100)->nullable(false);
            $table->string('LocalidadEmpresa', 100)->nullable(false);
            $table->string('TelefonoEmpresa', 25)->nullable(false);
            $table->string('ResponsableEmpresa', 100)->nullable(false);
            $table->string('TipoEmpresa', 50)->nullable(false);
            $table->string('ActividadEmpresa', 50)->nullable(false);
            $table->string('ClasificacionEmpresa', 50)->nullable(false);
            
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
        Schema::dropIfExists('empresa');
    }
}
