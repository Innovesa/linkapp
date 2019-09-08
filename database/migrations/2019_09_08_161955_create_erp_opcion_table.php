<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErpOpcionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_opcion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre',45);
            $table->string('descripcion',200);
            $table->string('icono',45);
            $table->string('accion',45);
            $table->integer('idEstructura');
            $table->timestamps();

            $table->foreign('idEstructura')->references('id')->on('erp_estructura');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('erp_opcion');
    }
}
