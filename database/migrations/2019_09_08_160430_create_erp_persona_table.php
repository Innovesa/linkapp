<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErpPersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_persona', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre',200);
            $table->integer('idTipoPersona');
            $table->integer('idEstado');
            $table->timestamps();
            
            $table->foreign('idTipoPersona')->references('id')->on('erp_tipo_persona');
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
        Schema::dropIfExists('erp_persona');
    }
}
