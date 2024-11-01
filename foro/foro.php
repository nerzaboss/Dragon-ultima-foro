<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.html');
    exit();
}

$conexion = new mysqli('localhost', 'root', '', 'foro');
if ($conexion->connect_error) {
    die('Error en la conexión: ' . $conexion->connect_error);
}

$sql = "SELECT t.id, t.titulo, t.fecha_creacion, u.nombre_usuario 
        FROM temas_nueva t 
        JOIN usuarios u ON t.id_usuario = u.id 
        ORDER BY t.fecha_creacion DESC";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foro</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="foro.php">Foro</a></li>
                <li><a href="perfil.php?id=<?php echo $_SESSION['usuario_id']; ?>">Mi Perfil</a></li> <!-- Enlace al perfil -->
                <li>Bienvenido, <?php echo $_SESSION['nombre_usuario']; ?></li>
                <li><a href="logout.php">Cerrar sesión</a></li>
            </ul>
        </nav>
    </header>

    <h1>Bienvenido al Foro, <?php echo $_SESSION['nombre_usuario']; ?></h1>
    <h2>Temas recientes</h2>

    <?php while ($tema = $resultado->fetch_assoc()) { ?>
        <div>
            <h3><?php echo $tema['titulo']; ?></h3>
            <p>Creado por: <?php echo $tema['nombre_usuario']; ?> en <?php echo $tema['fecha_creacion']; ?></p>
            <a href="ver_tema.php?id_tema=<?php echo $tema['id']; ?>">Ver Tema</a>
        </div>
    <?php } ?>

    <h2>Crear nuevo tema</h2>
    <form action="crear_tema.php" method="POST">
        <label for="titulo">Título del tema:</label>
        <input type="text" name="titulo" id="titulo" required>
        
        <label for="contenido">Contenido:</label>
        <textarea name="contenido" id="contenido" required></textarea>
        
        <button type="submit">Crear Tema</button>
    </form>
</body>
</html>

<?php
$conexion->close();
?>
