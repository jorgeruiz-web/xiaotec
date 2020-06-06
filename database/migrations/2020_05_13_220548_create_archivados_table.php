<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArchivadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archivados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("tipo_venta");
            $table->string("vendedor");
            $table->float("total_venta");
            $table->date("fecha_venta");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('archivados');
    }
}
