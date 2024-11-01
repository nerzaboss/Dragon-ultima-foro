<?php
session_start();


if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.html');
    exit();
}

$conexion = new mysqli('localhost', 'root', '', 'foro');


$id_tema = (int) $_POST['id_tema'];
$contenido = $conexion->real_escape_string($_POST['contenido']);
$id_usuario = $_SESSION['usuario_id'];

$sql = "INSERT INTO comentarios (id_tema, id_usuario, contenido) VALUES ($id_tema, $id_usuario, '$contenido')";

if ($conexion->query($sql) === TRUE) {
    header("Location: ver_tema.php?id_tema=$id_tema");
} else {
    echo "Error al agregar el comentario: " . $conexion->error;
}

$conexion->close();
?>
