<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonaRolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persona_rol', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idPersona')->unsigned();
            $table->integer('idRol')->unsigned();
            $table->integer('idCompania')->unsigned();
            $table->timestamps();

            $table->foreign('idPersona')->references('id')->on('persona');
            $table->foreign('idRol')->references('id')->on('rol');
            $table->foreign('idCompania')->references('id')->on('persona');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persona_rol');
    }
}
