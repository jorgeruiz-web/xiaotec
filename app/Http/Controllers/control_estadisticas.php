<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\articulos;
use App\ventasconsignacion;
use App\liquidacionesfinalizadas;
use App\ventascontado;
use App\vendedores;
use DateTime;


class control_estadisticas extends Controller
{
    public function cargar_stats()
    {
        $dias_st=request('dias');

        if(!isset($dias_st))
        {
            $dias_st=7;
        }
        if($dias_st==0)
        {
            $dias_st=99999;
        }
       
        $liquidaciones=0;
        $liquidaciones_ventas=0;
        $fecha_hoy=date_create(date('Y-m-d'));
        $ventas_consi=liquidacionesfinalizadas::all();
        for ($i=0; $i < count($ventas_consi); $i++) { 
            $fecha_liqui=date_create($ventas_consi[$i]['fecha_liqui']);
            
            $intervalo = date_diff($fecha_liqui,$fecha_hoy);
            $dias= $intervalo->format('%R%a');
            if($dias<=$dias_st)
            {
                $liquidaciones++;
                $liquidaciones_ventas+=floatval($ventas_consi[$i]['total_venta']);
            }
        }

        $contado=0;
        $contado_ventas=0;
        $ventas_conta=ventascontado::all();

        for ($i=0; $i < count($ventas_conta); $i++) { 
            $fecha_liqui=date_create($ventas_conta[$i]['fecha']);
            
            $intervalo = date_diff($fecha_liqui,$fecha_hoy);
            $dias= $intervalo->format('%R%a');
            if($dias<=$dias_st)
            {
                $contado++;
                $contado_ventas+=floatval($ventas_conta[$i]['total']);
            }
        }
        

        $dias_grafica=array();
        $ventas_consi_grafica=array();
        $ventas_conta_grafica=array();
        for ($i=0; $i < $dias_st; $i++) { 
            $fecha_nueva=$fecha_hoy;
            if($i==0)
            {

            }else{
                date_sub($fecha_nueva, date_interval_create_from_date_string('1'.' days'));
            }
            
            date_format($fecha_nueva, 'Y-m-d');
            $fecha_nueva=$fecha_nueva->format('Y-m-d');

            $ventas_consi_suma=liquidacionesfinalizadas::where("fecha_liqui",$fecha_nueva)->get()->sum('total_venta');
            $ventas_conta_suma=ventascontado::where("fecha",$fecha_nueva)->get()->sum('total');
            $dias_grafica[$i]=$fecha_nueva;
            $ventas_consi_grafica[$i]="$".$ventas_consi_suma;
            $ventas_conta_grafica[$i]="$".$ventas_conta_suma;
        }

        $articulos=articulos::orderBy('vendidos', 'DESC')->get()->take(5);
      /*  $art_ordenados=array();
        for ($i=0; $i < 5; $i++) { 
            try {
                $art_ordenados[$i]=$articulos[$i];
            } catch (\Throwable $th) {
            break;
            }
            
        }*/

        $vendedores=vendedores::where("estado_vend","activo")->get();
        $cant_ventas=array();
        $total_ventas=array();
        $nombres=array();
        $telefonos=array();
        for ($i=0; $i < count($vendedores); $i++) { 
            $ventas_vendedor=ventasconsignacion::where('id_vend',$vendedores[$i]['id_vend'])->get();
            $nombres[$i]=$vendedores[$i]['nombre_vend'];
            $telefonos[$i]=$vendedores[$i]['tel_vend'];
            $total_ventas[$i]=$ventas_vendedor->sum('total');
            $cant_ventas[$i]=count($ventas_vendedor);
        }

        return view("ProyectoFinal/estadisticas",[
            "liqui"=>$liquidaciones,
            "liqui_val"=>$liquidaciones_ventas,
            "conta"=>$contado,
            "conta_val"=>$contado_ventas,
            "dias_grafica"=>$dias_grafica,
            "ventas_consi"=>$ventas_consi_grafica,
            "ventas_conta"=>$ventas_conta_grafica,
            "articulos"=>$articulos,
            "nombres"=>$nombres,
            "total_ventas"=>$total_ventas,
            "cant_ventas"=>$cant_ventas,
            "telefonos"=>$telefonos
        ]);
    }
}
