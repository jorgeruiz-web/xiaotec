<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\usuarios;

class login_control extends Controller
{
    public function cargar()
    {
        return view("ProyectoFinal/login");
    }
    public function iniciar_sesion()
    {
        $usuario=request('usuario');
        $contra=request('contra');

        $resultado=false;
        $msj="Contraseña Incorrecta";
        $contra_bd=usuarios::where('usuario',$usuario)->first()['contra'];
        if($contra_bd==null)
        {
            $resultado=false;
            $msj="Usuario Inexistente";
            return view("ProyectoFinaL/login",[
                "resultado"=>$resultado,
                "mensaje"=>$msj
            ]);
        }
        else{
            if($contra_bd==$contra)
            {
                session()->put('usuario', $usuario);
                session()->put('foto',usuarios::where("usuario",$usuario)->first()['foto']);
                session()->put('rol', usuarios::where("usuario",$usuario)->first()['rol']);
                return redirect("/inicio");
            }
            else{
                $resultado=false;
                $msj="Contraseña Incorrecta";
                return view("ProyectoFinaL/login",[
                    "resultado"=>$resultado,
                    "mensaje"=>$msj
                ]);
            }
            $resultado=true;
        }
        
    }
    public function cerrar_sesion()
    {
        session()->forget('usuario');
        return redirect("/login");
    }
}
