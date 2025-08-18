<?php

  // Inicia la sesión
  session_start();

  // Verifica si el usuario está logueado.
  if (!isset($_SESSION['usuario'])) {
      // Si no está logueado, redirige a la página de inicio de sesión.
      header("Location: ../../index.php");
      // exit();
  }else {
      //sino, calculamos el tiempo transcurrido
      $fechaGuardada = $_SESSION["ultimoAcceso"];

      $ahora = date("Y-n-j H:i:s");
      
      $tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada));

      //comparamos el tiempo transcurrido
      if($tiempo_transcurrido >= 1200) {
        //si pasaron 10 minutos o más
        session_destroy(); // destruyo la sesión
        header("Location: ../../index.php"); //envío al usuario a la pag. de autenticación
        //sino, actualizo la fecha de la sesión
      }else {
        $_SESSION["ultimoAcceso"] = $ahora;
      }
  }

  $arregloUsuario = $_SESSION['usuario']; 