<?php
session_start();
include 'db.php'; // Asegúrate de tener la conexión a la base de datos aquí.

if (isset($_SESSION['usuario_id'])) {
    // Recibimos los datos enviados desde el fetch
    $usuario_id = $_SESSION['usuario_id'];
    $title = $_POST['title'];
    $authors = $_POST['authors'];
    $image = $_POST['image'];

    // Consulta para insertar el libro en la base de datos
    $sql = "INSERT INTO biblioteca_usuario (usuario_id, titulo, autores, imagen) 
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $usuario_id, $title, $authors, $image);

    if ($stmt->execute()) {
        echo "Libro agregado a tu biblioteca.";
    } else {
        echo "Error al agregar el libro: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Debes iniciar sesión para agregar un libro.";
}
?>
