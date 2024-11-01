<?php
// Conectar a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'foro');

// Verificar si la conexión fue exitosa
if ($conexion->connect_error) {
    die('Error en la conexión: ' . $conexion->connect_error);
}

// Verificar si se enviaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario = $conexion->real_escape_string($_POST['nombre_usuario']);
    $email = $conexion->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar la contraseña

    // Insertar el usuario en la base de datos
    $sql = "INSERT INTO usuarios (nombre_usuario, email, password) VALUES ('$nombre_usuario', '$email', '$password')";

    if ($conexion->query($sql) === TRUE) {
        // Redirigir al login después del registro exitoso
        header('Location: login.html');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}

$conexion->close();
?>
