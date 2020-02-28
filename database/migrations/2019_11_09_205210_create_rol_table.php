<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rol', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',200);
            $table->integer('idTipoPersona')->unsigned();
            $table->integer('idEstado')->unsigned();
            $table->timestamps();

            $table->foreign('idTipoPersona')->references('id')->on('tipo_persona');
            $table->foreign('idEstado')->references('id')->on('estado');

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
        Schema::dropIfExists('rol');
    }
}
