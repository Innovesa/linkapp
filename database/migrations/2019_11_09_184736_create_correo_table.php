<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorreoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion',200);
            $table->string('numero',200);
            $table->integer('idPersona')->unsigned();
            $table->integer('idEstado')->unsigned();
            $table->timestamps();

            $table->foreign('idPersona')->references('id')->on('persona');
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
        Schema::dropIfExists('correo');
    }
}
