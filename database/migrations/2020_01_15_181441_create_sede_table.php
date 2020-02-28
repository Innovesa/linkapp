<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSedeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sede', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',100);
            $table->integer('idUbicacion')->unsigned();
            $table->integer('idCompania')->unsigned();
            $table->integer('idEstado')->unsigned();
            $table->timestamps();

            $table->foreign('idUbicacion')->references('id')->on('pais');
            $table->foreign('idCompania')->references('id')->on('persona');
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
        Schema::dropIfExists('sede');
    }
}
