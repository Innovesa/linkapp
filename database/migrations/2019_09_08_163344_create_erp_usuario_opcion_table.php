<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErpUsuarioOpcionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_usuario_opcion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idUsuario');
            $table->integer('idOpcion');
            $table->integer('rolModificar');
            $table->integer('rolEliminar');
            $table->integer('rolInsertar');
            $table->integer('rolAdmin');
            $table->integer('rolSuper');
            $table->timestamps();

            $table->foreign('idUsuario')->references('id')->on('erp_usuario');
            $table->foreign('idOpcion')->references('id')->on('erp_opcion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('erp_usuario_opcion');
    }
}
