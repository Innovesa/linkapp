<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuarioOpcionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario_opcion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idUsuario')->unsigned();
            $table->integer('idOpcion')->unsigned();
            $table->integer('rolModificar');
            $table->integer('rolEliminar');
            $table->integer('rolInsertar');
            $table->integer('rolAdmin');
            $table->integer('rolSuper');
            $table->timestamps();

            $table->foreign('idUsuario')->references('id')->on('usuario');
            $table->foreign('idOpcion')->references('id')->on('aplicacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario_opcion');
    }
}
