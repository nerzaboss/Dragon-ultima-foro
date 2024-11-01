<?php
$conexion = new mysqli('localhost', 'usuario', 'contraseña', 'tienda');

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];

    $query = "INSERT INTO productos (nombre, precio) VALUES ('$nombre', $precio)";
    
    if ($conexion->query($query) === TRUE) {
        echo "Producto agregado exitosamente.";
    } else {
        echo "Error al agregar el producto: " . $conexion->error;
    }
}

$conexion->close();
?>
