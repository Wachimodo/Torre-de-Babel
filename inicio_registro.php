<?php
session_start();
if (isset($_SESSION['usuario_id'])) {
    header("Location: catalogo.php");
    exit();
}

$mensaje = "";
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    unset($_SESSION['mensaje']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Registro | Torre de Babel</title>
    <link rel="icon" href="assets/images/logo.png" type="image/png">
    <link rel="stylesheet" href="assets/css/style_reg_sesi.css">
</head>
<body>

<nav class="navbar">
    <div class="logo"> 
        <a href="index.php"><img src="assets/images/logo.png" alt="Logo"></a>
        <a href="index.php" class="logo-text">Torre de Babel</a>
    </div>
    <ul class="nav-links">
        <li><a href="catalogo.php">Catálogo</a></li>
        <li><a href="servicios.php">Mi Biblioteca</a></li>
        <li class="auth-buttons"><a href="inicio_registro.php">Inicio - Registro</a></li>
    </ul>
    <div class="menu-icon" onclick="toggleMenu()">☰</div>
</nav>

<main>
    <div class="contenedor__todo">
        <div class="caja__trasera">
            <div class="caja__trasera-login">
                <h3>¿Ya tienes una cuenta?</h3>
                <p>Inicia sesión para entrar en la página</p>
                <button id="btn__iniciar-sesion">Iniciar Sesión</button>
            </div>
            <div class="caja__trasera-register">
                <h3>¿Aún no tienes una cuenta?</h3>
                <p>Regístrate para que puedas iniciar sesión</p>
                <button id="btn__registrarse">Registrarse</button>
            </div>
        </div>

        <div class="contenedor__login-register">
            <!-- Mostrar mensajes de error -->
            <?php if (!empty($mensaje)) { ?>
                <div class="mensaje"><?php echo $mensaje; ?></div>
            <?php } ?>

            <!-- Login -->
            <form action="php/inicio_usuario_be.php" method="POST" class="formulario__login">
                <h2>Iniciar Sesión</h2>
                <input type="email" placeholder="Correo Electrónico" name="correo" required>
                <input type="password" placeholder="Contraseña" name="contrasena" required>
                <button type="submit">Entrar</button>
            </form>

            <!-- Registro -->
            <form action="php/registro_usuario_be.php" method="POST" class="formulario__register">
                <h2>Registrarse</h2>
                <input type="text" placeholder="Nombre completo" name="nombre_completo" required>
                <input type="email" placeholder="Correo Electrónico" name="correo" required>
                <input type="text" placeholder="Usuario" name="usuario" required>
                <input type="password" placeholder="Contraseña" name="contrasena" required>
                <button type="submit">Registrarse</button>
            </form>
        </div>
    </div>
</main>

<footer>
    <p>&copy; 2025 Plataforma de Libros. Todos los derechos reservados a Mohamed Iachi Ahmed.</p>
</footer>

<script src="assets/js/script.js"></script>
<script>
    function toggleMenu() {
        document.querySelector('.nav-links').classList.toggle('show');
    }
</script>

</body>
</html>
