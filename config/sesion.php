<?php
  session_start();

  if (!isset($_SESSION['usuario'])) {
      header("Location: ../../index.php?error=3");
      exit();
  }

  if (!isset($_SESSION["ultimoAcceso"])) {
      $_SESSION["ultimoAcceso"] = date("Y-n-j H:i:s");
  }

  $ahora = time();
  $ultimoAcceso = strtotime($_SESSION["ultimoAcceso"]);
  $tiempo_transcurrido = $ahora - $ultimoAcceso;

  if ($tiempo_transcurrido >= 300) {
      session_destroy();
      header("Location: ../../index.php?error=2");
      exit();
  } else {
      $_SESSION["ultimoAcceso"] = date("Y-n-j H:i:s");
  }

  $arregloUsuario = $_SESSION['usuario'];

  