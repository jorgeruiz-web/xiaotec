<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convenios</title>
    <link rel="stylesheet" href="estilos/estilo_menu.css">
    <script src="https://kit.fontawesome.com/c17113d732.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilos/estilo_convenios.css">
    <link rel="stylesheet" href="estilos/estilo_tabla.css">
    <link rel="icon" href="imagenes/icono.png">
</head>
<body>
    <?php
       $PATH= $_SERVER["DOCUMENT_ROOT"]."/Assets/";
        include($PATH."menu.html");
        
    ?>
     <?php
        $PATH= $_SERVER["DOCUMENT_ROOT"]."/Assets/";
        include($PATH."cabecera.html");

    ?>
    <div style="display: none" class="div"></div>
    <div  class="container">
        <div class="pantalla">
            <form action="/convenios/abonar" style="opacity: 0;pointer-events:none;" class="info_abonar bordeado" method="post">
            @csrf
                <h3>Abonar a convenio #<input value="34" name="info_abono_id" id="info_abono_id"></h3>
                <div class="break"></div>
                <label for="">Nombre Vendedor:</label>
                <span id="info_abono_nombre" >Jorge Luis Pacheco</span>
                <div class="break"></div>
                <label for="">Deuda Actual:</label>
                <span id="info_abono_deuda_act">$700</span>
                <div class="break"></div>
                <label for="">Abono de:</label>
                <span>$</span>
                <input min="0" type="number" name="info_abono_abono" id="info_abono_abono">
                <div class="porcentajes">
                    <a href="#">25%</a>
                    <a href="#">50%</a>
                    <a href="#">100%</a>
                </div>
                <button type="button" class="info_cancelar" >Cancelar</button>
                <button type="button" class="info_Aceptar">Aceptar</button>
            </form>

            
            <div style="opacity: 0;pointer-events:none;"  class="ver_abonos bordeado">
                @if (!empty($id_ver))
                <h3>Abonos de convenio <span style="font-weight: normal" id="ver_abonos_id" >{{$id_ver}}</span></h3>
                <h4>Vendedor: <span style="font-weight: normal" id="ver_abonos_deuda_vend">{{$nombre_vend}}</span></h4>
                <h4>Deuda Inicial: <span style="font-weight: normal" id="ver_abonos_deuda_ini">${{$deuda}}</span></h4>
                <label style="font-weight: bold" for="">Estado: <span style="font-weight: normal; color:var(--filtro-hover)" id="ver_abonos_estado">Pendiente</span></label>
                <div style="box-shadow:none; padding-left:0px; max-height:400px;" class="tabla">
                    <div class="row tabla_encabezado">
                        <div class="row_item">Fecha</div>
                        <div class="row_item">Abono</div>
                        <div class="row_item">Restante</div>
                    </div>
                    @foreach ($abonos as $abono)
                    <div class="row">
                        <div class="row_item">{{$abono['fecha']}}</div>
                        <div class="row_item">${{$abono['abono']}}</div>
                        <div class="row_item">$400</div>
                    </div>
                    @endforeach
                    
                    

                </div>
                <h4>Deuda Actual: <span style="font-weight: normal" id="ver_abonos_deuda_act">$300</span></h4>
                <button class="ver_abonos_boton_volver" >Volver</button>
                @endif

            </div>
            
            <form action="" style="opacity: 0;pointer-events:none;" method="POST" class="mensaje_eliminar bordeado">
               @csrf
                <h3>Eliminar convenio de pago #<span id="mensaje_id">12</span></h3>
                <div class="break"></div>
                <i class="fas fa-exclamation-triangle"></i>
                <div class="break"></div>
                <label for="">Esta acción no podrá ser revertida</label>
                <div class="break"></div>
                <button type="button" id="mensaje_cancelar">Cancelar</button>
                <button id="mensaje_aceptar">Aceptar</button>
            </form>
        </div>
        <div class="titulo_cabecera">
            <h2>Convenios de pago actuales</h2>
        </div>
        <div class="tabla activos">
            
            
            <div class="row tabla_encabezado">
                <div class="row_item">Id Convenio</div>
                <div style="width:16%" class="row_item">Nombre Vendedor</div>
                <div class="row_item">Deuda Total</div>
                <div class="row_item">Cantidad Abonada</div>
                <div class="row_item">Deuda Actual</div>
                <div style="justify-content: center;" class="row_item">Acciones</div>
                <div style="justify-content: center;" class="row_item">Abonos</div>
            </div>
           
            @for ($i = 0; $i < count($convenios_activos); $i++)
                <div class="row">
                    <div class="row_item">{{$convenios_activos[$i]['id']}}</div>
                    <div style="width:16%" class="row_item">{{$nombres_activos[$i]}}</div>
                    <div  class="row_item">${{$convenios_activos[$i]['deuda_total']}}</div>
                    <div  style="color:green;" class="row_item">${{$convenios_activos[$i]['cant_abonada']}}</div>
                    <div  style="color: red;"  class="row_item">$700</div>
                    <div class="row_item">
                        <button class="boton_abonar">Abonar</button>
                        <button data-id="{{$convenios_activos[$i]['id']}}" class="boton_eliminar">Eliminar</button>
                    </div>
                    <div style="justify-content: center;" class="row_item">
                        <form style="display: none;" action="" method="post">
                            @csrf
                            <input name="id_ver" value="{{$convenios_activos[$i]['id']}}" type="text">
                        </form>
                        <button data-tipo="act" data-id="{{$convenios_activos[$i]['id']}}" style="width:60%;" class="boton_ver_abonos" >Ver</button>
                    </div>
                </div>
            @endfor


        </div>
        <div style="padding-bottom: 0px;" class="convenios_finalizados bordeado">
        <h3>Convenios de pago Finalizados</h3><span id="finalizados_visualizar" >Visualizar <i class="fas fa-eye"></i></span>
            <div style="max-height: 0; padding:0; flex-wrap:nowrap; transform: translateY(-20px);" class="tabla finalizados">
                <div class="row tabla_encabezado">
                    <div class="row_item">Id Convenio</div>
                    <div style="width:40%" class="row_item">Nombre Vendedor</div>
                    <div class="row_item">Deuda Total</div>
                   
                    <div   class="row_item">Abonos</div>
                </div>
                @for ($i = 0; $i < count($convenios_finalizados); $i++)
                    <div class="row">
                        <div class="row_item">{{$convenios_finalizados[$i]['id']}}</div>
                        <div style="width:40%" class="row_item">{{$nombres_finalizados[$i]}}</div>
                        <div class="row_item">${{$convenios_finalizados[$i]['deuda_total']}}</div>
                        <div class="row_item">
                            <form style="display: none;" action="" method="post">
                                @csrf
                                <input name="id_ver" value="{{$convenios_finalizados[$i]['id']}}" type="text">
                            </form>
                            <button   data-tipo="fin" data-id="{{$convenios_finalizados[$i]['id']}}" style="width:60%;" class="boton_ver_abonos" >Ver</button>
                        </div>
                    </div>
                @endfor
                
            </div>
        </div>
        </div>
       
    <script src="{{asset('scripts/script_convenios.js')}}"></script>
    @if (!isset($usuario))
    <script>
        var usuario_aux=sessionStorage.getItem("usuario");
        var foto=sessionStorage.getItem("foto");
        if(usuario_aux==null||usuario_aux=="")
        {
            window.location.href="/cerrar_sesion";
        }
        else{
            document.querySelector("#nombre_usuario").innerHTML=usuario_aux;
            document.querySelector(".foto").src="{{asset('imagenes/usuarios/')}}/"+foto;
            document.querySelector(".usuario_auth").addEventListener("click",function(){
                sessionStorage.clear();
                window.location.href="/cerrar_sesion";
            });
        }
        
    </script>
    @endif
</body>
</html>