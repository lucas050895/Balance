<?php
    $servidor = "localhost";
    $nombreBD = "balance";
    $usuario = "root";
    $password = "";

    $conexion = new mysqli($servidor,$usuario,$password,$nombreBD);

    if($conexion -> connect_error){
        die("Error en la conexion de la BD");
    }

    // Zona horaria de Argentina
    date_default_timezone_set('America/Argentina/Buenos_Aires');
