<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas Archivadas</title>
    <link rel="stylesheet" href="estilos/estilo_menu.css">
    <script src="https://kit.fontawesome.com/c17113d732.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilos/estilo_tabla.css">
    <link rel="stylesheet" href="estilos/estilo_archivados.css">
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
        <div class="titulo_cabecera"><h2 >Ventas Archivadas</h2></div> 
        <div class="tabla">
           
            <div class="row tabla_encabezado">
                <div class="row_item">Id Venta</div>
                <div class="row_item">Tipo Venta</div>
                <div class="row_item">Cliente/Vendedor</div>
                <div class="row_item">Total Venta</div>
                <div class="row_item">Fecha Venta</div>
            </div>
            @foreach ($archivados as $archi)
            <div class="row">
                <div class="row_item">{{$archi['id']}}</div>
                <div class="row_item">{{$archi['tipo_venta']}}</div>
                <div class="row_item">{{$archi['vendedor']}}</div>
                <div style="color: green;" class="row_item">${{$archi['total_venta']}}</div>
                <div class="row_item">{{$archi['fecha_venta']}}</div>
            </div>
            @endforeach
          

        </div>
        <div class="titulo_cabecera boton_volver"><h2 >Volver</h2></div> 
    </div>
    <script>
        document.querySelector(".boton_volver").addEventListener("click",function(){
            window.history.back();
        });
    </script>
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