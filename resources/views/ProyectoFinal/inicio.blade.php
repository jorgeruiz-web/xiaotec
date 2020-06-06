
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="estilos/estilo_inicio.css">
    <link rel="stylesheet" href="estilos/estilo_menu.css">
    <script src="https://kit.fontawesome.com/c17113d732.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
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
    <div class="pantalla_carga">
        <i class="fas fa-spinner"></i>
    </div>
    <div class="container">
            <div class="cabecera2">
                <div class="titulo_cabecera"><h2 >Dashboard</h2></div> 
                <div  class="info">
                    <div class="imagen">
                        <i  class="fas fa-users"></i>
                    </div>
                    <div class="informacion">
                        <span class="cantidad">{{$cant_vend}}</span>
                        <span>Vendedores Activos</span>
                    </div>
                    <button onclick="location.href='vendedores';" >Ver detalles <i class="fas fa-arrow-circle-right"></i></button>
                </div>
                <div  class="info">
                    <div class="imagen">
                    <i class="far fa-calendar-alt"></i>
                    </div>
                    <div class="informacion">
                        <span class="cantidad">{{$cant_consi}}</span>
                        <span>Consignaciones Pendientes</span>
                    </div>
                    <button onclick="location.href='consignacion';" >Ver detalles <i class="fas fa-arrow-circle-right"></i></button>
                </div>
                <div  class="info">
                    <div class="imagen">
                        <i class="far fa-calendar-check"></i>
                    </div>
                    <div class="informacion">
                        <span class="cantidad">{{$cant_liqui}}</span>
                        <span>Liquidaciones</span>
                    </div>
                    <button onclick="location.href='liquidacion';" >Ver detalles <i class="fas fa-arrow-circle-right"></i></button>
                </div>
                <div  class="info">
                    <div class="imagen">
                    <i class="fas fa-boxes"></i>
                    </div>
                    <div class="informacion">
                        <span class="cantidad">{{$cant_cont}}</span>
                        <span>Ventas de Contado</span>
                    </div>
                    <button onclick="location.href='contado';" >Ver detalles <i class="fas fa-arrow-circle-right"></i></button>
                </div>
                <div  class="info">
                    <div class="imagen">
                    <i class="fas fa-dolly-flatbed"></i>
                    </div>
                    <div class="informacion">
                        <span style="color:green" class="cantidad">${{$inventario}}</span>
                        <span>Inventario</span>
                    </div>
                    <button onclick="location.href='inventario_art';" >Ver detalles <i class="fas fa-arrow-circle-right"></i></button>
                </div>
                <div  class="info">
                    <div class="imagen">
                    <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="informacion">
                        <span style="color:green" class="cantidad">$8950</span>
                        <span>Ganancias Semanales</span>
                    </div>
                    <button onclick="location.href='estadisticas';" >Ver detalles <i class="fas fa-arrow-circle-right"></i></button>
                </div>
            </div>

        
        
        
    </div>

    <script type="text/javascript"  src="{{ URL::asset('scripts/script_inicio.js') }}"></script>

    @if (!isset($usuario))
    @if ($usuario==null)
        <script>
            var usuario_aux=sessionStorage.getItem("usuario");
            var foto=sessionStorage.getItem("foto");
            var rol=sessionStorage.getItem("rol");
            if(usuario_aux==null||usuario_aux=="")
            {
                window.location.href="/cerrar_sesion";
            }
            else{
                var pant_carga=document.querySelector(".pantalla_carga");
                pant_carga.parentElement.removeChild(pant_carga);
                document.querySelector("#nombre_usuario").innerHTML=usuario_aux;
                document.querySelector(".foto").src="{{asset('imagenes/usuarios/')}}/"+foto;
                document.querySelector(".usuario_auth").addEventListener("click",function(){
                    sessionStorage.clear();
                    window.location.href="/cerrar_sesion";
                });
            }
            
        </script>
    @endif

    @else
        <script>
            var usuario='{{$usuario}}';
            var foto='{{$foto}}';
            var rol='{{$rol}}';
            var pant_carga=document.querySelector(".pantalla_carga");
            pant_carga.parentElement.removeChild(pant_carga);
            sessionStorage.setItem("usuario",usuario);
            sessionStorage.setItem("foto",foto);
            sessionStorage.setItem("rol",rol);
            document.querySelector("#nombre_usuario").innerHTML=usuario;
            document.querySelector(".foto").src="{{asset('imagenes/usuarios/')}}/"+foto;
            document.querySelector(".usuario_auth").addEventListener("click",function(){
                sessionStorage.clear();
                window.location.href="/cerrar_sesion";
            });
        </script>
    @endif
</body>
</html>

