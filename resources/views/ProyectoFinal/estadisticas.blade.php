<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadisticas</title>
    <link rel="stylesheet" href="{{asset('estilos/estilo_menu.css')}}">
    
    <script src="https://kit.fontawesome.com/c17113d732.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('estilos/estilo_estadisticas.css')}}">
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
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
        <div class="titulo_cabecera"><h2 >Estadisticas</h2></div> 
            <div class="break"></div>
            <div class="sel_per bordeado">
                <Label style="line-height: 22px;">Periodo: </Label>
                <select name="sel_dias" id="sel_dias">
                    <option value="7">Últimos 7 días</option>
                    <option value="14">Últimos 14 días</option>
                    <option value="30">Últimos 30 días</option>
                    <option value="180">Últimos 180 días</option>
                    <option value="360">Últimos 360 días</option>
                    <option value="0">Desde siempre</option>
                </select>
            </div>

            <div class="break"></div>
            <div style="width: 70%" class="info bordeado productos_vend">
                <h2 class="titulo">Productos más vendidos</h2>
                <div class="break"></div>
                <div class="tabla">
                    <div class="row encabezado">
                        <div class="row-item">Codigo</div>
                        <div class="row-item">Nombre</div>
                        <div style="pointer-events: none" class="row-item">Vendidos</div>
                    </div>
                    @foreach ($articulos as $art)
                    <div class="row">
                        <div class="row-item">{{$art['id_art']}}</div>
                        <div style="line-height: 14px;size:14px;" class="row-item nombre_producto">{{$art['nombre_art']}}</div>
                        <div class="row-item">{{$art['vendidos']}}</div>
                    </div>
                    @endforeach

                   
                    
                </div>
            </div>
            <div class="info bordeado">
                <h2  class="titulo">Ventas</h2>
                <div class="break"></div>
                <div class="icono">
                    <i style="color:var(--boton-aceptar);" class="fas fa-shopping-cart"></i>
                </div>
                <div class="info_child">
                    <h4>Liquidaciones</h4>
                    <div class="breaK"></div>
                    <span id="ventas_consi">{{$liqui}}</span>
                    <div class="break"></div>
                    <h4>Contado</h4>
                    <div class="break"></div>
                    <span id="ventas_conta">{{$conta}}</span>
                </div>
                
            </div>

            <div style="width: 70%" class="info bordeado vend_mas_venta">
                <h2 class="titulo">Mejores vendedores</h2>
                <div class="break"></div>
                <div class="tabla">
                    <div class="row encabezado">
                        <div class="row-item">Nombre</div>
                        <div class="row-item">Telefono</div>
                        <div class="row-item">Ventas</div>
                        <div style="pointer-events: none" class="row-item">Liquidaciones</div>
                    </div>
                    @for ($i = 0; $i < count($nombres); $i++)
                        <div class="row">
                            <div class="row-item">{{$nombres[$i]}}</div>
                            <div  class="row-item nombre_producto">{{$telefonos[$i]}}</div>
                            <div class="row-item">{{$cant_ventas[$i]}}</div>
                            <div class="row-item">${{$total_ventas[$i]}}</div>
                        </div>
                    @endfor
                   
                   
                </div>
            </div>

            <div class="info bordeado">
            <h2 class="titulo">Ingresos</h2>
                <div class="break"></div>
                <div class="icono">
                <i style="color:green;" class="fas fa-chart-line"></i>
                </div>
                <div class="info_child">
                    <h4>Liquidaciones</h4>
                    <div class="breaK"></div>
                    <span style="color: green;" id="ingresos_consi">${{$liqui_val}}</span>
                    <div class="break"></div>
                    <h4>Ventas de contado</h4>
                    <div class="break"></div>
                    <span id="ingresos_conta">${{$conta_val}}</span>
                    <div class="break"></div>
                    <h4>Total</h4>
                    <div class="break"></div>
                    <span id="ingresos_total">$N/A</span>
                </div>
            </div>
           <div id="grafico" class="grafica bordeado">
                <h2 style="transform:translateY(-10px); padding:10px" class="titulo">Grafica de Ingresos</h2>
           </div>
        
        
    </div>
    <script>
        var equis={!! json_encode($dias_grafica) !!};
        var ye={!! json_encode($ventas_consi) !!};
        var ye2={!! json_encode($ventas_conta) !!};
        for (let i = 0; i < equis.length; i++) {
            
        }
        console.log(equis);
        console.log(ye);
    </script>
    <script src="{{asset('scripts/script_estadisticas.js')}}"></script>
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