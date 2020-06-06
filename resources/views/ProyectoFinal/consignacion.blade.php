<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consignacion</title>
    <link rel="stylesheet" href="estilos/estilo_menu.css">
    <script src="https://kit.fontawesome.com/c17113d732.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilos/estilo_consignacion.css">
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
    <div class="container"> 
        <button onclick="window.location.href='{{URL::asset('nueva_venta')}}'" id="boton_nueva_venta"  >Nueva venta</button>
        <div style="padding-bottom: 0;" class="filtros bordeado">
            <h3>Filtrar</h3>
            <div class="busqueda">
                <div class="break"></div>
                <i class="fas fa-search"></i>
                <input type="text" name="" id="busqueda_nombre" placeholder="Nombre/id/telefono">
                <button class="bus">Buscar</button>
                <div class="filtros_act">
                    
                </div>
                
            </div>
        </div>
        <div class="tabla consigna">
            <div class="row tabla_cabecera">
                <div class="row_item">Id Venta</div>
                <div style="width: 25%" class="row_item">Vendedor</div>
                <div style="width: 19%" class="row_item">Fecha para liquidar</div>
                <div class="row_item">Estado</div>
                <div class="row_item">Cantidad</div>
                <div style="width: 30%" class="row_item">Acciones</div>
                <div style="font-size: 16px; color:black;" class="row_item">Articulos</div>
            </div>
            @for ($i = 0; $i < count($ventas); $i++)
                <div class="row">
                    <div class="row_item">{{$ventas[$i]['id_venta']}}</div>
                    <div style="width: 25%" class="row_item">{{$nombres[$i]}}</div>
                    <div style="width: 19%" class="row_item">{{$ventas[$i]['fecha_limi']}}</div>
                    <div style="color:green;" class="row_item estados_consi">{{$estados[$i]}}</div>
                    <div class="row_item">${{$ventas[$i]['total']}}</div>
                    <div style="width: 30%" class="row_item">
                        <form method="POST" action="liquidar_venta">
                            @csrf
                            <input style="display: none;" name="id_venta" id="id_venta" value="{{$ventas[$i]['id_venta']}}" type="text">
                            <button type="button" data-id="{{$ventas[$i]['id_venta']}}" class="btn_liquidar">Liquidar</button>
                            <button data-id="{{$ventas[$i]['id_venta']}}" class="btn_editar">Editar</button>
                        </form>
                        
                    </div>
                    <div class="row_item ">
                        <form action="" method="post">
                            @csrf
                            <input style="display: none;" value="" name="id_ver" class="id_forma" type="text">
                            <button style="width:65%" data-id="{{$ventas[$i]['id_venta']}}" class="ver_articulos">ver</button>
                        </form>
                        
                    </div>
                </div>
            @endfor
            

        </div>
        <div id="pantalla" class="pantalla">
            @if ($condi=="true")
            <div class="detalles bordeado">
                    <h2>Detalles de la venta <span id="detalles_id">{{$id_ver}}</span></h2>
                    <div class="informacion">
                    <label for="">Vendedor: <span id="ver_nombre">{{$nombre_ver}}</span></label>
                    <div class="break"></div>
                    <label for="">Fecha de despacho: <span id="fecha_consi_ver">{{$venta_ver['fecha_consi']}}</span></label>
                    <div class="break"></div>
                    <label for="">Fecha límite para liquidar: <span id="fecha_limi_ver">{{$venta_ver['fecha_limi']}}</span></label>
                    <div class="break"></div>
                    <label for="">Estado: <span style="color:green;" id="estado_ver">{{$estado_ver}}</span></label>
                    <div class="break"></div>
                    <label for="">Total: <span style="color:green;" id="total_ver">$4000</span></label>
                </div>
                <div class="articulos">
                    
                    <div style="box-shadow:none;" class="tabla articulos_ver">
                        <div class="row tabla_cabecera">
                            <div class="row_item">Id Articulo</div>
                            <div class="row_item">Nombre</div>
                            <div class="row_item">Cantidad</div>
                            <div class="row_item">Precio Unidad</div>
                            <div style="font-size: 16px; color:black;" class="row_item">Precio Total</div>
                        </div>
                        @for ($i = 0; $i < count($ver_articulos); $i++)
                            <div class="row">
                                <div class="row_item">{{$ver_articulos[$i]['id_articulo']}}</div>
                                <div class="row_item">{{$nombres_articulos[$i]}}</div>
                                <div class="row_item">{{$ver_articulos[$i]['cantidad']}}</div>
                                <div class="row_item">${{$precios_articulos[$i]}}</div>
                                <div style="font-size: 16px; color:black;" class="row_item">$2500</div>
                            </div>
                        @endfor
                      
                       


                        
                    </div>
                    
                </div>
                <button id="btn_volver">Volver</button>
            </div>
            @endif
           
        </div>
        
    </div>
    <script src="{{ URL::asset('scripts/script_consignacion.js') }}"></script>
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