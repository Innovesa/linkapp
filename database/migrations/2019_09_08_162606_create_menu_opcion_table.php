<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuOpcionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_opcion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idMenu')->unsigned();
            $table->integer('idOpcion')->unsigned();
            $table->timestamps();

            $table->foreign('idMenu')->references('id')->on('menu');
            $table->foreign('idOpcion')->references('id')->on('aplicacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_opcion');
    }
}
