<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="wth=device-width, initial-scale=1.0">
    <title>Articulos</title>
    <link rel="stylesheet" href="estilos/estilo_menu.css">
    <script src="https://kit.fontawesome.com/c17113d732.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilos/estilo_articulos.css">
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
        <div class="des_excel">
            
            <i class="fas fa-file-excel"></i>
        </div>
        <div class="pantalla">
            <div class="edicion">
                <div class="imagen_edicion">
                    <div class="subir">
                        <i class="fas fa-file-upload"></i>
                    </div>
                    <img id="img_edit" src="imagenes/articulos/reloj.jpg" alt="">
                </div>
                <form method="POST" class="info_edicion" enctype="multipart/form-data">
                    @csrf
                    <label for="">Nombre:</label>
                    <input style="margin-left: 10px;" value="" type="text" name="nombre_edicion" id="nombre_edicion">
                    <div class="break"></div>
                    <label for="">Precio:</label>
                    <span>$</span>
                    <input style="margin-left: 2px;" id="precio_edicion" type="number" name="precio_edicion">
                    <div class="break"></div>
                    <label for="">Stock:</label>
                    <input style="margin-left: 22px;" id="cantidad_edicion" type="number" name="cantidad_edicion">
                    <label for="">Unidades</label>
                     <div class="break"></div>
                     <input style="display:none;" value="" id="id_edicion" type="number" name="id_edicion">
                     <div class="break"></div>
                    <label for="">Categoria:</label>
                    <select style="font-size:16px;" name="categoria_edicion" id="categoria_edicion">
                        @foreach ($categorias as $categoria)
                        <option value="{{$categoria['nombre']}}">{{$categoria['nombre']}}</option>
                        @endforeach
                    </select>
                    <div class="break"></div>
                    <input style="opacity: 0; pointer-events:none;" type="file" name="imagen_edicion" id="imagen_edicion">
                    <div class="break"></div>
                    <input type="tipo" value="" name="tipo" id="tipo_boton_edicion">
                    <div class="confirmar_cambios">
                        <label id="lbl_tipo" for="">¿Guardar?</label>
                        <button type="submit" id="confirmar_si">Si</button>
                        /
                        <button type="button" id="confirmar_no">No</button>
                    </div>
                    <div class="break"></div>
                    <button type="button" id="descartar_edicion">Descartar</button>
                    <button type="button" id="eliminar_edicion">Eliminar</button>
                    <button type="button" id="guardar_edicion">Guardar</button>
                </form>
            </div>
            
        </div>
        <div class="titulo_cabecera"><h2 >Articulos</h2></div> 
        
        <div style="padding-bottom: 0; margin-bottom:15px;" class="filtros bordeado">
            <h3>Filtrar</h3>
            <div class="busqueda">
                <div class="break"></div>
                <i class="fas fa-search"></i>
                <input type="text" name="" id="busqueda_nombre" placeholder="Nombre/id">
                <button class="bus">Buscar</button>
                <div class="filtros_act">
                    
                </div>
                
            </div>
        </div>

        <div class="articulos">
            @php
               $i=0;  
            @endphp
            @foreach ($articulos as $art)
                @if ($i!=0 && $i%4==0)
                    <div style="margin-right: 0%" class="articulo">
                @else
                    <div class="articulo">
                @endif
                @php
                    $i++;
                @endphp
                    <div class="imagen">
                        <img class="imagen_art" src="imagenes/articulos/{{$art['imagen']}}" alt="" srcset="">
                    </div>
                    <div class="info_art">
                        <h3>{{$art['nombre_art']}}</h3>
                        <div class="break"></div>
                        <Label>Codigo:</Label> <span>{{$art['id_art']}}</span>
                        <div class="break"></div>
                        <Label style="margin-bottom: 30px">Precio:</Label> <span>${{$art['precio_art']}}</span>
                        <div class="break"></div>
                    
                        <button value="{{$art['id_art']}}" class="boton_edicion">
                            Editar
                        </button>
                        <input class="invisible art_stock" type="text" value="{{$art['stock']}}" >
                        <input class="invisible art_categoria" type="text" value="{{$art['categoria']}}" >
                    </div>
                    
                </div>
            @endforeach
           
       
        </div>
    </div>
    <div class="error_rol">
        <h3>Solo el administrador puede llevar acabo la acción</h3>
    </div>
    <script src="{{asset('scripts/script_articulos.js')}}"></script>
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