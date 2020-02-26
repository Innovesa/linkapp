<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persona', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cedula',15)->unique();
            $table->string('nombre',200);
            $table->string('alias',200)->nullable();
            $table->string('img',250);
            $table->integer('idTipoIdenticacion')->unsigned();
            $table->integer('idEstado')->unsigned();
            $table->timestamps();
            
            $table->foreign('idTipoIdenticacion')->references('id')->on('tipo_Identicacion');
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
        Schema::dropIfExists('persona');
    }
}
