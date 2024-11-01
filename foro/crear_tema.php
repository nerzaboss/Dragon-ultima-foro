<?php
session_start(); // Inicia la sesión para obtener los datos del usuario logueado

// Verifica si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    // Si no está logueado, redirige al login
    header('Location: login.html');
    exit();
}

// Conectar a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'foro');

// Verifica si la conexión fue exitosa
if ($conexion->connect_error) {
    die('Error en la conexión: ' . $conexion->connect_error);
}

// Obtener los datos enviados desde el formulario
$titulo = $conexion->real_escape_string($_POST['titulo']);
$contenido = $conexion->real_escape_string($_POST['contenido']);
$usuario_id = $_SESSION['usuario_id']; // Suponiendo que el ID del usuario está almacenado en la sesión

// Manejo de la imagen
$imagen = null; // Inicializa la variable de imagen

if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
    $nombre_imagen = $_FILES['imagen']['name'];
    $ruta_imagen = 'uploads/' . basename($nombre_imagen); // Ruta donde se guardará la imagen

    // Mueve el archivo subido a la carpeta de destino
    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_imagen)) {
        $imagen = $conexion->real_escape_string($ruta_imagen); // Escapa la ruta de la imagen
    } else {
        echo "Error al subir la imagen.";
    }
}

$sql = "INSERT INTO temas_nueva (titulo, contenido, id_usuario, fecha_creacion) 
        VALUES ('$titulo', '$contenido', '$usuario_id', NOW())";


if ($conexion->query($sql) === TRUE) {
    header('Location: foro.php');
    exit();
} else {
    // Si hubo un error, muestra el mensaje
    echo "Error al crear el tema: " . $conexion->error;
}

// Cierra la conexión
$conexion->close();
?>

