<?php
include 'conexion.php'; // Incluir el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $comentario = $_POST['comentario'];

    // Aquí puedes definir la lógica para enviar la notificación al admin
    // Puedes usar un INSERT en la base de datos para registrar la notificación

    $sql = "INSERT INTO notificaciones (correo_admin, texto, nombre_empleado) VALUES (?, ?, ?)";
    $admin_correo = "jose@gmail.com"; // Cambia esto por el correo del admin
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $admin_correo, $comentario, $nombre);

    if ($stmt->execute()) {
        echo "Solicitud enviada correctamente.";
    } else {
        echo "Error al enviar la solicitud: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
