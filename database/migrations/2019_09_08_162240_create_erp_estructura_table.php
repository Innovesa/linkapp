<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErpEstructuraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_estructura', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre',45);
            $table->string('descripcion',200);
            $table->string('icono',45);
            $table->integer('superior');
            $table->integer('idEstado');
            $table->timestamps();

            $table->foreign('superior')->references('id')->on('erp_estructura');
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
        Schema::dropIfExists('erp_estructura');
    }
}
