<?php

    session_start();

    include("../../config/conexion.php");

    if(isset($_POST['user']) && isset($_POST['password'])){
        $resultado = $conexion->query("SELECT *
                                            FROM usuarios
                                            WHERE user ='".$_POST['user']."' AND
                                            password='".$_POST['password']."' LIMIT 1")or die($conexion->error);

        if(mysqli_num_rows($resultado)> 0){

            $datos_usuario = mysqli_fetch_row($resultado);


            $_SESSION['usuario'] = $usuario;
            $_SESSION['ultimoAcceso'] = date("Y-n-j H:i:s");

            // ID
            $id = $datos_usuario[0];
            // USUARIO
            $usuario = $datos_usuario[1];
            // PASSWORD
            $password = $datos_usuario[2];

            $_SESSION['usuario'] = array(
                'id' => $id,
                'usuario' => $usuario,
                'password' => $password
            );
            header("Location: http://lucasconde.ddns.net/Balance/php/pages/dashboard.php");
        }else{
            ?>
                <script>
                    alert("Usuario o password incorrectos.");
                    window.location.href = "http://lucasconde.ddns.net/Balance";
                </script>
            <?php
        }
    }