<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["libro_id"])) {
    $libro_id = $_POST["libro_id"];
    $usuario_id = $_SESSION["usuario_id"]; // Asegurar que solo borre libros del usuario

    $sql = "DELETE FROM biblioteca_usuario WHERE id = ? AND usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $libro_id, $usuario_id);

    if ($stmt->execute()) {
        // Redirigir para actualizar la lista de libros sin necesidad de F5
        header("Location: ../servicios.php");
        exit();
    } else {
        echo "Error al eliminar el libro.";
    }

    $stmt->close();
}

$conn->close();
?>
