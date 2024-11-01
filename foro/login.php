<?php
// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'foro');

if ($conexion->connect_error) {
    die('Error en la conexión: ' . $conexion->connect_error);
}

// Recibir datos del formulario
$nombre_usuario = $_POST['nombre_usuario'];
$password = $_POST['password'];

// Verificar el usuario y la contraseña
$sql = "SELECT * FROM usuarios WHERE nombre_usuario='$nombre_usuario'";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();
    
    if (password_verify($password, $usuario['password'])) {
        // Inicio de sesión exitoso
        session_start();
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
        header('Location: foro.php');
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "El nombre de usuario no existe.";
}

$conexion->close();
?>
