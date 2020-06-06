<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Articulo</title>
    <link rel="stylesheet" href="estilos/estilo_menu.css">
    <script src="https://kit.fontawesome.com/c17113d732.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilos/estilo_registro_art.css">
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
        <div  class="pantalla">
            <div class="mensaje_categorias bordeado">
                <h3>Categorias</h3>
                <div class="break"></div>
                <form method="POST" id="forma_categoria" action="">
                    @csrf
                    <label for="">Nombre</label>
                    <input type="text" name="nombre_cat" id="">
                    <button type="button" style="padding: 4px 7px;" class="boton_agregar">Agregar</button>
                
               
                <div class="break"></div>
                <div class="tabla">
                    <div class="row tabla_encabezado">
                        <div style="width: 20%" class="row_item">id</div>
                        <div style="width: 60%" class="row_item">Nombre</div>
                        <div style="width: 20%" class="row_item">Acciones</div>
                    </div>
                    @foreach ($categorias as $categoria)
                    <div class="row">
                        <div style="width: 20%" class="row_item">{{$categoria['id']}}</div>
                        <div style="width: 60%" class="row_item">{{$categoria['nombre']}}</div>
                        <div style="width: 20%" class="row_item">
                            <button type="submit" class="boton_eliminar">Eliminar</button>
                        </div>
                    </div>
                    @endforeach
                    
                    

                </div>
                </form>
                <button id="mensaje_volver">Volver</button>
            </div>
        </div>
        <div class="titulo_cabecera"><h2>Registrar Nuevo Producto</h2></div> 
        <div class="registro bordeado">

            <div class="imagen_registro">
                <i class="fas fa-cloud-upload-alt"></i>
                <img id="imagen_art" src="" alt="">
                
                <label for="">Subir una foto del Producto</label>
            </div>
            <button id="boton_subir_foto">Seleccionar Imagen</button>
            <div class="info_registro">
                <form enctype="multipart/form-data" method="POST" action="/registrar_articulo">
                    @csrf
                <input  style="display: none" type="file" name="filename" id="selec_foto">
                <label for="">Nombre Producto</label>
                <input required style="width:80%; margin-left:8px" type="text" name="info_nombre" id="">
                <div class="break"></div>
                <label for="">Precio Unidad <span>$</span></label>
                <input required style="margin-left: 28px" class="chico" type="number" name="info_precio" id="info_precio">
                <div class="break"></div>
                <label for="">Stock</label>
                <input required style="margin-left: 106px" class="chico" type="number" name="info_stock" id="info_stock">
                <label style="margin-left: 10px" for="">Unidades</label>
                <div class="break"></div>
                <div class="break"></div>
                <label for="">Categoria</label>
                <select style="margin-left: 66px" name="info_categoria" id="info_categoria">
                    @foreach ($categorias as $categoria)
                    <option value="{{$categoria['nombre']}}">{{$categoria['nombre']}}</option>
                    @endforeach
                   
                   
                </select>
                <i id="icono_agregar_categoria" style="color: var(--boton-aceptar)" class="fas fa-plus-circle"></i>
                
                <div class="break"></div>
                <button id="boton_registrar_art" type="submit">Registrar</button>
                </form>
                
            </div>
        </div>
    </div>
    <div class="error_rol">
        <h3>Solo el administrador puede llevar acabo esta acción</h3>
    </div>
    <script src="{{asset('scripts/script_regis_art.js')}}"></script>
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