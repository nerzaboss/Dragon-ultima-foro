<?php
session_start();
session_unset(); // Limpiar todas las variables de sesión
session_destroy(); // Destruir la sesión
header('Location: login.html'); // Redirigir al login después de cerrar sesión
exit();
?>
