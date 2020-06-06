


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesion</title>
    <link rel="stylesheet" href="estilos/estilo_login.css">
    <link rel="icon" href="imagenes/icono.png">
</head>
<body>
    <div class="login">
        <div class="imagen">
            <img src="imagenes/Perfil.png" alt="" srcset="">
        </div>
        <form method="POST" action="">
            @csrf
            <h2>Iniciar Sesión</h2>
            <div class="break"></div>
            <div class="info">
                 <div class="in">
                     <div class="eff"></div>
                    <input value="JorgeRuiz" name="usuario" type="text" placeholder="Nombre de usuario">
                </div>
                
                <div class="break"></div>
                <div class="in">
                     <div class="eff"></div>
                    <input value="cuenta123" name="contra" type="password" placeholder="contraseña">
                </div>
                
                <div class="break"></div>
                <button name="registrarxd" type="submit">Iniciar Sesión</button>
                <div class="break"></div>
                @if (isset($resultado))
                    @if ($resultado==false)
                    <div class='error'><h4 >{{$mensaje}}</h4></div>
                    @endif
                @endif
            </div>
            <script src= "{{ asset('scripts/script_login.js') }}"></script>
        </form>
    </div>
    
</body>
</html>