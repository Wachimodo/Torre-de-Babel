<?php
$host = "localhost";  // Cambia si tu servidor MySQL está en otro lugar
$usuario = "root";    // Cambia por tu usuario de MySQL
$clave = "";          // Si tienes una contraseña en MySQL, ponla aquí
$base_de_datos = "torre_de_babel";

// Crear conexión
$conn = new mysqli($host, $usuario, $clave, $base_de_datos);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

?>
