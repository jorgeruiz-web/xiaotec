
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendedores</title>
    <link rel="stylesheet" href="estilos/estilo_menu.css">
    <script src="https://kit.fontawesome.com/c17113d732.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilos/estilos_vendedoras.css">
    
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
   
    <div style="margin-left: 130px" class="container">
        <div class="des_excel">
            
            <i class="fas fa-file-excel"></i>
        </div>
       <div  class="pantalla">
           <div class="mensaje_eliminar bordeado">
            <h3>¿Eliminar Vendedor <span id="eliminar_nombre">Jorge Luis Ruiz Salazar</span>?</h3>
            <div class="break"></div>
            <i class="fas fa-exclamation-triangle"></i>
                <div class="break"></div>
                <label for="">Esta acción no podrá ser revertida</label>
                <div class="break"></div>
            <form method="POST" id="form_eliminar" action="">
                @csrf
                    <input value="" name="nombre_oculto" type="text">
                    <button type="button" name="eliminar_cancelar">Cancelar</button>
                    <button name="eliminar-aceptar">Eliminar</button>
               </form>
           </div>
       </div>
       <div class="titulo_cabecera">
           <h2>Vendedores</h2>
       </div>
        <div class="agregar">
            <h3>Agregar Vendedor</h3><span id="agregar_visualizar" >Visualizar <i class="fas fa-eye"></i></span>
            <form class="oculto" method="POST" action="">
                @csrf
                <div class="info_labels">
                    <label for="">Nombre</label>
                    <div class="break"></div>
                    <label for="">Direccion</label>
                    <div class="break"></div>
                    <label for="">Telefono</label>
                    <div class="break"></div>
                    <label for="">Fecha de Nacimiento</label>
                    <div class="break"></div>
                    <label for="">RFC</label>
                </div>
                <div class="info_inputs">
                    <input  required name="nombre" id="nombre" type="text">
                    <div class="break"></div>
                    <input  required name="direccion" id="direccion" type="text">
                    <div class="break"></div>
                    <input  required name="telefono" id="telefono" type="text">
                    <div class="break"></div>
                    <input  required name="fecha_nac" id="fecha_nac" type="date">
                    <div class="break"></div>
                    <input  required name="rfc" id="rfc" type="text">
                    <div class="break"></div>
                    <button type="button" id="boton_agregar" name="boton_agregar">Agregar</button>
                </div>
            </form>
            
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
            <div class="tabla usuarios">
                <div class="row tabla_encabezado" style="font-weight: 600; pointer-events: none;">
                    <div class="row_item">Id Vendedor</div>
                    <div class="row_item">Nombre</div>
                    <div class="row_item">Telefono</div>
                    <div class="row_item">Estado</div>
                    <div style="justify-content:center" class="row_item">Acciones</div>
                </div>
              @foreach ($vendedores as $Vendedor)
                <div class="row">
                <div class="row_item">{{$Vendedor['id_vend']}}</div>
                    <div class="row_item">{{$Vendedor['nombre_vend']}}</div>
                    <div class="row_item">{{$Vendedor['tel_vend']}}</div>
                    <div class="row_item estados_vend">{{$Vendedor['estado_vend']}}</div>
                    <div class="row_item">
                        <button class="editar">Editar</button>
                        @if ($Vendedor['estado_vend']=="activo")
                            <button style="background-color:var(--filtro-hover)" value="{{$Vendedor['id_vend']}}" class="eliminar">Desactivar</button>
                        @else
                            <button value="{{$Vendedor['id_vend']}}" class="eliminar">Re-Activar</button>
                        @endif
                        
                    </div>
                </div> 
              @endforeach
                         
                        
                    
                
            </div>
        
    </div>
    <div class="error_rol">
        <h3>Solo el administrador puede llevar acabo esta acción</h3>
    </div>
    <script src="{{asset('scripts/script_vend.js')}}"></script>
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