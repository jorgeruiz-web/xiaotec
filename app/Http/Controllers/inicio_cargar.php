<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\vendedores;
use App\articulos;
use App\ventasconsignacion;
use App\ventascontado;

class inicio_cargar extends Controller
{
    public function cargar_todo()
    {
        $cant_vendedores=count(vendedores::where("estado_vend","activo")->get());
        $cant_consi=count(ventasconsignacion::where("estado","abierta")->get());
        $cant_liqui=count(ventasconsignacion::where("estado","pagada")->get());
        $cant_contado=count(ventascontado::all());

        $articulos=articulos::where("estado_art","activo")->where("stock",'>',0)->get();
        $inventario=0;
        foreach ($articulos as $art) {
            $stock=intval($art['stock']);
            $precio=floatval($art['precio_art']);
            $inventario+=($stock*$precio); 
        }

        error_log($cant_vendedores);
        $usuario=session()->get('usuario');
        $foto=session()->get('foto');
        $rol=session()->get('rol');
        error_log($usuario);
        return view('ProyectoFinal/inicio',[
            "cant_vend"=>$cant_vendedores,
            "cant_consi"=>$cant_consi,
            "cant_liqui"=>$cant_liqui,
            "cant_cont"=>$cant_contado,
            "inventario"=>$inventario,
            "usuario"=>$usuario,
            "foto"=>$foto,
            "rol"=>$rol
           
        ]);
    }
}
