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
  <link rel="stylesheet" href="../../assets/css/income_expense.css?v=<?php echo filemtime('../../assets/css/income_expense.css'); ?>">
  <link rel="stylesheet" href="../../assets/css/styles.css?v=<?php echo filemtime('../../assets/css/styles.css'); ?>">

  <!-- ICONOS -->
  <?php include("layout/iconos.php"); ?>
</head>
<body>
  <!-- MENU DE NAVEGACION -->
  <?php include("layout/nav.php"); ?>

  <!-- TITULO -->
  <section class="title">
    <h2>Ingresos</h2>
  </section>

  <!-- CONTENEDOR GENERAL -->
  <div class="tab-wrapper">

    <!-- CONTENEDOR DE LOS TABS -->
    <div class="tabs">
      <!-- INGRESAR -->
      <button class="tab active" data-tab="ingresar">Ingresar</button>
      <!-- VER LISTA -->
      <button class="tab" data-tab="ver">Ver lista</button>
    </div>

    <!-- CONTENEDOR DE INGRESAR -->
    <main class="tab-content" id="ingresar">
      <!-- FORMULARIO PARA INGRESAR -->
      <form action="../actions/insert_income.php" method="POST">
        <!-- FECHA -->
        <div>
          <label for="fecha">Fecha</label>
          <input type="date" name="fecha" id="fecha" required value="<?= date('Y-m-d'); ?>">
        </div>

        <!-- CATEGORIA -->
        <div>
          <label for="categoria">Categoria</label>
          <select id="categoria" name="categoria"></select>
        </div>

        <!-- SUBCATEGORIA -->
        <div>
          <label for="subcategoria">Subcategoria</label>
          <select id="subcategoria" name="subcategoria"></select>
        </div>

        </select>

        <!-- IMPORTE -->
        <div>
          <label for="importe">Importe</label>
          <input type="number" name="importe" id="importe" min=0.00 step='0.01' required>
        </div>

        <input type="submit" value="Ingresar">
      </form>
    </main>

    <!-- CONTENEDOR DE LA LISTA -->
    <main class="tab-content" id="ver" style="display: none">
      <?php
          $query = "SELECT ingresos.id,
                          ingresos_categoria.descripcion AS categoria,
                          ingresos_subcategoria.descripcion AS subcategoria,
                          ingresos.importe
                    FROM ingresos
                    JOIN ingresos_categoria ON ingresos.categoria = ingresos_categoria.id
                    JOIN ingresos_subcategoria ON ingresos.subcategoria = ingresos_subcategoria.id
                    WHERE MONTH(fecha) = 8 
                    ORDER BY ingresos.id DESC";

      $resultado = mysqli_query($conexion, $query); ?>

      <table cellspacing="0">
        <thead>
            <tr>
              <th>Categoria</th>
              <th>SubCategoria</th>
              <th>Importe</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($fila = $resultado->fetch_assoc()): ?>
              <tr>
                <td><?= $fila['categoria'] ?></td>
                <td><?= $fila['subcategoria'] ?></td>
                <td><?= number_format($fila['importe'], 2, ',', '.') ?></td>    
              </tr>
            <?php endwhile ?>
        </tbody>
      </table>
    </main>
  </div>

  <!-- FOOTER -->
  <?php include("layout/footer.php"); ?>

  <!-- SCRIPT PARA EL AUTOCOMPLETADO DE SUBCATEGORIA -->
  <script>
    const ruta = '../actions/';

    fetch(ruta + 'get_income_cat.php')
    .then(res => res.json())
    .then(data => {
      const selectCat = document.getElementById('categoria');
      selectCat.innerHTML = data.map(c =>
        `<option value="${c.id}">${c.descripcion}</option>`
      ).join('');
      if (data.length) cargarSubcategorias(data[0].id);
    });

    document.getElementById('categoria').addEventListener('change', function () {
      cargarSubcategorias(this.value);
    });

    function cargarSubcategorias(id_categoria) {
      fetch(`${ruta}get_income_sub.php?id_categoria=${id_categoria}`)
        .then(res => res.json())
        .then(data => {
          const selectSub = document.getElementById('subcategoria');
          selectSub.innerHTML = data.map(s =>
            `<option value="${s.id}">${s.descripcion}</option>`
          ).join('');
        });
    }
  </script>

  <!-- NAV -->
  <script src="../../assets/js/nav.js"></script>

  <!-- TABS -->
  <script src="../../assets/js/tabs.js"></script>
</body>
</html>