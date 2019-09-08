<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErpPaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_pais', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre',100);
            $table->string('iso_alfa2',2);
            $table->string('iso_alfa3',3);
            $table->string('iso_num',4);
            $table->integer('idMoneda');
            $table->integer('idIdioma');
            $table->integer('idEstado');
            $table->timestamps();

            $table->foreign('idMoneda')->references('id')->on('erp_moneda');
            $table->foreign('idIdioma')->references('id')->on('erp_idioma');
            $table->foreign('idEstado')->references('id')->on('erp_estado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('erp_pais');
    }
}
