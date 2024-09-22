<?php
session_start(); // Iniciar la sesión
include 'conexion.php'; // Incluir el archivo de conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Consultar la base de datos
    $sql = "SELECT * FROM empleados WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();

    // Verificar las credenciales
    if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
        // Almacenar información del usuario en la sesión
        $_SESSION['usuario'] = $usuario['nombre'];
        $_SESSION['cargo'] = $usuario['cargo'];

        // Redirigir según el cargo
        if ($usuario['cargo'] === 'admin') {
            header("Location: dash_admin.php"); // Redirigir al dashboard del admin
        } else {
            header("Location: dash_empleado.php"); // Redirigir al dashboard del empleado
        }
        exit();
    } else {
        echo "Credenciales incorrectas";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    <form action="" method="POST">
        <input type="email" name="correo" placeholder="Correo" required>
        <input type="password" name="contrasena" placeholder="Contraseña" required>
        <button type="submit">Iniciar Sesión</button>
    </form>
    <a href="registro.php">
        <button>Registrar un Nuevo Usuario</button>
    </a>
    <br><br>
    <a href="#recuperar" id="recuperar-link">Olvidé mi contraseña</a>

    <div id="recuperar" style="display: none;">
        <h2>Recuperar Contraseña</h2>
        <form action="enviar_noti.php" method="POST">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="email" name="correo" placeholder="Correo" required>
            <textarea name="comentario" placeholder="Comentario" required></textarea>
            <button type="submit">Enviar Solicitud</button>
        </form>
    </div>

    <script>
        document.getElementById('recuperar-link').onclick = function() {
            document.getElementById('recuperar').style.display = 'block';
        }
    </script>
</body>
</html>
