<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateRoleUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Role_Usuario', function (Blueprint $table) {
            $table->bigIncrements('Id_Role_Usuario');

            /*Realaciones*/
            $table->unsignedBigInteger('IdRole')->nullable(false);
            $table->foreign('IdRole')->references('Idrole')->on('Role');
            $table->unsignedBigInteger('IdUsuario')->nullable(false);
            $table->foreign('IdUsuario')->references('IdUsuario')->on('Usuario');
            $table->unique(['IdRole','IdUsuario']);


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
        Schema::dropIfExists('Role_Usuario');
    }
}
