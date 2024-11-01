<?php
// Conectar con la base de datos
$conexion = new mysqli('localhost', 'usuario', 'contraseña', 'dragon_ultima_foro');

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$tema_id = intval($_GET['id']);

// Obtener el tema
$tema_resultado = $conexion->query("SELECT * FROM temas WHERE id = '$tema_id'");
$tema = $tema_resultado->fetch_assoc();

echo "<h1>" . $tema['titulo'] . "</h1>";
echo "<p>" . $tema['contenido'] . "</p>";

// Obtener los comentarios
$comentarios_resultado = $conexion->query("SELECT * FROM comentarios WHERE tema_id = '$tema_id' ORDER BY fecha_creacion DESC");

echo "<h2>Comentarios</h2>";
while ($comentario = $comentarios_resultado->fetch_assoc()) {
    echo "<p>" . $comentario['contenido'] . "</p>";
}

$conexion->close();
?>
