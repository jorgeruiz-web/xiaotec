<?php
include("conexion.php");
if($conex){
    if(isset($_POST['registrarxd']))
    {
        if(strlen($_POST['usuario'])>1&&strlen($_POST['contra'])>1)
        {
            $usuario=$_POST['usuario'];
            $contra=$_POST['contra'];
            $consulta="SELECT contra FROM administradores WHERE usuario='$usuario'";
            $resultado=mysqli_query($conex,$consulta);
            if(mysqli_num_rows($resultado)>0)
            {
                $fila=mysqli_fetch_assoc($resultado);
                $contra_sql= $fila['contra'];
                if($contra==$contra_sql){
                    $_SESSION['usuario']=$usuario;
                    header("Location: inicio.php");
                    exit();
                }else{
                    ?>
                    <div class='error'><h4 >Contraseña Incorrecta</h4></div>
                    <?php
                }
            }
            else{
                ?>
                    <div class='error'><h4 >No se encuentra registrado</h4></div>
                <?php
            }
        }
        else
        {
            ?>
            <div class='error'><h3 >Error en los datos</h3></div>
        <?php
        }
    }
  
}
?>