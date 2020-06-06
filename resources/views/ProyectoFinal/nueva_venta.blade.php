<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Venta</title>
    <link rel="stylesheet" href="estilos/estilo_menu.css">
    <script src="https://kit.fontawesome.com/c17113d732.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilos/estilo_nueva_venta.css">
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
        <div class="pantalla">
        <div class="mensaje_confirmar bordeado">
            <h2 id="confirmar_tipo_ventax" >Confirmar Cosnginación</h2>
            <div class="break"></div>
            <hr>
            <label for=""> <Span id="conf_venta" >Consignar </Span> <span id="conf_total" >$3321</span> al <span id="conf_tipo" >vendedor</span> <span id="conf_vend" >Alicia Castro Felix Mario</span>?</label>
            <div class="break"></div>
            <form method="POST" action="">
                @csrf
                <input style="display: none;" id="confirmar_tipo_venta" name="confirmar_tipo_venta" type="text">
                <div class="break"></div>
                <input style="display: none;" id="confirmar_id_cliente" name="confirmar_id_cliente" type="text">
                <div class="break"></div>
                <div style="display: none;" class="articulos_confirmar">
                    
                </div>
                <div class="break"></div>
                <button type="button" id="conf_cancelar">Cancelar</button>
                <button id="conf_confirmar">Confirmar</button>
            </form>
           
        </div>
        </div>
        <div class="titulo_cabecera"><h2 >Nueva Venta</h2></div>
        <div class="informacion bordeado">
            
            <div class="break"></div>
            <Label>¿Tipo de venta?</Label>
            <div class="break"></div>
            <label for="check1"><input class="check" type="checkbox" name="" id="check1"> <span>Consignacion</span></label>
            <div class="break"></div>
            <label for="check2"><input class="check" type="checkbox" name="" id="check2"> <span>Contado</span></label>
        </div>
        <div style="margin-top:10px; margin-bottom:0;" class="consignacion oculto">
            <div class="titulo_cabecera"><h2 >Consignacion</h2></div>
            <div class="infoconsi bordeado">
                
                <div class="break"></div>
                <div class="busqueda">
                    <div class="break"></div>
                    <i class="fas fa-search"></i>
                    <input type="text" name="" id="busqueda_nombre" placeholder="Nombre/id/telefono">
                    <button class="bus">Buscar</button>
                    <div class="filtros_act">
                        
                    </div>
                   
                </div>
                <div class="break"></div>
                
                <div class="break"></div>
                <div class="tabla vendedores_tabla">
                    <div class="row tabla_encabezado">
                        <div style="width: 30%" class="row_item">IdVendedor</div>
                        <div style="width: 40%" class="row_item">Nombre</div>
                        <div style="width: 30%" class="row_item">Numero Telefono</div>
                    </div>
                    @foreach ($vendedores as $vendedor)
                    <div data-seleccion="false" class="row">
                        <i class="fas fa-check"></i>
                        <div style="width: 30%" class="row_item">{{$vendedor['id_vend']}}</div>
                        <div style="width: 40%" class="row_item">{{$vendedor['nombre_vend']}}</div>
                        <div style="width: 30%" class="row_item">{{$vendedor['tel_vend']}}</div>
                    </div>
                    @endforeach
                   
                    
                </div>
            </div>
        </div>

        <div style="margin-top:0px; margin-bottom:10px;"  class="contado oculto">
            <div class="titulo_cabecera"><h2 >Contado</h2></div>
            <div class="infoconta bordeado">
                <h2>Contado</h2>
                <div class="break"></div>
                <label style="line-height:28px" for="">Nombre de cliente:</label>
                <input placeholder="Ingrese el nombre del cliente" type="text" name="" id="contado_nombre">
                <label style="line-height:28px" for="anony"><input type="checkbox" name="" id="anony"> Anonimo</label>
            </div>
        </div>

        <div class="articulos oculto">
            <div class="titulo_cabecera"><h2 >Articulos</h2></div>
            <div class="infoarticulos bordeado">
                
                <div class="break"></div>
                
                    <div class="tabla artic">
                        <div style="height:30px; min-height:0%" class="row tabla_encabezado">
                            <div class="row_tabla">Foto</div>
                            <div class="row_tabla">Codigo</div>
                            <div class="row_tabla">Nombre</div>
                            <div class="row_tabla">Precio</div>
                            <div class="row_tabla">Stock</div>
                        </div>
                        @foreach ($articulos as $art)
                        <div style="min-height: 0px; align-items:normal;" class="row">
                            <div class="row_tabla"><img src="imagenes/articulos/{{$art['imagen']}}" alt=""></div>
                            <div class="row_tabla cod_pro">{{$art['id_art']}}</div>
                            <div class="row_tabla">{{$art['nombre_art']}}</div>
                            <div class="row_tabla pre_pro">${{$art['precio_art']}}</div>
                            <div class="row_tabla pre_pro">{{$art['stock']}}</div>
                            <i class="fas fa-arrow-right"></i>
                        </div>
                        @endforeach
                        
                    </div>
                
                <div class="seleccionados bordeado">
                    
                    <div style="box-shadow: none;" class="tabla sel">
                        <div class="row tabla_encabezado">
                            <div class="row_item">Codigo</div>
                            <div style="width:35%" class="row_item">Nombre</div>
                            <div style="width:15%" class="row_item">Cant</div>
                            <div class="row_item">Total</div>
                            <div style="width:10%" class="row_item"></div>
                        </div>
                        <div class="mensaje">
                        <i class="fas fa-arrow-left"></i>
                            Seleccione Articulos
                        </div>
                        <!--   <div class="row">
                            <div class="row_item">0001</div>
                            <div style="width:35%" class="row_item">Dispensador de agua</div>
                            <div style="width:15%" class="row_item">
                                <span style="margin-right: 2px;" class="editor">-</span>
                                <div class="cant">1</div>
                                <span style="margin-left: 2px;" class="editor">+</span>
                            </div>
                            <div class="row_item">$350</div>
                            <div style="width: 10%" class="row_item eliminar"> &times; </div>
                        </div> -->
                        
                        
                    </div>
                    <div class="break"></div>
                    <h4>Total: <span id="total_selec" >$0</span></h4>
                </div>
            </div>
        </div>
       
        <div class="botones oculto">
        <button id="cancelar">Cancelar</button>
        <button id="aceptar">Aceptar</button>
        </div>
    </div>
    
    <script src= "{{ asset('scripts/script_nueva_venta.js') }}"></script>
    <script src= "{{ asset('scripts/script_n_venta_vend.js') }}"></script>
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