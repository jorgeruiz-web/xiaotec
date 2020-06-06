<?php
    include("conexion.php");
    if($conex)
    {
       
        $_SESSION["id"]=$id;
        $consulta="SELECT * FROM `vendedores` WHERE id_vendedor=".$id."";
        $resultado=mysqli_query($conex,$consulta);
        $row = mysqli_fetch_assoc($resultado);

        $nombre=$row['nombre_vendedor'];
        $direccion=$row['direccion_vendedor'];
        $telefono=$row['telefono_vendedor'];
        $RFC=$row['RFC_vendedor'];
        $fecha_nac=$row['fecha_nac_vendedor'];
        ?>
        <script>
            var nombre='<?php echo $nombre ?>';
            var direccion='<?php echo $direccion ?>';
            var telefono='<?php echo $telefono ?>';
            var rfc='<?php echo $RFC ?>';
            var fecha_nac='<?php echo $fecha_nac ?>';
            document.querySelector("#datos_nombre").value=nombre;
            document.querySelector("#datos_direccion").value=direccion;
            document.querySelector("#datos_telefono").value=telefono;
            document.querySelector("#datos_fechanac").value=fecha_nac;
            document.querySelector("#datos_rfc").value=rfc;
        </script>
        <?php
        
        if(isset($_POST['guardar']))
        {
            
            $nombre=$_POST['datos_nombre'];
            $direccion=$_POST['datos_direccion'];
            $telefono=$_POST['datos_telefono'];
            $fecha_nac=$_POST['datos_fechanac'];
            $RFC=$_POST['datos_rfc'];

            $consulta='UPDATE `vendedores` SET `nombre_vendedor`="'.$nombre.'",`direccion_vendedor`="'.$direccion.'",`telefono_vendedor`="'.$telefono.'",`fecha_nac_vendedor`="'.$fecha_nac.'",`RFC_vendedor`="'.$RFC.'",`estado_vendedor`="Activo" WHERE id_vendedor="'.$id.'"';
            $resultado=mysqli_query($conex,$consulta);
            ?>
            <script>
                window.location.replace("vendedores.php");
            </script>
            <?php
        }
    }
?>