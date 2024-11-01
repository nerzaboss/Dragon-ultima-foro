<?php
// create_topic.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Leer los datos enviados por el frontend
    $data = json_decode(file_get_contents("php://input"), true);
    $title = $data['title'];
    $content = $data['content'];

    // Conectar a la base de datos (cambia estos valores según tu configuración)
    $conn = new mysqli('localhost', 'usuario', 'contraseña', 'dragon_ultima');

    if ($conn->connect_error) {
        die('Conexión fallida: ' . $conn->connect_error);
    }

    // Insertar el nuevo tema en la base de datos
    $stmt = $conn->prepare("INSERT INTO temas (titulo, contenido) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $content);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
