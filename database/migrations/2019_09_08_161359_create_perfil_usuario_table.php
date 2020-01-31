<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfilUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfil_usuario', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idUsuario')->unsigned();
            $table->integer('idPerfil')->unsigned();
            $table->integer('idCompania')->unsigned();
            $table->timestamps();

            $table->foreign('idCompania')->references('id')->on('persona');
            $table->foreign('idUsuario')->references('id')->on('usuario');
            $table->foreign('idPerfil')->references('id')->on('perfil');

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perfil_usuario');
    }
}
