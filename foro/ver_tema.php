<?php
session_start();

// Conectar a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'foro');
if ($conexion->connect_error) {
    die('Error en la conexión: ' . $conexion->connect_error);
}

// Verificar si el ID del tema está presente en la URL
if (isset($_GET['id_tema'])) {
    $id_tema = (int) $_GET['id_tema'];
} else {
    die('Tema no especificado.');
}

// Consulta SQL para obtener los detalles del tema
$sql_tema = "SELECT t.*, u.nombre_usuario FROM temas t 
             JOIN usuarios u ON t.id_usuario = u.id 
             WHERE t.id = $id_tema";
$resultado_tema = $conexion->query($sql_tema);

// Verificar si se encontró el tema
if ($resultado_tema && $resultado_tema->num_rows > 0) {
    $tema = $resultado_tema->fetch_assoc();
    echo "<h1>" . htmlspecialchars($tema['titulo']) . "</h1>";
    echo "<p>Publicado por: " . htmlspecialchars($tema['nombre_usuario']) . " el " . $tema['fecha_creacion'] . "</p>";
    echo "<div>" . nl2br(htmlspecialchars($tema['contenido'])) . "</div>";
} else {
    echo "El tema no existe o no se encontró. Verifica el ID del tema.";
    exit();
}

// Obtener los comentarios del tema
$sql_comentarios = "SELECT c.*, u.nombre_usuario FROM comentarios c 
                    JOIN usuarios u ON c.id_usuario = u.id 
                    WHERE c.id_tema = $id_tema ORDER BY c.fecha_creacion ASC";
$resultado_comentarios = $conexion->query($sql_comentarios);

// Mostrar los comentarios
if ($resultado_comentarios && $resultado_comentarios->num_rows > 0) {
    echo "<h3>Comentarios:</h3>";
    while ($comentario = $resultado_comentarios->fetch_assoc()) {
        echo "<p><strong>" . htmlspecialchars($comentario['nombre_usuario']) . ":</strong> " . htmlspecialchars($comentario['contenido']) . " (" . $comentario['fecha_creacion'] . ")</p>";
    }
} else {
    echo "<p>No hay comentarios aún.</p>";
}

// Formulario para agregar un comentario (solo si el usuario está logueado)
if (isset($_SESSION['usuario_id'])) {
?>
    <h3>Agregar un comentario:</h3>
    <form action="agregar_comentario.php" method="POST">
        <textarea name="contenido" required></textarea>
        <input type="hidden" name="id_tema" value="<?php echo $id_tema; ?>">
        <button type="submit">Enviar comentario</button>
    </form>
<?php
} else {
    echo "<p>Debes <a href='login.html'>iniciar sesión</a> para comentar.</p>";
}

$conexion->close();
?>
