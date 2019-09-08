<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErpPerfilUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_perfil_usuario', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idUsuario');
            $table->integer('idPerfil');
            $table->timestamps();

            $table->foreign('idUsuario')->references('id')->on('erp_usuario');
            $table->foreign('idPerfil')->references('id')->on('erp_perfil');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('erp_perfil_usuario');
    }
}
