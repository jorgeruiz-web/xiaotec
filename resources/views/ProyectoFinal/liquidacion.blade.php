
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liquidaciones</title>
    <link rel="stylesheet" href="estilos/estilo_menu.css">
    <script src="https://kit.fontawesome.com/c17113d732.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilos/estilo_liquidaciones.css">
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
        <div class="titulo_cabecera"><h2 >Liquidaciones Finalizadas</h2></div> 
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
                <div style="width: 28%;" class="row_item">Vendedor</div>
                <div class="row_item">Fecha Consignación</div>
                <div class="row_item">Fecha Liquidación</div>
                <div class="row_item">Total Venta</div>
                <div style="justify-content:center;" class="row_item">Acciones</div>
            </div>
            
            @for ($i = 0; $i < count($liquidaciones); $i++)
                <div class="row">
                    <div class="row_item">{{$liquidaciones[$i]['id_venta']}}</div>
                    <div style="width: 28%;" class="row_item">{{$nombres[$i]}}</div>
                    <div class="row_item">{{$fechas[$i]}}</div>
                    <div class="row_item">{{$liquidaciones[$i]['fecha_liqui']}}</div>
                    <div style="color: green" class="row_item">${{$liquidaciones[$i]['total_venta']}}</div>
                    <div class="row_item">
                        <button style="width:40%;" class="boton_ver">Ver</button>
                        <button data-id="{{$liquidaciones[$i]['id_venta']}}" style="width:58%;" class="boton_archivar">Archivar</button>
                    </div>
                </div>
            @endfor
           
         
        </div>
        <div style="margin-top:15px; cursor:pointer;" id="archivados" class="titulo_cabecera">
            <h2>Ver Ventas Archivadas</h2>
        </div>
        
        
        @if (isset($info_venta_fin))
        <div style="opacity:0; pointer-events:none;" id="pantalla" class="pantalla">
            <div  class="detalles bordeado">
                <h2>Detalles de la venta <span id="detalles_id">{{$info_venta_fin['id_venta']}}</span></h2>
                <div class="informacion">
                    <label for="">Vendedor: <span id="detalles_nombre">{{$nombre_vend}}</span></label>
                    <div class="break"></div>
                    <label for="">Fecha de consignación: <span id="detalles_fechaconsi">{{$info_venta['fecha_consi']}}</span></label>
                    <div class="break"></div>
                    <label for="">Fecha de liquidación: <span id="detalles_fechaliqui">{{$info_venta_fin['fecha_liqui']}}</span></label>
                    <div class="break"></div>
                    <label for="">Total liquidado: <span style="color:green;" id="detalles_total_liqui">${{$info_venta_fin['total_venta']}}</span></label>
                    <div class="break"></div>
                    <label for="">Comisión de vendedor: <span style="color:rgb(160, 0, 0);" id="detalles_total_comi">${{$info_venta_fin['total_comision']}}</span></label>
                    <div class="break"></div>
                    <label for="">Total Venta: <span style="color:green;" id="detalles_total_venta">${{$info_venta_fin['total_comision']}}</span></label>
                </div>
                <div class="articulos">
                    <h4>Articulos:</h4>
                    <div style="box-shadow:none;" class="tabla">
                        <div class="row tabla_encabezado">
                            <div class="row_item">Id Articulo</div>
                            <div class="row_item">Nombre</div>
                            <div class="row_item">Vendidos</div>
                            <div class="row_item">Precio Unidad</div>
                            <div style="font-size: 16px; color:black;" class="row_item">Total Venta</div>
                        </div>
                        @for ($i = 0; $i < count($articulos); $i++)
                            <div class="row">
                                <div class="row_item">{{$articulos[$i]['id_articulo']}}</div>
                                <div class="row_item">{{$nombres_art[$i]}}</div>
                                <div class="row_item">{{$articulos[$i]['vendidos']}}</div>
                                <div style="color: green" class="row_item">${{$precios_art[$i]}}</div>
                                <div style="font-size: 16px; color: green" class="row_item">$2500</div>
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
                    <input style="display:none;" value="consignacion" name="tipo_oculto" id="tipo_oculto" type="text">
                    <button type="button" name="eliminar_cancelar">Cancelar</button>
                    <button name="eliminar-aceptar">Eliminar</button>
               </form>
            </div>
        </div>
        @endif
       
            <form id="forma_id" action="" method="POST">
                @csrf
                <input name="id_venta" id="id_venta" type="text" value="">
            </form>
    </div>
    
    <script src="{{asset('scripts/script_liquidaciones.js')}}"></script>
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