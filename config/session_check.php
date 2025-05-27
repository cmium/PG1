<?php
session_start();

// Verificar si la sesión ha expirado (30 minutos de inactividad)
$session_timeout = 1800; // 30 minutos en segundos
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_timeout)) {
    session_unset();
    session_destroy();
    header('Location: /PG1/login.php');
    exit();
}

// Actualizar el tiempo de última actividad
$_SESSION['last_activity'] = time();

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header('Location: /PG1/login.php');
    exit();
}
?> 