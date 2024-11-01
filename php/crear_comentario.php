<?php
// Conectar con la base de datos
$conexion = new mysqli('localhost', 'usuario', 'contraseña', 'dragon_ultima_foro');

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tema_id = intval($_POST['tema_id']);
    $contenido = $conexion->real_escape_string($_POST['contenido']);

    $sql = "INSERT INTO comentarios (tema_id, contenido) VALUES ('$tema_id', '$contenido')";

    if ($conexion->query($sql) === TRUE) {
        echo "Comentario publicado con éxito";
        header('Location: tema.php?id=' . $tema_id); // Redirigir de nuevo al tema
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}

$conexion->close();
?>
