<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParametroUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parametro_usuario', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombreParametro',200);
            $table->integer('idUsuario')->unsigned();
            $table->string('codigo',100);
            $table->integer('valor');
            $table->string('dominio',100);
            $table->integer('visible');
            $table->timestamps();

            $table->unique(['codigo', 'dominio','idUsuario']);
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
        Schema::dropIfExists('parametro_usuario');
    }
}
