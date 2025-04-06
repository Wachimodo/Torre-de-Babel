<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];

    // Modificar la consulta para incluir también el campo es_admin
    $sql = "SELECT id, usuario, contrasena, es_admin FROM usuarios WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $usuario, $hash, $es_admin);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($contrasena, $hash)) {
        // Establecer las variables de sesión, incluida es_admin
        $_SESSION["usuario_id"] = $id;
        $_SESSION["usuario"] = $usuario;
        $_SESSION["es_admin"] = $es_admin;  // Guardar si el usuario es administrador
        
        // Redirigir al catálogo o donde sea necesario
        header("Location: ../catalogo.php");
    } else {
        $_SESSION["mensaje"] = "Correo o contraseña incorrectos.";
        header("Location: ../inicio_registro.php");
    }

    $stmt->close();
    $conn->close();
}
?>
