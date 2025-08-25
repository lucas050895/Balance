<?php
    session_start();

    include("../../config/conexion.php");

    if (isset($_POST['user']) && isset($_POST['password'])) {
        $user = $_POST['user'];
        $password = $_POST['password'];

        // Aplicar SHA2 directamente en la consulta
        $resultado = $conexion->query("SELECT * 
                                    FROM usuarios 
                                    WHERE user = '$user' 
                                    AND password = SHA2('$password', 256) 
                                    LIMIT 1") or die($conexion->error);

        if (mysqli_num_rows($resultado) > 0) {
            $datos_usuario = mysqli_fetch_row($resultado);

            // Extraer datos
            $id = $datos_usuario[0];
            $usuario = $datos_usuario[1];
            $password_hash = $datos_usuario[2];

            // Guardar en sesión
            $_SESSION['usuario'] = array(
                'id' => $id,
                'usuario' => $usuario,
                'password' => $password_hash
            );
            $_SESSION['ultimoAcceso'] = date("Y-n-j H:i:s");

            header("Location: http://lucasconde.ddns.net/Balance/php/pages/dashboard.php");
        } else {
            header("Location: ../../index.php?error=1");
        }
    }
?>
