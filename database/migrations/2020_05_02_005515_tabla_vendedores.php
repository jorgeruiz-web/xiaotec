<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TablaVendedores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('vendedores',function(Blueprint $vendedores){
            $vendedores->bigIncrements('id_vend');
            $vendedores->string('nombre_vend');
            $vendedores->string('direccion_vend');
            $vendedores->string('tel_vend',11);
            $vendedores->date('fecha_nac_vend');
            $vendedores->char('rfc_vend',20);
            $vendedores->string('estado_vend');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendedores');
    }
}
