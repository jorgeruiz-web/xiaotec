<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasconsignacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventasconsignacion', function (Blueprint $table) {
            $table->bigIncrements('id_venta');
            $table->bigInteger('id_vend')->unsigned();
            $table->date('fecha_consi');
            $table->date('fecha_limi');
            $table->float('total');
        });

        Schema::table('ventasconsignacion', function($table)
        {
            $table->foreign('id_vend')->references('id_vend')->on('vendedores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventasconsignacion');
    }
}
