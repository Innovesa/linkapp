<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pais', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',100);
            $table->string('iso_alfa2',2);
            $table->string('iso_alfa3',3);
            $table->string('iso_num',4);
            $table->integer('idMoneda')->unsigned();
            $table->integer('idIdioma')->unsigned();
            $table->integer('idEstado')->unsigned();
            $table->timestamps();

            $table->foreign('idMoneda')->references('id')->on('moneda');
            $table->foreign('idIdioma')->references('id')->on('idioma');
            $table->foreign('idEstado')->references('id')->on('estado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pais');
    }
}
