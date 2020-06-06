<?php
    if(isset($_POST['id_venta']))
    {
        $id=$_POST['id_venta'];
        ?>
        <script>
            var id_venta='<?php echo $id ?>'
           
        </script>
        <?php
    }
    if(isset($_POST['nombre_oculto']))
    {
        $id=$_POST['nombre_oculto'];
        ?>
        <script>
            var id_archivar='<?php echo $id ?>'
           
        </script>
        <?php
    }
?>