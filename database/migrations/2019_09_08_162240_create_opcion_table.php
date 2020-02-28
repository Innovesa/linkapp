<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpcionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opcion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',45);
            $table->string('descripcion',200);
            $table->string('icono',45);
            $table->string('accion',200);
            $table->integer('superior')->nullable()->unsigned();
            $table->integer('idEstado')->unsigned();
            $table->timestamps();

            $table->foreign('idEstado')->references('id')->on('estado');
            $table->foreign('superior')->references('id')->on('opcion');

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
        Schema::dropIfExists('opcion');
    }
}
