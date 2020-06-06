<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>
    <link rel="stylesheet" href="estilos/estilo_menu.css">
    <script src="https://kit.fontawesome.com/c17113d732.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilos/estilo_inventario.css">
    <link rel="stylesheet" href="estilos/estilo_tabla.css">
    <link rel="icon" href="imagenes/icono.png">
</head>
<body>
    <?php
       $PATH= $_SERVER["DOCUMENT_ROOT"]."\Assets/";
        include($PATH."menu.html");
        
    ?>
     <?php
        $PATH= $_SERVER["DOCUMENT_ROOT"]."\Assets/";
        include($PATH."cabecera.html");
    ?>
    <div class="container">
        <div class="titulo_cabecera"><h2 >Inventario</h2></div> 
        <div class="infopadre">
            <div class="info bordeado">
                <div class="icono">
                    <i style="color: var(--boton-aceptar);" class="fas fa-dolly-flatbed"></i>
                </div>
                <div class="info_texto">
                    <span  id="info_articulos_activos">13</span>
                    <label for="">Articulos</label>
                </div>
            </div>
            <div class="info bordeado">
                <div class="icono">
                    <i style="color: var(--boton-aceptar-hover)" class="fas fa-boxes"></i>
                    </div>
                    <div class="info_texto">
                        <span  id="info_stock">13</span>
                        <label for="">Stock Total</label>
                </div>
            </div>
            <div class="info bordeado">
                <div class="icono">
                <i style="color: var(--boton-cancelar)" class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="info_texto">
                        <span  id="info_sin_stock">13</span>
                        <label for="">Articulos con poco stock</label>
                </div>
            </div>
            <div class="info bordeado">
                <div class="icono">
                    <i style="color: green;" class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="info_texto">
                        <span style="color: green;"  id="info_costo_inv">$2312</span>
                        <label for="">Costo de inventario</label>
                </div>
            </div>
            
        </div>
        <div style="padding-bottom: 0; margin-bottom:15px;" class="filtros bordeado">
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
        <div id="articulos_inventario" class="tabla bordeado">
                    <div class="row" style="font-weight: 600; pointer-events: none;">
                        <div class="row_item">Código</div>
                        <div class="row_item">Nombre</div>
                        <div class="row_item">Ventas</div>
                        <div class="row_item">Stock</div>
                        <div class="row_item">Precio</div>
                        <div class="row_item">Inventario</div>
                    </div>
                    @foreach ($articulos as $articulo)
                        <div class="row">
                            <div class="row_item">{{$articulo['id_art']}}</div>
                            <div class="row_item">{{$articulo['nombre_art']}}</div>
                            <div class="row_item">{{$articulo['vendidos']}}</div>
                            <div class="row_item">{{$articulo['stock']}}</div>
                            <div style="color: green;" class="row_item">${{$articulo['precio_art']}}</div>
                            <div style="color: var(--boton-aceptar-hover)" class="row_item">$8140</div>
                        </div>
                    @endforeach
                   
                   
                </div>
        </div>
    <script src="{{asset('scripts/script_inventario.js')}}"></script>
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