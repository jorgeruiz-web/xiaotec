<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticuloscontadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articuloscontado', function (Blueprint $table) {
            $table->bigInteger('id_venta')->unsigned();
            $table->bigInteger('id_articulo')->unsigned();
            $table->foreign('id_articulo')->references('id_art')->on('articulos');
            
            $table->foreign('id_venta')->references('id_venta')->on('ventascontado');
            $table->integer('cantidad');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articuloscontado');
    }
}
