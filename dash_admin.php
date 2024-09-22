<?php
session_start(); // Iniciar la sesión

if (!isset($_SESSION['usuario']) || $_SESSION['cargo'] !== 'admin') {
    header("Location: index.php"); // Redirigir al login si no hay sesión activa o no es admin
    exit();
}

include 'conexion.php'; // Incluir el archivo de conexión

// Consulta para obtener las notificaciones
$sql = "SELECT * FROM notificaciones ORDER BY fecha DESC"; 
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .notification-bell {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }
        .notification-bell:hover .dropdown {
            display: block;
        }
        .dropdown {
            display: none;
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1;
            max-height: 300px;
            overflow-y: auto;
        }
        .notification {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .notification:last-child {
            border-bottom: none;
        }
        .notification:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <h1>Bienvenido Admin, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</h1>
    <p>Gestiona los empleados y notificaciones aquí.</p>
    <a href="logout.php">Cerrar sesión</a>

    <div class="notification-bell">
        🛎️ Notificaciones
        <div class="dropdown">
            <h2>Notificaciones</h2>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="notification">
                        <strong><?php echo htmlspecialchars($row['nombre_empleado']); ?></strong><br>
                        <?php echo htmlspecialchars($row['texto']); ?><br>
                        <small><?php echo htmlspecialchars($row['fecha']); ?></small>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="notification">No hay notificaciones.</div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
