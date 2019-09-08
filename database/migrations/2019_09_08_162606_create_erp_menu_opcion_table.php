<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErpMenuOpcionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_menu_opcion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idMenu');
            $table->integer('idOpcion');
            $table->timestamps();

            $table->foreign('idMenu')->references('id')->on('erp_menu');
            $table->foreign('idOpcion')->references('id')->on('erp_opcion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('erp_menu_opcion');
    }
}
