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

// Obtener los datos del usuario
$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT nombre_usuario, email, biografia, avatar FROM usuarios WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param('i', $usuario_id);
$stmt->execute();
$stmt->bind_result($nombre_usuario, $email, $biografia, $avatar);
$stmt->fetch();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo_email = $_POST['email'];
    $nueva_biografia = $_POST['biografia'];
    
    $sql_update = "UPDATE usuarios SET email = ?, biografia = ? WHERE id = ?";
    $stmt_update = $conexion->prepare($sql_update);
    $stmt_update->bind_param('ssi', $nuevo_email, $nueva_biografia, $usuario_id);
    if ($stmt_update->execute()) {
        echo "Perfil actualizado correctamente.";
        header('Location: perfil.php');
        exit();
    } else {
        echo "Error al actualizar el perfil.";
    }
    $stmt_update->close();
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="foro.php">Foro</a></li>
                <li><a href="perfil.php">Perfil</a></li>
                <li><a href="logout.php">Cerrar sesión</a></li>
            </ul>
        </nav>
    </header>

    <h2>Perfil de Usuario</h2>
    
    <!-- Mostrar avatar del usuario -->
    <?php if (!empty($avatar)): ?>
        <img src="uploads/<?php echo htmlspecialchars($avatar); ?>" alt="Avatar" style="width:100px;height:100px;">
    <?php endif; ?>

    <form action="perfil.php" method="POST">
        <label for="nombre_usuario">Nombre de usuario:</label>
        <input type="text" name="nombre_usuario" value="<?php echo htmlspecialchars($nombre_usuario); ?>" disabled>
        
        <label for="email">Correo electrónico:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>">

        <label for="biografia">Biografía:</label>
        <textarea name="biografia" id="biografia"><?php echo htmlspecialchars($biografia); ?></textarea>

        <button type="submit">Guardar Cambios</button>
    </form>
</body>
</html>
