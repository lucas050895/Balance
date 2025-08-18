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
    <link rel="stylesheet" href="../../css/arching.css">

    <!-- ICONOS -->
    <?php include("../../layout/iconos.php"); ?>
</head>
<body>
    <!-- MENU DE NAVEGACION -->
    <?php include("../../layout/nav.php"); ?>

    <!-- TITULO -->
    <div class="title">
        <h2>Arqueo</h2>
    </div>

    <!-- CONTENIDO GENERAL -->
    <?php
        if ($conexion) {
            // OBTENER AÑOS
            $años_query = "SELECT DISTINCT YEAR(fecha) AS año FROM (
                                SELECT fecha FROM ingresos
                                UNION
                                SELECT fecha FROM egresos
                            ) AS fechas ORDER BY año DESC";
            $años_result = mysqli_query($conexion, $años_query);

            // AÑO ACTUAL
            $año_seleccionado = isset($_GET['año']) ? $_GET['año'] : date('Y');
        }
    ?>

    <!-- AÑOS DISPONIBLES -->
    <form method="GET">
        <select name="año" onchange="this.form.submit()">
            <?php while($row = mysqli_fetch_assoc($años_result)) { ?>
                <option value="<?= $row['año'] ?>" <?= $row['año'] == $año_seleccionado ? 'selected' : '' ?>>
                    <?= $row['año'] ?>
                </option>
            <?php } ?>
        </select>
    </form>

    <main>

        <!-- MOSTRAR TODOS LOS MESES -->
        <?php
            $meses = [ 'Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic' ];

            $saldo_acumulado = 0;

            for ($i = 1; $i <= 12; $i++) {
                $inicio = "$año_seleccionado-" . str_pad($i, 2, '0', STR_PAD_LEFT) . "-01";
                $fin = date("Y-m-t", strtotime($inicio));

                $query = "SELECT
                            (SELECT SUM(importe) FROM ingresos WHERE fecha BETWEEN '$inicio' AND '$fin') -
                            (SELECT SUM(importe) FROM egresos WHERE fecha BETWEEN '$inicio' AND '$fin') AS diferencia";
                $resultado = mysqli_query($conexion, $query);
                $row = mysqli_fetch_array($resultado);
                $diferencia = $row['diferencia'];

                // Solo actualiza el acumulado si hay movimientos
                if ($diferencia !== null) {
                    $saldo_acumulado += $diferencia;
                    $mostrar = '$ ' . number_format($saldo_acumulado, 2, ',', '.');
                    $clase = $saldo_acumulado >= 0 ? 'positivo' : 'negativo';
                } else {
                    $mostrar = '-';
                    $clase = '';
                }
                ?>
                <div class="mes <?= $clase ?>">
                    <h2><?= $meses[$i-1] ?></h2>
                    <p>
                       <?= $mostrar ?>
                    </p>
                </div>
                <?php
            } ?>


        

    </main>

    <!-- FOOTER -->
    <?php include("../../layout/footer.php"); ?>

    <script src="../../js/nav.js"></script>
</body>
</html>