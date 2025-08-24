<?php
    include("../../config/conexion.php");
    include("../../config/sesion.php");

    // VALIDAR MES Y AÑO
    if (isset($_GET['mes']) && isset($_GET['año'])) {
        $mes = $_GET['mes'];
        $año = (int)$_GET['año'];

        $meses = [ 'Ene'=>1, 'Feb'=>2, 'Mar'=>3, 'Abr'=>4, 'May'=>5, 'Jun'=>6,
                'Jul'=>7, 'Ago'=>8, 'Sep'=>9, 'Oct'=>10, 'Nov'=>11, 'Dic'=>12 ];

        if (!array_key_exists($mes, $meses)) {
            header("Location: ../../index.php"); exit;
        }

        $mes_num = $meses[$mes];
        $inicio = sprintf("%d-%02d-01", $año, $mes_num);
        $fin = date("Y-m-t", strtotime($inicio));

        // CONSULTAS
        $query_ingresos = "SELECT * FROM ingresos WHERE fecha BETWEEN '$inicio' AND '$fin'";
        $query_egresos  = "SELECT * FROM egresos WHERE fecha BETWEEN '$inicio' AND '$fin'";

        $ingresos = mysqli_query($conexion, $query_ingresos);
        $egresos  = mysqli_query($conexion, $query_egresos);

    } else {
        // REDIRIGIR
        header("Location: http://lucasconde.ddns.net/Balance/php/pages/arching.php"); exit;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- META -->
    <?php include("layout/meta.php"); ?>

    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/css/arching.css?v=<?php echo filemtime('../../assets/css/arching.css'); ?>">
    <link rel="stylesheet" href="../../assets/css/styles.css?v=<?php echo filemtime('../../assets/css/styles.css'); ?>">

    <!-- ICONOS -->
    <?php include("layout/iconos.php"); ?>
</head>
<body>
    <!-- MENU DE NAVEGACION -->
    <?php include("layout/nav.php"); ?>

    <!-- TITULO -->
    <div class="title">
        <h2><?= $mes . " " . $año ?></h2>
    </div>


    <!-- CONTENEDOR GENERAL -->
    <div class="tab-wrapper">

        <!-- CONTENEDOR DE LOS TABS -->
        <div class="tabs">
        <!-- INGRESOS -->
        <button class="tab active" data-tab="ingresos">Ingresos</button>
        <!-- EGRESOS -->
        <button class="tab" data-tab="egresos">Egresos</button>
        </div>

        <!-- CONTENEDOR DE INGRESOS -->
        <main class="tab-content" id="ingresos">
            <?php
                $query_ingresos = "SELECT isub.descripcion AS subcategoria,
                                        SUM(i.importe) AS total
                                    FROM ingresos i
                                    JOIN ingresos_categoria ic ON i.categoria = ic.id
                                    JOIN ingresos_subcategoria isub ON i.subcategoria = isub.id
                                    WHERE i.fecha BETWEEN '$inicio' AND '$fin'
                                    GROUP BY isub.descripcion
                                    ORDER BY total DESC";
                $result_ingresos = mysqli_query($conexion, $query_ingresos);

                $labels_ing = [];
                $data_ing = [];
                $colors_ing = [];

                while($row = mysqli_fetch_assoc($result_ingresos)) {
                    $labels_ing[] = $row['subcategoria'];
                    $data_ing[] = $row['total'];

                    // Generar color aleatorio
                    $colors_ing[] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
                }
                
                if (!empty($data_ing)): ?>

                    <canvas id="ingresosChart" class="grafico"></canvas>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        const ctxIngresos = document.getElementById('ingresosChart').getContext('2d');
                        new Chart(ctxIngresos, {
                            type: 'pie',
                            data: {
                                labels: <?= json_encode($labels_ing) ?>,
                                datasets: [{
                                    data: <?= json_encode($data_ing) ?>,
                                    backgroundColor: <?= json_encode($colors_ing) ?>
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'bottom'
                                    }
                                }
                            }
                        });
                    </script>
                <?php else: ?>
                    <p>No hay ingresos en este mes.</p>
                <?php endif; ?>
        </main>


        <!-- CONTENEDOR DE EGRESOS-->
        <main class="tab-content" id="egresos" style="display: none">
            <?php
                $query_egresos = "SELECT es.descripcion AS subcategoria,
                                    SUM(e.importe) AS total
                                FROM egresos e
                                JOIN egresos_categoria ec ON e.categoria = ec.id
                                JOIN egresos_subcategoria es ON e.subcategoria = es.id
                                WHERE e.fecha BETWEEN '$inicio' AND '$fin'
                                GROUP BY es.descripcion
                                ORDER BY total DESC";
                $result_egresos = mysqli_query($conexion, $query_egresos);

                $labels = [];
                $data = [];
                $colors = [];

                while($row = mysqli_fetch_assoc($result_egresos)) {
                    $labels[] = $row['subcategoria'];
                    $data[] = $row['total'];

                    // Generar color aleatorio
                    $colors[] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
                }
                
                
            if (!empty($data)): ?>
                <canvas id="egresosChart" class="grafico"></canvas>
            <?php else: ?>
                <p>No hay egresos en este mes.</p>
            <?php endif; ?>
        </main>
    </div>

    
    <!-- <main>
        <section>
            <h3>Ingresos</h3>
            <?php if (mysqli_num_rows($ingresos) > 0): ?>
                <ul>
                <?php while($row = mysqli_fetch_assoc($ingresos)): ?>
                    <li><?= $row['fecha'] ?> - $ <?= number_format($row['importe'], 2, ',', '.') ?> <?= $row['detalle'] ?? '' ?></li>
                <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>No hay ingresos en este mes.</p>
            <?php endif; ?>
        </section>

        <section>
            <h3>Egresos</h3>
            <?php if (mysqli_num_rows($egresos) > 0): ?>
                <ul>
                <?php while($row = mysqli_fetch_assoc($egresos)): ?>
                    <li><?= $row['fecha'] ?> - $ <?= number_format($row['importe'], 2, ',', '.') ?> <?= $row['detalle'] ?? '' ?></li>
                <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>No hay egresos en este mes.</p>
            <?php endif; ?>
        </section>
    </main> -->

    <!-- FOOTER -->
    <?php include("layout/footer.php"); ?>

    <!-- NAV -->
    <script src="../../assets/js/nav.js"></script>

    <!-- TABS -->
    <script>
        let egresosChartCreado = false;

        const tabs = document.querySelectorAll(".tab");
        const contents = document.querySelectorAll(".tab-content");

        tabs.forEach((tab) => {
            tab.addEventListener("click", () => {
            tabs.forEach((t) => t.classList.remove("active"));
            tab.classList.add("active");

            const selected = tab.getAttribute("data-tab");
            contents.forEach((c) => {
                c.style.display = c.id === selected ? "block" : "none";
            });

            // Si se selecciona la pestaña de egresos y aún no se creó el gráfico
            if (selected === "egresos" && !egresosChartCreado) {
                const ctxEgresos = document.getElementById('egresosChart').getContext('2d');
                new Chart(ctxEgresos, {
                type: 'pie',
                data: {
                    labels: <?= json_encode($labels) ?>,
                    datasets: [{
                    data: <?= json_encode($data) ?>,
                    backgroundColor: <?= json_encode($colors) ?>
                    }]
                },
                options: {
                responsive: false,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                    position: 'bottom'
                    }
                }
                }
                });
                egresosChartCreado = true;
            }
            });
        });
    </script>
</body>
</html>
