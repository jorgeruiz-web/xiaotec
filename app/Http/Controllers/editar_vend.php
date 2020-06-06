<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\vendedores;
use App\ventasconsignacion;
use App\liquidacionesfinalizadas;

class editar_vend extends Controller
{
    
    public function id_vend(){
        try {
            $id=request('id');
            $info=vendedores::findOrFail($id);
            $comisiones=array();
            $fechas=array();
            $ventas=ventasconsignacion::where("id_vend",$id)->get();
            $cant_ventas=count($ventas);
            $comisiones_tot=0;
            $info_vend=vendedores::where('id_vend',$id)->first();
            $estado=strtoupper($info_vend['estado_vend']);
            $fecha_reg=$info_vend['fecha_reg'];
            for ($i=0; $i < count($ventas); $i++) { 
                if($ventas[$i]['estado']=="pagada")
                {
                    $comisiones[$i]=liquidacionesfinalizadas::where("id_venta",$ventas[$i]['id_venta'])->first()['total_comision'];
                    $fechas[$i]=liquidacionesfinalizadas::where("id_venta",$ventas[$i]['id_venta'])->first()['fecha_liqui'];
                    $comisiones_tot+=floatval($comisiones[$i]);
                }
                else{
                    $comisiones[$i]='N/A';
                    $fechas[$i]="Pendiente";
                }
            }
    
            return view('ProyectoFinal/edit_vend',[
                'id'=>$id,
                'vendedor1'=>$info,
                'ventas'=>$ventas,
                'comisiones'=>$comisiones,
                'fechas'=>$fechas,
                'cant_ventas'=>$cant_ventas,
                'comisiones_total'=>$comisiones_tot,
                'estado'=>$estado,
                'fecha_reg'=>$fecha_reg
            ]);
        } catch (\Throwable $th) {
            return redirect('/vendedores');
        }

    }
}
