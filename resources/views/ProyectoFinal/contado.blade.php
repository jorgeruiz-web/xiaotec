
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contado</title>
    <link rel="stylesheet" href="{{asset('estilos/estilo_menu.css')}}">
    <script src="https://kit.fontawesome.com/c17113d732.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('estilos/estilo_contado.css')}}">
    <link rel="stylesheet" href="{{asset('estilos/estilo_tabla.css')}}">
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
        <div class="titulo_cabecera"><h2 >Ventas de contado</h2></div> 
        <div style="padding-bottom:0%;" class="filtrar bordeado">
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
        <div class="tabla liquidaciones">
            <div class="row tabla_encabezado">
                <div class="row_item">Id Venta</div>
                <div style="width: 28%;" class="row_item">Cliente</div>
                <div class="row_item">Fecha de venta</div>
                <div class="row_item">Total venta</div>
                <div style="justify-content:center;" class="row_item">Acciones</div>
            </div>
            @foreach ($ventas_contado as $venta)
            <div class="row">
                <div class="row_item">{{$venta['id_venta']}}</div>
                <div style="width: 28%;" class="row_item">{{$venta['cliente']}}</div>
                <div class="row_item">{{$venta['fecha']}}</div>
                <div style="color: green;" class="row_item">${{$venta['total']}}</div>
                <div class="row_item">
                    <button class="boton_ver">Ver</button>
                    <button data-id="{{$venta['id_venta']}}" class="boton_archivar">Archivar</button>
                </div>
            </div>
            @endforeach
           
            
        </div>
        <div style="margin-top:15px; cursor:pointer;" id="archivados" class="titulo_cabecera">
            <h2>Ver Ventas Archivadas</h2>
        </div>
       

        @if (!empty($ver_articulos))
        <div style="opacity:0; pointer-events:none;" id="pantalla" class="pantalla">
            <div  class="detalles bordeado">
                <h2>Detalles de la venta <span id="detalles_id">{{$ver_venta['id_venta']}}</span></h2>
                <div class="informacion">
                    <label for="">Cliente: <span id="info_vend">{{$ver_venta['cliente']}}</span></label>
                    <div class="break"></div>
                    <label for="">Fecha de venta: <span id="info_vend">{{$ver_venta['fecha']}}</span></label>
                    <div class="break"></div>
                    <label for="">Total de venta: <span style="color:green;" id="info_vend">${{$ver_total}}</span></label>
                    
                </div>
                <div class="articulos">
                    <h4>Articulos:</h4>
                    <div style="box-shadow:none;" class="tabla artic">
                        <div class="row tabla_encabezado">
                            <div class="row_item">Id Articulo</div>
                            <div class="row_item">Nombre</div>
                            <div class="row_item">Cantidad</div>
                            <div class="row_item">Precio Unidad</div>
                            <div style="font-size: 16px; color:black;" class="row_item">Total Venta</div>
                        </div>
                            @for ($i = 0; $i < count($ver_nombres); $i++)
                            <div class="row">
                                <div class="row_item">{{$ver_articulos[$i]['id_articulo']}}</div>
                                <div class="row_item">{{$ver_nombres[$i]}}</div>
                                <div class="row_item row_cantidad">{{$ver_articulos[$i]['cantidad']}}</div>
                                <div class="row_item row_precio">${{$ver_precios[$i]}}</div>
                                <div style="font-size: 16px; color:black;" class="row_item row_total">0</div>
                            </div>
                            @endfor
                         
                        
                       
                       
                        

                    </div>
                    
                </div>
                <button id="btn_volver">Volver</button>
               
            </div>
            <div class="mensaje_archivar bordeado">
                <h3>Desea archivar liquidación #<span id="mensaje_id">1</span></h3>
                <div class="break"></div>
                <i class="fas fa-exclamation-triangle"></i>
                <div class="break"></div>
                <label for="">Esta acción no podrá ser revertida</label>
                <div class="break"></div>
                <form id="forma_archivar" method="POST" action="/archivados">
                    @csrf
                        <input value="" name="nombre_oculto" id="nombre_oculto" type="text">
                        <input style="display:none;" value="contado" name="tipo_oculto" id="tipo_oculto" type="text">
                        <button type="button" name="eliminar_cancelar">Cancelar</button>
                        <button name="eliminar-aceptar">Eliminar</button>
                   </form>
            </div>
        </div>
        @endif
        

            <form id="forma_id" action="" method="POST">
                @csrf
                <input name="id_venta" id="id_venta" type="text" value="">
                <input name="tipo_venta" id="tipo_venta" type="text" value="ver">
            </form>
    </div>
    <script src="{{asset('scripts/script_contado.js')}}"></script>
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