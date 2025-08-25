<?php
    include("config/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- META -->
    <?php include("php/pages/layout/meta.php"); ?>

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/index.css?v=<?php echo filemtime('assets/css/index.css'); ?>">
    <link rel="stylesheet" href="assets/css/styles.css?v=<?php echo filemtime('assets/css/styles.css'); ?>">

    <!-- ICONOS -->
    <?php include("php/pages/layout/iconos.php"); ?>
</head>
<body>
    <form action="php/auth/check.php" method="post">
        <fieldset>
            <legend>iniciar sesión</legend>
            <div>
                <label for="usuario"><i class="fas fa-user"></i></label>
                <input type="mail" id="usuario" name="user" required placeholder="Usuario">
            </div>

            <div>
                <label for="password"><i class="fas fa-lock"></i></label>
                <input type="password" id="password" name="password" required placeholder="Contraseña">
            </div>
            
            <input type="submit" id="entrar" name="entrar" value="Entrar"> 
        </fieldset>

        <!-- MENSAJES DE ERROR  -->
        <?php if (!empty($_GET['error'])):
            $mensaje = '';
            switch ($_GET['error']) {
                case '1':
                    $mensaje = 'Usuario o contraseña incorrectos.';
                    break;
                case '2':
                    $mensaje = 'Su sesión ha expirado. Vuelva a iniciar sesión.';
                    break;
                case '3':
                    $mensaje = 'Debe iniciar sesión para acceder a esta página.';
                    break;
                default:
                    $mensaje = 'Ha ocurrido un error. Inténtelo nuevamente.';
                    break;
            }

            echo '<div class="error-message">' . htmlspecialchars($mensaje) . '</div>';
        endif ?>
    </form>

    <?php include("php/pages/layout/footer.php"); ?>
</body>
</html>