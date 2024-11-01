<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foro</title>
    <link rel="stylesheet" href="css/estilos.css"> <!-- Enlace al archivo CSS -->
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="foro.php">Foro</a></li>
                
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <!-- Enlace al perfil si el usuario está logueado -->
                    <li><a href="perfil.php?id=<?php echo $_SESSION['usuario_id']; ?>">Mi Perfil</a></li>
                    <li><span>Bienvenido, <?php echo $_SESSION['nombre_usuario']; ?></span></li>
                    <li><a href="logout.php">Cerrar sesión</a></li>
                <?php else: ?>
                    <!-- Enlaces de inicio de sesión y registro si el usuario no está logueado -->
                    <li><a href="login.html">Iniciar sesión</a></li>
                    <li><a href="register.html">Registrarse</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
</body>
</html>

