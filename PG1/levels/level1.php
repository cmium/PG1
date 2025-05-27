<?php
session_start();
require_once '../config/database.php';

// Verificar si el usuario está logueado (implementar según necesidad)
// if (!isset($_SESSION['user_id'])) {
//     header('Location: ../login.php');
//     exit();
// }

$level_id = 1;
$level_name = "Aprendiendo los Números";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $level_name; ?> - Plataforma Educativa AR</title>
    <!-- AR.js y Three.js -->
    <script src="https://aframe.io/releases/1.2.0/aframe.min.js"></script>
    <script src="https://raw.githack.com/AR-js-org/AR.js/master/aframe/build/aframe-ar.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <!-- Header -->
        <header class="bg-primary text-white p-3">
            <h1 class="text-center"><?php echo $level_name; ?></h1>
        </header>

        <!-- Main Content -->
        <main class="container mt-4">
            <!-- Instrucciones -->
            <section class="instructions mb-4">
                <div class="card">
                    <div class="card-body">
                        <h3>Instrucciones</h3>
                        <p>1. Imprime el marcador AR que aparece a continuación</p>
                        <p>2. Coloca el marcador en una superficie plana</p>
                        <p>3. Apunta la cámara hacia el marcador</p>
                        <p>4. ¡Interactúa con los números que aparecerán!</p>
                    </div>
                </div>
            </section>

            <!-- AR View -->
            <section class="ar-section">
                <div class="ar-container">
                    <a-scene embedded arjs="sourceType: webcam; debugUIEnabled: false;">
                        <!-- Marcador para el número 1 -->
                        <a-marker preset="hiro" id="marker1">
                            <a-text value="1" position="0 0.5 0" align="center" color="#FF0000" scale="2 2 2"></a-text>
                            <a-box position="0 0.5 0" material="color: yellow; opacity: 0.5"></a-box>
                        </a-marker>
                        
                        <!-- Marcador para el número 2 -->
                        <a-marker preset="kanji" id="marker2">
                            <a-text value="2" position="0 0.5 0" align="center" color="#00FF00" scale="2 2 2"></a-text>
                            <a-sphere position="0 0.5 0" radius="0.5" material="color: blue; opacity: 0.5"></a-sphere>
                        </a-marker>
                        
                        <a-entity camera></a-entity>
                    </a-scene>
                </div>
            </section>

            <!-- Actividades Interactivas -->
            <section class="activities mt-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4>Actividad 1: Contar Objetos</h4>
                                <p>Encuentra y cuenta los objetos que aparecen en la realidad aumentada.</p>
                                <button class="btn btn-primary" onclick="startActivity(1)">Comenzar</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4>Actividad 2: Ordenar Números</h4>
                                <p>Ordena los números que aparecen en la realidad aumentada.</p>
                                <button class="btn btn-primary" onclick="startActivity(2)">Comenzar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="bg-dark text-white p-3 mt-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <a href="../index.php" class="nav-button">Volver al Inicio</a>
                    </div>
                    <div class="col-md-6 text-end">
                        <button class="nav-button" onclick="saveProgress()">Guardar Progreso</button>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="../assets/js/main.js"></script>
    <script>
        // Funciones específicas para el nivel 1
        function startActivity(activityId) {
            console.log('Iniciando actividad:', activityId);
            // Implementar lógica específica para cada actividad
        }

        function saveProgress() {
            // Implementar lógica para guardar el progreso
            console.log('Guardando progreso...');
            showProgressMessage('Progreso guardado correctamente', 'success');
        }

        // Eventos específicos para los marcadores
        document.querySelector('a-scene').addEventListener('markerFound', function(e) {
            const markerId = e.target.id;
            console.log('Marcador encontrado:', markerId);
            // Implementar lógica específica para cada marcador
        });
    </script>
</body>
</html> 