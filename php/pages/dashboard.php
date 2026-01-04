<?php
  include("../../config/conexion.php");
  include("../../config/sesion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- META -->
    <?php include("layout/meta.php"); ?>

    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard.css?v=<?php echo filemtime('../../assets/css/dashboard.css'); ?>">
    <link rel="stylesheet" href="../../assets/css/styles.css?v=<?php echo filemtime('../../assets/css/styles.css'); ?>">

    <!-- ICONOS -->
    <?php include("layout/iconos.php"); ?>
</head>
<body>
    <!-- MENU DE NAVEGACION -->
    <?php include("layout/nav.php"); ?>

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
            <?php if ($conexion):
                    // OBTENER PLAZO FIJO
                    $plazo = "SELECT
                                COALESCE((
                                    SELECT SUM(egresos.importe)
                                        FROM egresos
                                        JOIN egresos_categoria ON egresos.categoria = egresos_categoria.id
                                        JOIN egresos_subcategoria ON egresos.subcategoria = egresos_subcategoria.id
                                    WHERE egresos_subcategoria.descripcion LIKE '%Plazo%'
                                    AND egresos.fecha >= '2025-09-01'
                                ), 0)
                                -
                                COALESCE((
                                    SELECT SUM(ingresos.importe)
                                            FROM ingresos
                                            JOIN ingresos_categoria ON ingresos.categoria = ingresos_categoria.id
                                            JOIN ingresos_subcategoria ON ingresos.subcategoria = ingresos_subcategoria.id
                                        WHERE ingresos_subcategoria.descripcion LIKE '%Plazo%'
                                        AND ingresos.fecha >= '2025-09-01'
                                ), 0) AS resultado";
                                
                    $plazo = mysqli_query($conexion, $plazo);
            endif;

            while($row = mysqli_fetch_assoc($plazo)) { ?>
                <p><?php echo number_format($row['resultado'], 2, ',', '.') ?></p>
            <?php } ?>
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
    <?php include("layout/footer.php"); ?>
    
    <!-- NAV -->
    <script src="../../assets/js/nav.js"></script>
</body>
</html>