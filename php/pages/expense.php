<?php
  include("../../config/conexion.php");
  include("../../config/sesion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <!-- META -->
  <?php include("../../layout/meta.php"); ?>

  <link rel="stylesheet" href="../../css/income_expense.css">

  <!-- ICONOS -->
  <?php include("../../layout/iconos.php"); ?>
</head>
<body>
  <!-- MENU DE NAVEGACION -->
  <?php include("../../layout/nav.php"); ?>

  <!-- TITULO -->
  <section class="title">
    <h2>Egresos</h2>
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
      <form action="../actions/insert_expense.php" method="POST">
        <!-- FECHA -->
        <div>
          <label for="fecha">Fecha</label>
          <input type="date" name="fecha" id="fecha" required>
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

        <!-- IMPORTE -->
        <div>
          <label for="importe">Importe</label>
          <input type="number" name="importe" id="importe" min=0.00 step='0.01' required>
        </div>

        <input type="submit" value="Ingresar">
      </form>
    </main>

    <!-- CONTENEDOR DE LA LISTA -->
    <main class="tab-content" id="ver" style="display: none;">

    </main>
  </div>

  <!-- FOOTER -->
  <?php include("../../layout/footer.php"); ?>

  <!-- SCRIPT PARA EL AUTOCOMPLETADO DE SUBCATEGORIA -->
  <script>
    const ruta = '../actions/';

    fetch(ruta + 'get_expense_cat.php')
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
      fetch(`${ruta}get_expense_sub.php?id_categoria=${id_categoria}`)
        .then(res => res.json())
        .then(data => {
          const selectSub = document.getElementById('subcategoria');
          selectSub.innerHTML = data.map(s =>
            `<option value="${s.id}">${s.descripcion}</option>`
          ).join('');
        });
    }
  </script>

  <script src="../../js/nav.js"></script>
  <script src="../../js/tabs.js"></script>

</body>
</html>