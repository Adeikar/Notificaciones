<?php
include 'conexion.php'; // Incluir el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $cargo = $_POST['cargo']; // Puede ser 'admin' o 'empleado'

    // Hashear la contraseña
    $hashedPassword = password_hash($contrasena, PASSWORD_DEFAULT);

    // Insertar en la base de datos
    $sql = "INSERT INTO empleados (nombre, correo, contrasena, cargo) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $correo, $hashedPassword, $cargo);

    if ($stmt->execute()) {
        // Redirigir al inicio de sesión después de un registro exitoso
        header("Location: index.php");
        exit(); // Asegurarse de que no se ejecute más código
    } else {
        echo "Error al registrar usuario: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
</head>
<body>
    <h1>Registro de Usuario</h1>
    <form action="" method="POST">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="email" name="correo" placeholder="Correo" required>
        <input type="password" name="contrasena" placeholder="Contraseña" required>
        <select name="cargo" required>
            <option value="empleado">Empleado</option>
            <option value="admin">Administrador</option>
        </select>
        <button type="submit">Registrar</button>
    </form>
</body>
</html>
