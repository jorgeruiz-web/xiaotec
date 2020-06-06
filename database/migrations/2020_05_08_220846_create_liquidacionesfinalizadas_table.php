<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiquidacionesfinalizadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liquidacionesfinalizadas', function (Blueprint $table) {
            $table->bigInteger("id_venta")->unsigned();;
            $table->date("fecha_liqui");
            $table->float("total_venta");
        });
        Schema::table('liquidacionesfinalizadas', function($table)
        {
            $table->foreign('id_venta')->references('id_venta')->on('ventasconsignacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('liquidacionesfinalizadas');
    }
}
