<?php

$conexion = new mysqli('localhost', 'usuario', 'contraseña', 'dragon_ultima_foro');

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $conexion->real_escape_string($_POST['titulo']);
    $contenido = $conexion->real_escape_string($_POST['contenido']);

    $sql = "INSERT INTO temas (titulo, contenido) VALUES ('$titulo', '$contenido')";

    if ($conexion->query($sql) === TRUE) {
        echo "Nuevo tema creado con éxito";
        header('Location: foro.php'); // Redirigir al foro
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}

$conexion->close();
?>
