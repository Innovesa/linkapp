<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfilOpcionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfil_opcion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idPerfil')->unsigned();
            $table->integer('idOpcion')->unsigned();
            $table->integer('rolModificar');
            $table->integer('rolEliminar');
            $table->integer('rolInsertar');
            $table->integer('rolAdmin');
            $table->integer('rolSuper');
            $table->timestamps();

            $table->foreign('idPerfil')->references('id')->on('perfil');
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
        Schema::dropIfExists('perfil_opcion');
    }
}
