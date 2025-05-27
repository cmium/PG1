<?php
session_start();

// Clear all session variables
$_SESSION = array();

// Destroy the session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-3600, '/');
}

// Destroy the session
session_destroy();

// Set success message in session
session_start();
$_SESSION['success'] = "Has cerrado sesión exitosamente.";

// Redirect to login page
header('Location: login.php');
exit(); 