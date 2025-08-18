<?php
    include("../../config/conexion.php");

    header('Content-Type: application/json');

    $res = $conexion->query("SELECT id, descripcion FROM egresos_categoria");

    $categoria = [];
    while ($row = $res->fetch_assoc()) {
        $categoria[] = $row;
    }

    echo json_encode($categoria);