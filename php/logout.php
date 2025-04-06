<?php
session_start();
session_destroy();
header("Location:../index.php"); // Redirigir al inicio después de cerrar sesión
exit();
?>
