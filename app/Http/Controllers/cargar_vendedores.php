<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\vendedores;
use App\historial;
use DateTime;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\excel_vend;


use function GuzzleHttp\Promise\all;

class cargar_vendedores extends Controller
{
    //
    public function cargar_vendedores()
    {
        $vendedores=vendedores::orderBy('estado_vend', 'ASC')->get();
        return view('ProyectoFinal/vendedores',[
            'vendedores'=>$vendedores,
        ]);
    }
    public function guardar_vendedor()
    {
        $vendedor=new vendedores();
        $vendedor['nombre_vend']=request('nombre');
        $vendedor['direccion_vend']=request('direccion');
        $vendedor['tel_vend']=request('telefono');
        $vendedor['fecha_nac_vend']=request('fecha_nac');
        $vendedor['rfc_vend']=request('rfc');
        $vendedor['estado_vend']="activo";
        $vendedor['fecha_reg']=date('Y-m-d');
        $vendedor->timestamps = false;
        $vendedor->save();
        $vendedores=vendedores::all();

       
        
        $historial=new historial();
        $historial['tipo']="Registro de vendedor";
        $historial['fecha']=new DateTime();
        $historial['descripcion']="El vendedor ".$vendedor['nombre_vend']." ha sido registrado";
        $historial->timestamps=false;
        $historial->save();
        

      
        return view('ProyectoFinal/vendedores',[
            'vendedores'=>$vendedores,
        ]);
        
    }
    public function descargar_vendedor()
    {
        
        return Excel::download(new excel_vend,"vendedores.xlsx");
    }
    public function editar_vendedor()
    {
        /*NO TERMINADO*/ 
        $vendedor=vendedores::where('id_vend',request('id_vend'))->first();
        $vendedor['nombre_vend']=request('datos_nombre');
        $vendedor->timestamps = false;
        $vendedor->save();

        $historial=new historial();
        $historial['tipo']="Vendedor editado";
        $historial['fecha']=new DateTime();
        $historial['descripcion']="Se ha modificado la información del vendedor ".$vendedor['nombre_vend'];
        $historial->timestamps=false;
        $historial->save();

        return redirect('/vendedores');
    }
    public function borrar_vendedor(){
        $vend=vendedores::where('id_vend',request('id_vend'))->first();
        $vend['estado_vend']="baja";
        $vend->timestamps=false;
        $vend->save();
        /*vendedores::where("id_vend",request('id_vend'))->delete();*/

        $historial=new historial();
        $historial['tipo']="Vendedor eliminado";
        $historial['fecha']=new DateTime();
        $historial['descripcion']="Se ha eliminado el vendedor con id ".request('id_vend');
        $historial->timestamps=false;
        $historial->save();
        return redirect('/vendedores');

    }


}
