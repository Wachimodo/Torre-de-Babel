<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_completo = $_POST["nombre_completo"];
    $correo = $_POST["correo"];
    $usuario = $_POST["usuario"];
    $contrasena = password_hash($_POST["contrasena"], PASSWORD_BCRYPT); // Encripta la contraseña

    // Ingresar al usuario con es_admin = 0 (por defecto)
    $sql = "INSERT INTO usuarios (nombre_completo, correo, usuario, contrasena) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre_completo, $correo, $usuario, $contrasena);

    if ($stmt->execute()) {
        $_SESSION["mensaje"] = "Registro exitoso, ahora puedes iniciar sesión.";
        header("Location: ../inicio_registro.php"); // Redirigir al inicio
    } else {
        $_SESSION["mensaje"] = "Error al registrar: " . $conn->error;
        header("Location: ../inicio_registro.php"); // Redirigir con mensaje de error
    }

    $stmt->close();
    $conn->close();
}
?>
