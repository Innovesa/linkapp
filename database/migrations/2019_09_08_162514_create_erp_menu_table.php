<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErpMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_menu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre',45);
            $table->integer('idEstado');
            $table->timestamps();

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
        Schema::dropIfExists('erp_menu');
    }
}
