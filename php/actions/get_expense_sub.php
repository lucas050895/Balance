<?php
    include("../../config/conexion.php");

    header('Content-Type: application/json');

    $id_categoria = $_GET['id_categoria'] ?? null;

    // Validación básica
    if (!$id_categoria) {
    echo json_encode([]);
    exit;
    }

    // Consulta filtrada
    $stmt = $conexion->prepare("SELECT id, descripcion FROM egresos_subcategoria WHERE id_categoria = ?");
    $stmt->bind_param("i", $id_categoria);
    $stmt->execute();

    $resultado = $stmt->get_result();
    $categoria = [];

    while ($row = $resultado->fetch_assoc()) {
        $categoria[] = $row;
    }

    echo json_encode($categoria);