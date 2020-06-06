<?php
    include("conexion.php");
    if($conex)
    {
        if(isset($_POST['boton_agregar']))
        {
            $nombre= $_POST['nombre'];
            $direccion= $_POST['direccion'];
            $telefono= $_POST['telefono'];
            $fecha_nac= $_POST['fecha_nac'];
            $rfc= $_POST['rfc'];
            $consulta="INSERT INTO `vendedores`(`nombre_vendedor`, `direccion_vendedor`, `telefono_vendedor`, `fecha_nac_vendedor`, `RFC_vendedor`,`estado_vendedor`) VALUES ('".$nombre."','".$direccion."','".$telefono."','".$fecha_nac."','".$rfc."','Activo')";
            $resultado=mysqli_query($conex,$consulta);
        }
        
        if(isset($_POST['eliminar-aceptar']))
        {
             $id=$_POST['nombre_oculto'];
             $consulta="DELETE FROM `vendedores` WHERE id_vendedor=".$id;
             $resultado=mysqli_query($conex,$consulta);
        }
    
    }
    
?>