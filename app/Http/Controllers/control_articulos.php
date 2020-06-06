<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\articulos;
use App\categorias;
use Illuminate\Support\Facades\File;
use App\historial;
use DateTime;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\excel_art;


use function GuzzleHttp\Promise\all;

class control_articulos extends Controller
{
    public function cargar_articulos()
    {
        $categorias=categorias::all();
        $articulos=articulos::where("estado_art","activo")->get();
        return view("ProyectoFinal/articulos",[
            "articulos"=>$articulos,
            "categorias"=>$categorias,
        ]); 

    }
    public function subir_articulo()
    {
        $nombre=request('info_nombre');
        $precio=request('info_precio');
        $stock=request('info_stock');
        $categoria=request('info_categoria');
        $foto=request('filename');
        $foto_nombre=$foto->getClientOriginalName();
        $foto_nombre=rand(1000,10000).'-'.$foto_nombre;
       
        
        $articulo=new articulos();
        $articulo['nombre_art']=$nombre;
        $articulo['precio_art']=$precio;
        $articulo['stock']=$stock;
        $articulo['categoria']=$categoria;
        $articulo['imagen']=$foto_nombre;
        $articulo['vendidos']=0;
        $articulo['estado_art']="activo";
        $articulo->timestamps = false;
        $articulo->save();
        $foto-> move(public_path()."/imagenes/articulos/", $foto_nombre);
        $articulos=articulos::all();

        
        $historial=new historial();
        $historial['tipo']="Articulo registrado";
        $historial['fecha']=new DateTime();
        $historial['descripcion']="Se ha registrado el articulo ".$articulo['nombre_art'];
        $historial->timestamps=false;
        $historial->save();

        return redirect('/articulos'); 
        
    }
    public function editar_articulo()
    {   
        $id_art=request("id_edicion");
        $art_=articulos::where('id_art',$id_art)->get()[0];
        error_log($art_);
        $tipo=request('tipo');
        if ($tipo=="eliminar") {
            $imagen=$art_['imagen'];
            
            $art_["estado_art"]="baja";
            $art_->timestamps=false;
            $art_->save();
            File::delete("imagenes/articulos/".$imagen);
        }
        else{
            
            $foto=request('imagen_edicion');
            if($foto)
            {
                $foto_nombre=$foto->getClientOriginalName();
                $foto_nombre=rand(1000,10000).'-'.$foto_nombre;
                $imagen=$art_['imagen'];
                $art_['imagen']=$foto_nombre;
            }
           
            $art_['nombre_art']=request('nombre_edicion');
            $art_['precio_art']=request('precio_edicion');
            $art_['stock']=request('cantidad_edicion');
            $art_['categoria']=request('categoria_edicion');


           

            $art_->timestamps = false;
            $art_->save();
            if($foto){
            File::delete("imagenes/articulos/".$imagen);
            $foto-> move(public_path()."/imagenes/articulos/", $foto_nombre);
            }
        }
       
        $historial=new historial();
        $historial['tipo']="Articulo modificado";
        $historial['fecha']=new DateTime();
        $historial['descripcion']="Se ha modificado el articulo ".$art_['nombre_art'];
        $historial->timestamps=false;
        $historial->save();

        return redirect('/articulos');
    }
    public function cargar_inventario()
    {
        $articulos=articulos::where("estado_art","activo")->get();
        return view("ProyectoFinal/inventario_art",[
            "articulos"=>$articulos,
        ]); 
    }
    public function cargar_categorias()
    {
        $categorias=categorias::all();
        return view("ProyectoFinal/registrar_articulo",[
            "categorias"=>$categorias,
        ]); 
    }
    public function editar_categoria()
    {
        $tipo=request('tipo');
        error_log($tipo);
        if ($tipo==0) {
            $categoria_nueva=new categorias();
            $categoria_nueva['nombre']=request('nombre_cat');
            $categoria_nueva->timestamps = false;
            $categoria_nueva->save();
        }
        else{
            $id=request('id_art_edi');
            error_log($id);
            categorias::where("id",$id)->first()->delete();
        }
    
        return redirect('/registrar_articulo');
    }
    public function descargar_articulos()
    {
        return Excel::download(new excel_art,"articulos.xlsx");
    }
}
