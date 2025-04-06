<?php
session_start();
include 'php/db.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["usuario_id"])) {
    header("Location: inicio_registro.php");
    exit();
}

$usuario_id = $_SESSION["usuario_id"];

// Consultar los libros del usuario
$sql = "SELECT id, titulo, autores, imagen FROM biblioteca_usuario WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Biblioteca | Torre de Babel</title>
    <link rel="icon" href="assets/images/logo.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
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

<main>
    <section class="intro">
        <h1>Tu Biblioteca</h1>
        <p>Aquí puedes ver los libros que has agregado.</p>
    </section>

    <section class="catalog">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($libro = $result->fetch_assoc()): ?>
                <div class="book">
                    <img src="<?php echo htmlspecialchars($libro['imagen']); ?>" alt="<?php echo htmlspecialchars($libro['titulo']); ?>">
                    <h3><?php echo htmlspecialchars($libro['titulo']); ?></h3>
                    <p><strong>Autor(es):</strong> <?php echo htmlspecialchars($libro['autores']); ?></p>
                    <form action="php/eliminar_libro.php" method="POST">
                        <input type="hidden" name="libro_id" value="<?php echo $libro['id']; ?>">
                        <button type="submit" class="btn-eliminar">Eliminar</button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No has agregado libros a tu biblioteca.</p>
        <?php endif; ?>
    </section>
</main>

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

<?php
$stmt->close();
$conn->close();
?>
