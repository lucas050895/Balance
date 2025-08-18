<?php
    include("../../config/conexion.php");

    $fecha          = $_POST['fecha'];
    $categoria      = $_POST['categoria'];
    $subcategoria   = $_POST['subcategoria'];
    $importe        = $_POST['importe'];

    $consulta = "INSERT INTO ingresos(fecha,categoria,subcategoria,importe) VALUES ('$fecha','$categoria','$subcategoria','$importe')";

    $resultado = mysqli_query($conexion,$consulta);

    if($resultado){
        header("Location: ../pages/income.php");
    }
    // else {
    //     header("Location:");
    // }
?>