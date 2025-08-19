<?php
    include("config/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- META -->
    <?php include("php/pages/layout/meta.php"); ?>

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/index.css">

    <!-- ICONOS -->
    <?php include("php/pages/layout/iconos.php"); ?>
</head>
<body>
    <main>
        <form action="php/auth/check.php" method="post">
            <fieldset>
                <legend>iniciar sesión</legend>
                <div>
                    <label for="usuario"><i class="fas fa-user"></i></label>
                    <input type="text" id="usuario" name="user" required placeholder="Usuario">
                </div>

                <div>
                    <label for="password"><i class="fas fa-lock"></i></label>
                    <input type="password" id="password" name="password" required placeholder="Contraseña">
                </div>
            </fieldset>
            <input type="submit" id="entrar" name="entrar" value="Entrar"> 
        </form>

    </main>
    <?php include("php/pages/layout/footer.php"); ?>
</body>
</html>