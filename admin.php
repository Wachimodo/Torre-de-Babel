<?php
session_start();
include 'php/db.php'; // Archivo para conectar a la base de datos

if (!isset($_SESSION['usuario_id']) || $_SESSION['es_admin'] != 1) {
    header("Location: inicio_registro.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Obtener la lista de usuarios
$query = "SELECT * FROM usuarios";
$result = mysqli_query($conn, $query);

// Si se presiona el botón para eliminar un usuario
if (isset($_GET['eliminar'])) {
    $usuario_a_eliminar = $_GET['eliminar'];
    $query_delete = "DELETE FROM usuarios WHERE id = ?";
    $stmt_delete = $conn->prepare($query_delete);
    $stmt_delete->bind_param("i", $usuario_a_eliminar);
    $stmt_delete->execute();
    $stmt_delete->close();
    header("Location: admin.php");
    exit();
}

// Si se presiona el botón para cambiar el rol de admin
if (isset($_GET['cambiar_admin'])) {
    $usuario_a_cambiar = $_GET['cambiar_admin'];
    $query_update = "UPDATE usuarios SET es_admin = NOT es_admin WHERE id = ?";
    $stmt_update = $conn->prepare($query_update);
    $stmt_update->bind_param("i", $usuario_a_cambiar);
    $stmt_update->execute();
    $stmt_update->close();
    header("Location: admin.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Torre de Babel</title>
    <link rel="icon" href="assets/images/logo.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body>
    <!-- Barra de navegación -->
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

    <!-- CUERPO PRINCIPAL DEL DOCUMENTO -->
    <main class="main_inicio">
        <section class="intro">
            <h1>Panel de Administración</h1>
            <p>Desde aquí puedes gestionar los usuarios de la plataforma, eliminar cuentas y modificar permisos de administrador.</p>
        </section>

        <section class="admin-features">
            <h2>Gestión de Usuarios</h2>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
    <?php while ($usuario = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?php echo htmlspecialchars($usuario['nombre_completo']); ?></td>
        <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
        <td><?php echo $usuario['es_admin'] ? 'Administrador' : 'Usuario'; ?></td>
        <td>
            <a href="?cambiar_admin=<?php echo $usuario['id']; ?>" class="cta-button">
                <?php echo $usuario['es_admin'] ? 'Quitar Admin' : 'Dar Admin'; ?>
            </a>
            <a href="?eliminar=<?php echo $usuario['id']; ?>" class="cta-button" style="background-color: #e74c3c;">
                Eliminar
            </a>
        </td>
    </tr>
    <?php endwhile; ?>
</tbody>

            </table>
        </section>
    </main>

    <!-- PIE DE PAGINA -->
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
