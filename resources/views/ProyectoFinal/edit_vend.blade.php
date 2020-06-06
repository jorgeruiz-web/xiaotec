<?php
 session_start();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Vendedor</title>
    <link rel="stylesheet" href="estilos/estilo_menu.css">
    <script src="https://kit.fontawesome.com/c17113d732.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilos/estilos_edit_vend.css">
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
        <div class="titulo_cabecera"><h2 >Editar Vendedor #<span id="num">{{$id}}</span></h2></div> 
        <div class="editar">
           
            <form id="forma_prueba" method="POST" action="">
                <input style="display: none;" id="prueba" name="prueba" value="" type="text">
            </form>
            <form method="POST" id="forma_datos" action="/vendedores/edicion?id_vend={{$id}}">
                @csrf
                <div class="break"></div>
                <label for="">NOMBRE</label>
                <input required type="text" name="datos_nombre" value="{{$vendedor1['nombre_vend']}}" id="datos_nombre">
                <div class="break"></div>
                <label for="">DIRECCION</label>
                <input required type="text" name="datos_direccion" value="{{$vendedor1['direccion_vend']}}" id="datos_direccion">
                <div class="break"></div>
                <label for="">TELEFONO</label>
                <input required type="tel" name="datos_telefono" value="{{$vendedor1['tel_vend']}}" id="datos_telefono">
                <div class="break"></div>
                <label for="">FECHA DE NACIMIENTO</label>
                <input required type="date" name="datos_fechanac" value="{{$vendedor1['fecha_nac_vend']}}" id="datos_fechanac">
                <div class="break"></div>
                <label for="">RFC</label>
                <input required type="text" name="datos_rfc" id="datos_rfc" value="{{$vendedor1['rfc_vend']}}" >
                <button type="button" id="descartar">Descartar</button>
                <button type="submit" name="guardar" id="guardar">Guardar</button>
            </form>
            
        </div>
        <div class="info">
            <div class="info2">
                <h2>Fecha de registro</h2>
                <i class="fas fa-table"></i>
                <span id="fechare">{{$fecha_reg}}</span>
            </div>
            <div class="info2">
                <h2>Estado</h2>
                <div class="break"></div>
                <i class="fas fa-desktop"></i>
                <span id="estado">{{$estado}}</span>
            </div>
            <div class="info2">
                <h2>Ventas</h2>
                <div class="break"></div>
                <i class="fas fa-chart-line"></i>
                <span id="ventas">{{$cant_ventas}}</span>
            </div>
            <div class="info2">
                <h2>Comisiones</h2>
                <div class="break"></div>
                <i class="far fa-money-bill-alt"></i>
                <span id="comisiones">${{$comisiones_total}}</span>
            </div>
            
        </div>
        <div style="margin-top:15px;" class="titulo_cabecera"><h2 >Historial</h2></div> 
        <div style="margin-top:0%;" class="tabla">
           
                <div class="row" style="font-weight: 600; pointer-events: none;">
                    <div class="row_item">Id Venta</div>
                    <div class="row_item">Fecha Consignación</div>
                    <div class="row_item">Fecha Liquidación</div>
                    <div class="row_item">Estado</div>
                    <div class="row_item">Venta</div>
                    <div class="row_item">Comision</div>
                </div>
               @for ($i = 0; $i < count($ventas); $i++)
                <div class="row">
                    <div class="row_item">{{$ventas[$i]['id_venta']}}</div>
                    <div class="row_item">{{$ventas[$i]['fecha_consi']}}</div>
                    <div class="row_item">{{$fechas[$i]}}</div>
                    <div class="row_item">{{$ventas[$i]['estado']}}</div>
                    <div style="color: green;" class="row_item">${{$ventas[$i]['total']}}</div>
                    <div style="color: green;" class="row_item">${{$comisiones[$i]}}</div>
                </div>  
               @endfor


    </div>
    <script src="scripts/script_edit_vend.js"></script>
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