<?php
session_start(); // Iniciar la sesión

if (!isset($_SESSION['usuario']) || $_SESSION['cargo'] !== 'empleado') {
    header("Location: index.php"); // Redirigir al login si no hay sesión activa o no es empleado
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Empleado</title>
</head>
<body>
    <h1>Bienvenido Empleado, <?php echo $_SESSION['usuario']; ?>!</h1>
    <p>Aquí puedes ver tus tareas y notificaciones.</p>
    <a href="logout.php">Cerrar sesión</a>
</body>
</html>
