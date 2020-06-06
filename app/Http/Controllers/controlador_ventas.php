<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\articulos;
use App\vendedores;
use App\ventascontado;
use App\articuloscontado;
use App\ventasconsignacion;
use App\articulosconsignaciones;
use DateTime;
use App\liquidacionesfinalizadas;
use App\convenios;
use App\abonos;
use App\historial;
use Illuminate\Support\Facades\Date;
use App\archivados;

class controlador_ventas extends Controller
{
     public function cargar_n_venta()
     {
        $articulos=articulos::where("estado_art","activo")->where("stock",">",0)->get();
        $vendedores=vendedores::where("estado_vend","activo")->get();
        return view("ProyectoFinal/nueva_venta",[
            "articulos"=>$articulos,
            "vendedores"=>$vendedores,
        ]); 
     }
     public function nueva_venta()
     {
         $articulos= request('conf_articulos');
         $tipo_venta=request('confirmar_tipo_venta');
         error_log($tipo_venta);
         $nombre=request('confirmar_id_cliente');
         $fecha= date('Y-m-d');
         $total="1";
         if ($tipo_venta=="contado") {
            $nueva_venta=new ventascontado();
            $nueva_venta['cliente']=$nombre;
            $nueva_venta['fecha']=$fecha;
            $nueva_venta['total']=$total;

            $historial=new historial();
            $historial['tipo']="Nueva venta contado";
            $historial['fecha']=new DateTime();
            $historial['descripcion']="Nueva venta de contado a nombre de ".$nombre;
            $historial->timestamps=false;
            $historial->save();

         }
         else{
            $nueva_venta=new ventasconsignacion();
            $nueva_venta['id_vend']=$nombre;
            $nueva_venta['fecha_consi']=$fecha;
            $fecha_limi= date_add( new DateTime($fecha) , date_interval_create_from_date_string("15 days"));
            $nueva_venta['fecha_limi']= $fecha_limi;
            $nueva_venta['total']=$total;
            $nueva_venta['estado']="abierta";

            $historial=new historial();
            $historial['tipo']="Nueva venta consignacion";
            $historial['fecha']=new DateTime();
            $historial['descripcion']="Nueva venta de consignacion al vendedor con id ".$nombre;
            $historial->timestamps=false;
            $historial->save();
         }
         
        
         $nueva_venta->timestamps = false;
         
         try {
            $nueva_venta->save();
            $id_venta=($nueva_venta->id_venta);
           
            $array_id=$articulos['id'];
            error_log(count($array_id));
            $total_venta=0;
            for ($i=0; $i < count($array_id); $i++) { 
                
                $id_articulo=$articulos['id'][$i];
                $cantidad_articulo=$articulos['cantidad'][$i];
                if($tipo_venta=="contado")
                {
                    $articulos_venta=new articuloscontado();
                }
                else{
                    $articulos_venta=new articulosconsignaciones();
                    $articulos_venta['vendidos']=0;
                }
                
                $articulos_venta['id_venta']=$id_venta;
                $articulos_venta['id_articulo']=$id_articulo;
                $articulos_venta['cantidad']=$cantidad_articulo;
                $articulos_venta->timestamps = false;
                $articulos_venta->save();

                $articulo_aux=articulos::where("id_art",$id_articulo)->first();
                $articulo_aux['stock']-=$cantidad_articulo;
                $articulo_aux['vendidos']+=$cantidad_articulo;
                $articulo_aux->timestamps = false;
                $articulo_aux->save();

                $art=articulos::where("id_art",$id_articulo)->first();
                $precio_art=$art['precio_art'];
                $total_venta+=$precio_art*$cantidad_articulo;

            }
            $nueva_venta['total']=$total_venta;
            $nueva_venta->save();
           
            if($tipo_venta=="contado")
            {
                return redirect('/contado');
            }
            else{
                return redirect('/consignacion');
            }

            
         } catch (\Throwable $th) {
           //  error_log($th);
             articuloscontado::where("id_venta",$id_venta)->delete();
            $nueva_venta->delete();
         }
            
       
       
       
        
     }
     public function cargar_consignaciones()
    {
        $ventas_consignacion=ventasconsignacion::where('estado','abierta')->get();
        $nombres_vendedores=array();
        $estados_fecha=array();

        

        for ($i=0; $i < count($ventas_consignacion) ; $i++) { 
            $nombres_vendedores[$i]=vendedores::where("id_vend",$ventas_consignacion[$i]['id_vend'])->first()['nombre_vend'];
            $fecha_consi = date_create(date('Y-m-d'));
            $fecha_limi =date_create($ventas_consignacion[$i]['fecha_limi']);
            $intervalo = date_diff($fecha_consi, $fecha_limi);
            $dias= $intervalo->format('%R%a días');
            if($dias==0)
            {
                $estados_fecha[$i]="LIQUIDA HOY";
            }
            else if($dias<0)
            {
                $estados_fecha[$i]="ATRASADO";
            }
            else{
                $estados_fecha[$i]="A TIEMPO";
            }
        }
        return view("ProyectoFinal/consignacion",[
            'ventas'=>$ventas_consignacion,
            'nombres'=>$nombres_vendedores,
            'condi'=>"false",
            'estados'=>$estados_fecha
        ]);
    }  
    
    public function cargar_consignaciones_ver()
    {
        $id_ver=request("id_ver");
        $venta_ver=ventasconsignacion::where("id_venta",$id_ver)->first();
        $nombre_ver=vendedores::where("id_vend",$venta_ver['id_vend'])->first()['nombre_vend'];
        $ventas_consignacion=ventasconsignacion::where('estado','abierta')->get();
        $nombres_vendedores=array();
        $estados_fecha=array();
        
        $estado_ver="";

        $ver_articulos=articulosconsignaciones::where('id_venta',$id_ver)->get();

        $nombres_articulos=array();
        $precios_articulos=array();
        error_log("corte");
        $i=0;
        foreach ($ver_articulos as $ver_art) {
            $nombre_aux=articulos::where('id_art',$ver_art['id_articulo'])->first();
            $nombres_articulos[$i]=($nombre_aux["nombre_art"]);
            $precios_articulos[$i]=($nombre_aux["precio_art"]);
            $i++;
            
        }

        for ($i=0; $i < count($ventas_consignacion) ; $i++) { 
            $nombres_vendedores[$i]=vendedores::where("id_vend",$ventas_consignacion[$i]['id_vend'])->first()['nombre_vend'];
            $fecha_consi = date_create(date('Y-m-d'));
            $fecha_limi =date_create($ventas_consignacion[$i]['fecha_limi']);
            $intervalo = date_diff($fecha_consi, $fecha_limi);
            $dias= $intervalo->format('%R%a días');
            if($dias==0)
            {
                $estados_fecha[$i]="LIQUIDA HOY";
            }
            else if($dias<0)
            {
                $estados_fecha[$i]="ATRASADO";
            }
            else{
                $estados_fecha[$i]="A TIEMPO";
            }
            if($nombres_vendedores[$i]==$nombre_ver)
            {
                $estado_ver=$estados_fecha[$i];
            }
        }
        return view("ProyectoFinal/consignacion",[
            'ventas'=>$ventas_consignacion,
            'nombres'=>$nombres_vendedores,
            'condi'=>"true",
            'id_ver'=>$id_ver,
            'nombre_ver'=>$nombre_ver,
            'venta_ver'=>$venta_ver,
            'ver_articulos'=>$ver_articulos,
            'nombres_articulos'=>$nombres_articulos,
            'precios_articulos'=>$precios_articulos,
            'estados'=>$estados_fecha,
            'estado_ver'=>$estado_ver
        ]);
    } 

    public function cargar_ventas_contado()
     {
         $ventas_contado=ventascontado::all();
         return view('ProyectoFinal/contado',[
            'ventas_contado'=>$ventas_contado,
         ]);
     }
     public function cargar_ventas_contado_ver()
     {
        $id=request('id_venta');
        $tipo=request('tipo_venta');
        if($tipo=="ver")
        {
            $ver_articulos=articuloscontado::where("id_venta",$id)->get();
            $ver_venta=ventascontado::where("id_venta",$id)->first();
            $ver_total=$ver_venta['total'];
            $nombres_articulos=array();
            $precios_articulos=array();
            error_log("corte");
            $i=0;
            foreach ($ver_articulos as $ver_art) {
                $nombre_aux=articulos::where('id_art',$ver_art['id_articulo'])->first();
                $nombres_articulos[$i]=($nombre_aux["nombre_art"]);
                $precios_articulos[$i]=($nombre_aux["precio_art"]);
                $i++;
                
            }
            $ventas_contado=ventascontado::all();
            return view('ProyectoFinal/contado',[
            'ver_venta'=>$ver_venta,
               'ventas_contado'=>$ventas_contado,
               'ver_articulos'=>$ver_articulos,
               'ver_nombres'=>$nombres_articulos,
               'ver_precios'=>$precios_articulos,
               'ver_total'=>$ver_total
            ]);
        }
        
       
     }
     public function cargar_info_venta_contado()
     {
         $id=request('id');
         $tipo=request('tipo');
         if($tipo=="ver")
         {
             $ver_articulos=articuloscontado::where("id_venta",$id)->get();
             $ver_venta=ventascontado::where("id_venta",$id)->first();
             $ver_total=$ver_venta['total'];
            /* error_log($ver_total);
             error_log($ver_articulos);*/
             $ventas_contado=ventascontado::all();
            
             return redirect()->action('cargar_ventas_contado_ver');
             //return redirect('',302,['ventas_contado'=>$ventas_contado,'ver_articulos'=>$ver_articulos,'ver_total'=>$ver_total]);
             

            /* ['ventas_contado'=>$ventas_contado,
             'ver_articulos'=>$ver_articulos,'ver_total'=>$ver_total]*/ 
         }
     }
     public function liquidar_venta()
     {
        $id_venta=request('id_venta');
        $venta_consi=ventasconsignacion::where("id_venta",$id_venta)->first();
        $articulos=articulosconsignaciones::where("id_venta",$id_venta)->get();
        $nombres=array();
        $precios=array();

        for ($i=0; $i < count($articulos) ; $i++) { 
            $art_2=articulos::where("id_art",$articulos[$i]["id_articulo"])->first();
            $nombres[$i]=$art_2['nombre_art'];
            $precios[$i]=$art_2['precio_art'];
        }



        return view('ProyectoFinal/liquidar_venta',[
            "id_venta"=>$id_venta,
            "venta"=>$venta_consi,
            "nombre"=>vendedores::where("id_vend",$venta_consi["id_vend"])->first()['nombre_vend'],
            "fecha_hoy"=>date('Y-m-d'),
            "articulos"=>$articulos,
            "nombres"=>$nombres,
            "precios"=>$precios
        ]);
     }
     public function liquidar_venta_conf()
     {
        $liquidacion=new liquidacionesfinalizadas();
        $id_venta=request("confirmar_id");
        $total_venta=request("confirmar_total");
        $fecha_liqui=date('Y-m-d');
        $liquidacion['id_venta']=$id_venta;
        $liquidacion['fecha_liqui']=$fecha_liqui;
        $liquidacion['total_venta']=$total_venta;
        $liquidacion['total_comision']=request('comision_vendedor');
        $liquidacion->timestamps = false;
        $liquidacion->save();

        $venta_act=ventasconsignacion::where("id_venta",$id_venta)->first();
        $venta_act['estado']='pagada';
        $venta_act->timestamps = false;
        $venta_act->save();
        
        
        $articulos=request("conf_articulos");
        
        for ($i=0; $i < count($articulos["id"]); $i++) { 
            $articulo_id=$articulos["id"][$i];
            $articulo_cant=$articulos["cantidad"][$i];
            
            $art_aux= articulosconsignaciones::where("id_venta",$id_venta)->get()->where("id_articulo",$articulo_id)->first();
            $art_aux["vendidos"]=$articulo_cant;
            $art_aux->timestamps = false;
            $art_aux->save();

            $cantidad_res=$art_aux['cantidad']-$articulo_cant;
            $articulo_aux=articulos::where("id_art",$articulo_id)->first();

            $articulo_aux['stock']+=$cantidad_res;
            $articulo_aux['vendidos']-=$cantidad_res;
            $articulo_aux->timestamps = false;
            $articulo_aux->save();
                
            
        }
        
        $tipo_pago=request('confirmar_tipo');
        if($tipo_pago=="parcial")
        {
            $convenio=new convenios();
            $convenio['id_vend']=ventasconsignacion::where('id_venta',$id_venta)->first()['id_vend'];
            $convenio['deuda_total']=request('confirmar_deuda');
            $convenio['cant_abonada']='0';
            $convenio->timestamps = false;
            $convenio->save();

            $historial=new historial();
            $historial['tipo']="Nuevo convenio";
            $historial['fecha']=new DateTime();
            $historial['descripcion']="Se creo convenio de pago para la venta ".$id_venta;
            $historial->timestamps=false;
            $historial->save();

        }

        $historial=new historial();
        $historial['tipo']="Liquidacion";
        $historial['fecha']=new DateTime();
        $historial['descripcion']="La venta ".$id_venta. " ha sido liquidada";
        $historial->timestamps=false;
        $historial->save();

        return redirect("liquidacion");
     }

     public function cargar_convenios()
     {
         $convenios=convenios::all();
         $convenios_activos=array();
         $nombres_activos=array();
         $convenios_finalizados=array();
         $nombres_finalizados=array();
         $index_act=0;
         $index_fin=0;
         
         foreach ($convenios as $conv) {
             $deuda=$conv['deuda_total'];
             $abonos=$conv['cant_abonada'];
             $nombre=vendedores::where("id_vend",$conv['id_vend'])->first()['nombre_vend'];
             if($deuda-$abonos<=0)
             {
                 $convenios_finalizados[$index_fin]=$conv;
                 $nombres_finalizados[$index_fin]=$nombre;
                 $index_fin++;
             }
             else{
                 $convenios_activos[$index_act]=$conv;
                 $nombres_activos[$index_act]=$nombre;
                 $index_act++;
             }
             
         }
        


          return view("ProyectoFinal/Convenios",[
            "convenios_activos"=>$convenios_activos,
            "convenios_finalizados"=>$convenios_finalizados,
            "nombres_activos"=>$nombres_activos,
            "nombres_finalizados"=>$nombres_finalizados
          ]);
     }

     public function cargar_convenios_ver()
     {
        $id_ver=request('id_ver');
        $convenios=convenios::all();
        $convenios_activos=array();
        $nombres_activos=array();
        $convenios_finalizados=array();
        $nombres_finalizados=array();
        $index_act=0;
        $index_fin=0;
       

        $conv_aux=convenios::where('id',$id_ver)->first();
        $deuda_vend=$conv_aux['deuda_total'];
        $nombre_vend=vendedores::where("id_vend",$conv_aux['id_vend'])->first()['nombre_vend'];
        foreach ($convenios as $conv) {
            $deuda=$conv['deuda_total'];
            $abonos=$conv['cant_abonada'];
            $nombre=vendedores::where("id_vend",$conv['id_vend'])->first()['nombre_vend'];
            if($deuda-$abonos<=0)
            {
                $convenios_finalizados[$index_fin]=$conv;
                $nombres_finalizados[$index_fin]=$nombre;
                $index_fin++;
            }
            else{
                $convenios_activos[$index_act]=$conv;
                $nombres_activos[$index_act]=$nombre;
                $index_act++;
            }
           
        }
         
        $abonos_vend=abonos::where('id_convenio',$id_ver)->get();
         return view("ProyectoFinal/Convenios",[
           "convenios_activos"=>$convenios_activos,
           "convenios_finalizados"=>$convenios_finalizados,
           "nombres_activos"=>$nombres_activos,
           "nombres_finalizados"=>$nombres_finalizados,
           "id_ver"=>$id_ver,
           "deuda"=>$deuda_vend,
           "abonos"=>$abonos_vend,
           "nombre_vend"=>$nombre_vend
         ]);
     }
     public function abonar_convenio()
     {
        $id_convenio=request('info_abono_id');
        $abono=request('info_abono_abono');
        $abono_nuevo=new abonos();
        $convenio=convenios::where('id',$id_convenio)->first();
        
         $abono_nuevo['id_convenio']=$id_convenio;
         $abono_nuevo['fecha']=date('Y-m-d');
         $abono_nuevo['abono']=$abono;
         $abono_nuevo->timestamps = false;
         $abono_nuevo->save();

         $convenio['cant_abonada']+=floatval($abono);
         $convenio->timestamps = false;
         $convenio->save();

         $historial=new historial();
         $historial['tipo']="Abono";
         $historial['fecha']=new DateTime();
         $historial['descripcion']="Se abonó $".$abono. " al convenio ".$id_convenio;
         $historial->timestamps=false;
         $historial->save();

         return redirect("Convenios");
     }
     public function eliminar_convenio()
     {
         $id_conv=request('id');
         abonos::where('id_convenio',$id_conv)->delete();
         convenios::where('id',$id_conv)->first()->delete();
         return redirect("Convenios");

         $historial=new historial();
         $historial['tipo']="Eliminación de convenio";
         $historial['fecha']=new DateTime();
         $historial['descripcion']="Se eliminó el convenio ".$id_conv;
         $historial->timestamps=false;
         $historial->save();
     }

     public function cargar_liquidaciones_fin()
     {
         $liquidaciones=liquidacionesfinalizadas::all();
         $nombres=array();
         $fechas=array();
         for ($i=0; $i < count($liquidaciones); $i++) { 
             $id_venta=$liquidaciones[$i]['id_venta'];
             $venta=ventasconsignacion::where("id_venta",$id_venta)->first();
             $nombres[$i]=vendedores::where("id_vend",$venta["id_vend"])->first()['nombre_vend'];
             $fechas[$i]=$venta["fecha_consi"];
         }
         
        return view('ProyectoFinal/liquidacion',[
            "liquidaciones"=>$liquidaciones,
            "nombres"=>$nombres,
            "fechas"=>$fechas
        ]);
     }
     public function cargar_liquidaciones_ver()
     {
        $liquidaciones=liquidacionesfinalizadas::all();
        $nombres=array();
        $fechas=array();
        for ($i=0; $i < count($liquidaciones); $i++) { 
            $id_venta=$liquidaciones[$i]['id_venta'];
            $venta=ventasconsignacion::where("id_venta",$id_venta)->first();
            $nombres[$i]=vendedores::where("id_vend",$venta["id_vend"])->first()['nombre_vend'];
            $fechas[$i]=$venta["fecha_consi"];
        }

        $id_venta=request('id_venta');
        $info_venta_fin=liquidacionesfinalizadas::where("id_venta",$id_venta)->first();
        $info_venta=ventasconsignacion::where("id_venta",$id_venta)->first();
        $nombre_vend=vendedores::where("id_vend",$info_venta['id_vend'])->first()['nombre_vend'];

        $articulos=articulosconsignaciones::where('id_venta',$id_venta)->get()->where("vendidos",'>',0);
        $nombres_articulos=array();
        $precios_articulos=array();

        for ($i=0; $i < count($articulos); $i++) { 
            $art_aux=$articulos[$i];
            $nombres_articulos[$i]=articulos::where("id_art",$art_aux['id_articulo'])->first()['nombre_art'];
            $precios_articulos[$i]=articulos::where("id_art",$art_aux['id_articulo'])->first()['precio_art'];
        }
        
       return view('ProyectoFinal/liquidacion',[
           "liquidaciones"=>$liquidaciones,
           "nombres"=>$nombres,
           "fechas"=>$fechas,
           "info_venta_fin"=>$info_venta_fin,
           "info_venta"=>$info_venta,
           "nombre_vend"=>$nombre_vend,
           "articulos"=>$articulos,
           "nombres_art"=>$nombres_articulos,
           "precios_art"=>$precios_articulos
       ]);
     }
     public function cargar_archivados()
     {
         $archivados=archivados::all();
         return view("ProyectoFinal/archivados",["archivados"=>$archivados]);
     }
     public function archivar_venta()
     {
         $tipo=request('tipo_oculto');
         $id=request("nombre_oculto");
         
         if($tipo=="consignacion")
         {
             $archivada=new archivados();
             $archivada['tipo_venta']=$tipo;
             $venta=ventasconsignacion::where("id_venta",$id)->first();
             $archivada['vendedor']=vendedores::where("id_vend",$venta['id_vend'])->first()['nombre_vend'];
             $archivada['total_venta']=$venta['total'];
             $archivada['fecha_venta']=$venta['fecha_consi'];
             $archivada->timestamps=false;
            $archivada->save();

            $liquidacion=liquidacionesfinalizadas::where("id_venta",$id)->first()->delete();
            $articulos_consi=articulosconsignaciones::where('id_venta',$id)->delete();
            $venta->delete();
         }
         else{
            $archivada=new archivados();
            $venta=ventascontado::where("id_venta",$id)->first();
            $archivada['tipo_venta']=$tipo;
            $archivada['vendedor']=$venta['cliente'];
            $archivada['total_venta']=$venta['total'];
            $archivada['fecha_venta']=$venta['fecha'];
            $archivada->timestamps=false;
            $archivada->save();

            articuloscontado::where("id_venta",$id)->delete();
            $venta->delete();
            
         }
  
         $archivados=archivados::all();
         return redirect("/archivados");
     }
}
