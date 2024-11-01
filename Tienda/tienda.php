<?php
$conexion = new mysqli('localhost', 'usuario', 'contraseña', 'tienda');

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $precio = floatval($_POST['precio']); // Asegúrate de que el precio sea un número

    // Validar que el nombre no esté vacío y que el precio sea positivo
    if (!empty($nombre) && $precio > 0) {
        // Preparar la consulta
        $stmt = $conexion->prepare("INSERT INTO productos (nombre, precio) VALUES (?, ?)");
        $stmt->bind_param("sd", $nombre, $precio); // "s" para string, "d" para double

        if ($stmt->execute()) {
            echo "Producto agregado exitosamente.";
        } else {
            echo "Error al agregar el producto: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Nombre del producto no puede estar vacío y el precio debe ser mayor que 0.";
    }
}

$conexion->close();
?>
