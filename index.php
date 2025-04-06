<?php
session_start();
include 'php/db.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["usuario_id"])) {
    header("Location: inicio_registro.php");
    exit();
}

$usuario_id = $_SESSION["usuario_id"];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Torre de Babel</title>
    <link rel="icon" href="assets/images/logo.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/estilos.css">
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
        <div class="auth-buttons">
            <?php if (isset($_SESSION["usuario_id"])): ?>
                <!-- Verificar si el usuario es admin y mostrar el enlace a admin.php -->
                <?php if ($_SESSION["es_admin"] == 1): ?>
                    <a href="admin.php">Administrar Usuarios</a>
                <?php endif; ?>
                <a href="php/logout.php">Cerrar Sesión</a>
            <?php else: ?>
                <a href="inicio_registro.php">Inicio - Registro</a>
            <?php endif; ?>
        </div>
    </ul>
    <div class="menu-icon" onclick="toggleMenu()">☰</div>
</nav>


    
    <div class="separador"></div>

                <!--CUERPO PRINCIPAL DEL DOCUMENTO-->

    <main class="main_inicio">
        <section class="intro">
            <h1>Bienvenido a nuestra plataforma de gestión de libros</h1>
            <p>Explora nuestro catálogo, organiza tus lecturas y disfruta de una experiencia personalizada.<br> ¡Comienza a gestionar tus libros ahora!</p>

        </section>

        <section class="features">
            <h2>¿Por qué registrarte?</h2>
            <div class="feature">
                <img src="assets/images/images_index/catalogo.png" alt="Catálogo de Libros">
                <h3>Catálogo de libros</h3>
                <p>Accede a una amplia variedad de libros y organízalos a tu gusto.</p>
            </div>
            <div class="feature">
                <img src="assets/images/images_index/organizador.png" alt="Organización de Libros">
                <h3>Organiza tus libros</h3>
                <p>Clasifica tus libros en estanterías personalizadas y realiza un seguimiento de tu lectura.</p>
            </div>
            <div class="feature">
                <img src="assets/images/images_index/recomendacion.png" alt="Recomendaciones">
                <h3>Recomendaciones</h3>
                <p>Recibe recomendaciones basadas en tus gustos y preferencias.</p>
            </div>
        </section>

        <p>En <strong>Torre de Babel</strong>, reunimos la diversidad de libros de todos los géneros, idiomas y culturas en una sola plataforma. Como la Torre de Babel unía a las personas con un mismo propósito, nuestra misión es conectar el conocimiento global, superando cualquier barrera. Gestiona, organiza y descubre libros de todo el mundo sin límites, en un solo lugar.</p>

        <section class="features">
            <h2>Algunos beneficios de utilizar nuestro servicio</h2>
        <div class="feature">
                <img src="assets/images/images_index/tierra.png" alt="Recomendaciones">
                <h3>Multilingüe</h3>
                <p>Catálogo con libros en cualquier idioma.</p>
            </div>
            <div class="feature">
                <img src="assets/images/images_index/gratis.png" alt="Recomendaciones">
                <h3>Gratuito</h3>
                <p>No pagues por nada, las funcionalidades son gratuitas.</p>
            </div>
            <div class="feature">
                <img src="assets/images/images_index/multiplataforma.png" alt="Recomendaciones">
                <h3>Multiplataforma</h3>
                <p>Revisa tu biblioteca en cualquier momento.</p>
            </div>
        </section>
    </main>

        <!--PIE DE PAGINA-->

        <div class="separador"></div>
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
