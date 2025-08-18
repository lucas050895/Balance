<?php
  include("../../config/conexion.php");
  include("../../config/sesion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- META -->
    <?php include("../../layout/meta.php"); ?>

    <!-- CSS -->
    <link rel="stylesheet" href="../../css/dashboard.css">
    <link rel="stylesheet" href="../../css/styles.css">

    <!-- ICONOS -->
    <?php include("../../layout/iconos.php"); ?>
</head>
<body>
    <!-- MENU DE NAVEGACION -->
    <?php include("../../layout/nav.php"); ?>

    <!-- TITULO -->
    <section class="title">
        <h2>Dashbord</h2>
    </section>

    <!-- CONTENIDO GENERAL -->
    <main>
        <!-- DINERO DISPONIBLE -->
        <div>
            <h2>Dinero disponible</h2>
            <?php if ($conexion):
                    // OBTENER DIFERENCIA
                    $diferencia_query = "SELECT
                                            (SELECT SUM(importe) FROM ingresos) -
                                            (SELECT SUM(importe) FROM egresos ) AS diferencia ;";
                    $diferencia_query = mysqli_query($conexion, $diferencia_query);
            endif;

            while($row = mysqli_fetch_assoc($diferencia_query)) { ?>
                <p><?php echo number_format($row['diferencia'], 2, ',', '.') ?></p>
            <?php } ?>
        </div>

        <!-- DINERO EN PLAZO FIJO -->
        <div>
            <h2>Dinero en Plazo Fijo</h2>
            <p>0</p>
        </div>

        <!-- INGRESOS DEL MES ACTUAL -->
        <div>
            <h2>Ingresos actual</h2>
            <?php if ($conexion):
                // OBTENER INGRESO ACTUAL
                $actual_query = "SELECT SUM(importe) AS IMPORTE
                            FROM ingresos 
                            WHERE MONTH(fecha) = MONTH(CURRENT_DATE()) 
                            AND YEAR(fecha) = YEAR(CURRENT_DATE())";
                $actual_query = mysqli_query($conexion, $actual_query);
            endif;

            while($row = mysqli_fetch_assoc($actual_query)) { ?>
                <p><?php echo number_format($row['IMPORTE'], 2, ',', '.') ?></p>
            <?php } ?>
        </div>

        <!-- EGRESOS DEL MES ACTUAL -->
        <div>
            <h2>Egresos actual</h2>

            <?php if ($conexion):
                // OBTENER EGRESO ACTUAL
                $actual_query = "SELECT SUM(importe) AS IMPORTE
                            FROM egresos 
                            WHERE MONTH(fecha) = MONTH(CURRENT_DATE()) 
                            AND YEAR(fecha) = YEAR(CURRENT_DATE())";
                $actual_query = mysqli_query($conexion, $actual_query);
            endif;

            while($row = mysqli_fetch_assoc($actual_query)) { ?>
                <p><?php echo number_format($row['IMPORTE'], 2, ',', '.') ?></p>
            <?php } ?>
        </div>
    </main>

    <!-- FOOTER -->
    <?php include("../../layout/footer.php"); ?>

    <script src="../../js/nav.js"></script>
</body>
</html>