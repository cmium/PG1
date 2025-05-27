<?php
$host = 'localhost';
$dbname = 'educa_ar';
$username = 'root';
$password = '';

try {
    // Primero conectamos sin seleccionar la base de datos
    $conn = mysqli_connect($host, $username, $password);
    
    if (!$conn) {
        throw new Exception("Error de conexión: " . mysqli_connect_error());
    }
    
    // Crear la base de datos si no existe
    $sql = "CREATE DATABASE IF NOT EXISTS " . $dbname;
    if(!mysqli_query($conn, $sql)) {
        throw new Exception("ERROR: No se pudo crear la base de datos. " . mysqli_error($conn));
    }
    
    // Seleccionar la base de datos
    if(!mysqli_select_db($conn, $dbname)) {
        throw new Exception("ERROR: No se pudo seleccionar la base de datos. " . mysqli_error($conn));
    }
    
    mysqli_set_charset($conn, "utf8");
    
    // Crear tablas necesarias
    $tables = [
        "CREATE TABLE IF NOT EXISTS users (
            id INT PRIMARY KEY AUTO_INCREMENT,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )",
        
        "CREATE TABLE IF NOT EXISTS levels (
            id INT PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(100) NOT NULL,
            description TEXT,
            difficulty INT NOT NULL,
            ar_content TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )",
        
        "CREATE TABLE IF NOT EXISTS progress (
            id INT PRIMARY KEY AUTO_INCREMENT,
            user_id INT,
            level_id INT,
            completed BOOLEAN DEFAULT FALSE,
            score INT DEFAULT 0,
            last_attempt DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id),
            FOREIGN KEY (level_id) REFERENCES levels(id)
        )",
        
        "CREATE TABLE IF NOT EXISTS admins (
            id INT PRIMARY KEY AUTO_INCREMENT,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )"
    ];

    foreach($tables as $sql) {
        if(!mysqli_query($conn, $sql)) {
            throw new Exception("ERROR: No se pudo crear la tabla. " . mysqli_error($conn));
        }
    }
    
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?> 