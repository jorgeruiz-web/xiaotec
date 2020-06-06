<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial</title>
    <link rel="stylesheet" href="estilos/estilo_menu.css">
    <script src="https://kit.fontawesome.com/c17113d732.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilos/estilo_tabla.css">
    <link rel="stylesheet" href="estilos/estilo_historial.css">
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
        <div class="titulo_cabecera"><h2 >Historial</h2></div> 
        <div class="tabla">
            <div class="row cabe">
                <div class="row_item">ID movimiento</div>
                <div class="row_item">Tipo</div>
                <div class="row_item">Fecha</div>
                <div style="width: 50%;" class="row_item">Descripción</div>
            </div>
            @foreach ($historial as $his)
            <div class="row">
                <div class="row_item">{{$his['id']}}</div>
                <div class="row_item">{{$his['tipo']}}</div>
                <div class="row_item">{{$his['fecha']}}</div>
                <div style="width: 50%; line-height:16px;" class="row_item">{{$his['descripcion']}}</div>
            </div>
            @endforeach

            
            <div id="vaciar">&times;
            <span class="vaciar2">¿Vaciar Registro?</span>
            </div>
            
        </div>
        
        <div class="pantalla">
            <div class="sure bordeado">
                <i class="fas fa-exclamation"></i>
                <br>
                <label for="">¿Estas seguro?</label>
                <br>
                <span>Esta acción no podrá ser revertida!</span>
                <br>
                <button id="borrartodo">Si, borrar todo!</button>
                <button id="cancelar">Cancelar</button>
            </div>
        </div>
       
        
       
    </div>
    <div class="error_rol">
        <h3>Solo el administrador puede llevar acabo esta acción</h3>
    </div>
    <script src="{{asset('scripts/script_historial.js')}}"></script>
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