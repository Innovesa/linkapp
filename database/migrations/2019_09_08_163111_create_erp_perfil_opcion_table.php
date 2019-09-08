<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErpPerfilOpcionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_perfil_opcion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idPerfil');
            $table->integer('idOpcion');
            $table->integer('rolModificar');
            $table->integer('rolEliminar');
            $table->integer('rolInsertar');
            $table->integer('rolAdmin');
            $table->integer('rolSuper');
            $table->timestamps();

            $table->foreign('idPerfil')->references('id')->on('erp_perfil');
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
        Schema::dropIfExists('erp_perfil_opcion');
    }
}
