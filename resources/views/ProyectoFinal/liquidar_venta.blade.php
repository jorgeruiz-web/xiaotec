<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liquidar Venta</title>
    <link rel="stylesheet" href="estilos/estilo_menu.css">
    <script src="https://kit.fontawesome.com/c17113d732.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilos/estilos_liquidar_venta.css">
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
    @if (empty($id_venta))
        <script>
            window.history.back();
        </script>
    @else
    <div class="container">
        <div  class="pantalla">
            <form action="liquidar_venta/confirmar" method="post">
                @csrf
                
                <div class="mensaje_confirmar bordeado">
                        <h3>Liquidar Venta #<input readonly style="font-weight: bold; margin-left:3px;" name="confirmar_id" id="confirmar_id" value="{{$id_venta}}" type="text"></h3> 
                        <div class="break"></div>
                        <label for="">Vendedor: <span id="confirmar_nombre">{{$nombre}}</span></label>
                        <div class="break"></div>
                        <label for="">Tipo de pago: <input id="confirmar_tipo" name="confirmar_tipo" type="text"></label>
                        <div class="break"></div>
                        <label for="">Total a pagar: $<input style="margin-left: 3px" readonly name="confirmar_total" id="confirmar_total" value="" type="text"></label>
                        <div class="break"></div>
                        <label id="confirmar_deuda_label" style="display: none;" for="">Deuda Restante: $<input style="margin-left: 3px" readonly name="confirmar_deuda" id="confirmar_deuda" value="" type="text"></label>
                        <div class="break"></div>
                        <input style="display:none;" name="comision_vendedor" id="comision_vendedor" type="text">
                        <div class="break"></div>
                        <label id="label_convenio" style="color: var(--filtro-hover); font-weight:normal;">¿Crear convenio por $<span id="convenio_deuda"></span> pesos?</label>
                        <div class="break"></div>
                        <div style="display: none;" class="articulos_vendidos">
                            
                        </div>
                        <button type="button" id="cancelar_confirmacion">Cancelar</button>
                        <button type="submit" id="aceptar_confirmacion">Aceptar</button>
                </div>
            </form>
            
        </div>
        <div class="titulo_cabecera"><h2 >Liquidar venta #<span id="num_liquidar">{{$id_venta}}</span></h2></div> 
        <div class="detalles bordeado">
           
                <div class="informacion">
                    <label for="">Vendedor: <span id="info_vend">{{$nombre}}</span></label>
                    <div class="break"></div>
                    <label for="">Fecha de despacho: <span id="info_fecha1">{{$venta['fecha_consi']}}</span></label>
                    <div class="break"></div>
                    <label for="">Fecha límite para liquidar: <span id="info_fecha2">{{$venta['fecha_limi']}}</span></label>
                    <div class="break"></div>
                    <label for="">Fecha Actual: <span id="info_fecha2">{{$fecha_hoy}}</span></label>
                    <div class="break"></div>
                    <label for="">Estado: <span style="color:green;" id="info_estado">A TIEMPO</span></label>
                    <div class="break"></div>
                    <label for="">Comision: <span id="info_comision">45%</span></label>
                </div>
                <div class="articulos">
                    <h3 style="margin-top: 10px">Articulos:</h3>
                    <div style="box-shadow: none;" class="tabla">
                        <div class="row tabla_encabezado">
                            <div class="row_item">Id Articulo</div>
                            <div class="row_item">Nombre</div>
                            <div class="row_item">Precio Unidad</div>
                            <div class="row_item">Cantidad Consignada</div>
                            <div class="row_item">Cantidad Vendia</div>
                            <div style="font-size: 16px; color:black;" class="row_item">Comision Ganada</div>
                            <div style="font-size: 16px; color:black;" class="row_item">Total a pagar</div>
                            
                        </div>

                        @for ($i = 0; $i < count($articulos); $i++)
                            <div class="row">
                                <div class="row_item">{{$articulos[$i]["id_articulo"]}}</div>
                                <div class="row_item">{{$nombres[$i]}}</div>
                                <div style="color:green;" class="row_item">${{$precios[$i]}}</div>
                                <div class="row_item">{{$articulos[$i]["cantidad"]}}</div>
                                <div class="row_item">
                                    <span style="margin-right: 2px;" class="editor">-</span>
                                    <div class="cant">0</div>
                                    <span style="margin-left: 2px;" class="editor">+</span>
                                </div>
                                <div style="font-size: 16px; color:green;" class="row_item com_final">$0</div>
                                <div style="font-size: 16px; color:red;" class="row_item pre_total">$0</div>
                                <label class="total_total" for="">$0</label>
                            </div>
                        @endfor
                        
                        
                        


                        
                    </div>
                </div>
                <div class="info_facturacion">
                    <h3>Facturación:</h3>
                    <div class="break"></div>
                    <label for="">Total a pagar:</label>
                    <span id="total_facturacion">$100</span>
                    <div class="break"></div>
                    <label for="">Comision obtenida:</label>
                    <span id="comision_facturacion">$100</span>
                    <div class="break"></div>
                    <label for="">Venta total:</label>
                    <span id="venta_facturacion">$200</span>
                    <div class="break"></div>
                    <label for="">Liquidación:</label>
                    <label for="parcial_facturacion"> <input type="checkbox" name="" id="parcial_facturacion"> Parcial </label>
                    <label for="completa_facturacion"> <input type="checkbox" name="" id="completa_facturacion"> Completa </label>
                    <div style="max-height: 0px;" class="abono"><label style="margin-left: 15px;" for="">$</label> <input type="number" min="0" value="0" name="" id="cantidad_abono"> <label for="">Cantidad a abonar</label></div>
                    <div style="max-height:0px;" class="error_parcial">Ingrese la cantidad a abonar</div>
                    
                    <button id="cancelar_facturacion">Cancelar</button>
                    <button id="aceptar_facturacion">Aceptar</button>
                </div>
        </div>
    </div>
    @endif
    
<script src="{{asset('scripts/script_liquidar_venta.js')}}"></script>
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