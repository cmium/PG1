<?php
require_once 'config/session_check.php';
require_once 'config/database.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plataforma Educativa Preescolar AR</title>
    <!-- AR.js y Three.js -->
    <script src="https://aframe.io/releases/1.2.0/aframe.min.js"></script>
    <script src="https://raw.githack.com/AR-js-org/AR.js/master/aframe/build/aframe-ar.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
        }
        body {
            background: linear-gradient(135deg, #f8fffc 0%, #e0f7fa 100%);
            font-family: 'Comic Sans MS', 'Segoe UI', cursive, sans-serif;
        }
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 1rem 0;
        }
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: white !important;
        }
        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            transition: all 0.3s ease;
        }
        .nav-link:hover {
            color: white !important;
            transform: translateY(-2px);
        }
        .user-menu {
            position: relative;
        }
        .user-menu .dropdown-menu {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border: none;
        }
        .user-menu .dropdown-item {
            padding: 0.8rem 1.5rem;
            transition: all 0.3s ease;
        }
        .user-menu .dropdown-item:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }
        .user-menu .dropdown-item i {
            width: 20px;
            text-align: center;
            margin-right: 10px;
        }
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 4rem 0;
            margin-bottom: 3rem;
        }
        .level-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        .level-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        .level-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        .ar-container {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        footer {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 2rem 0;
            margin-top: 3rem;
        }
        .mascota-guia img {
            animation: bounce 2s infinite;
        }
        .mascota-guia h4 {
            font-family: 'Comic Sans MS', cursive, sans-serif;
            font-size: 1.2rem;
        }
        .recurso-preescolar {
            background: #fffbe7;
            border-radius: 25px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            padding: 2rem 1rem 1.5rem 1rem;
            margin-bottom: 1.5rem;
            transition: transform 0.3s cubic-bezier(.68,-0.55,.27,1.55), box-shadow 0.3s;
            border: 3px solid #ffe082;
            position: relative;
            min-height: 320px;
            animation: float 3s ease-in-out infinite;
        }
        .recurso-preescolar:hover {
            transform: scale(1.05) translateY(-8px);
            box-shadow: 0 16px 32px rgba(0,0,0,0.12);
            border-color: #ffd54f;
        }
        .recurso-preescolar .emoji {
            display: block;
            margin-bottom: 0.5rem;
        }
        .recurso-preescolar h3 {
            color: #4CAF50;
            font-size: 1.4rem;
            font-weight: bold;
        }
        .recurso-preescolar p {
            font-size: 1.1rem;
            color: #616161;
        }
        .recurso-preescolar .btn-lg {
            font-size: 1.1rem;
            border-radius: 20px;
            padding: 0.7rem 2rem;
            font-weight: bold;
        }
        .badge {
            font-size: 1rem;
            border-radius: 12px;
            padding: 0.4em 1em;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
        @media (max-width: 768px) {
            .recurso-preescolar {
                min-height: 260px;
                padding: 1.2rem 0.5rem 1rem 0.5rem;
            }
            .mascota-guia h4 {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-graduation-cap me-2"></i>
                Aprende Jugando con AR
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#niveles">Niveles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#ar">Experiencia AR</a>
                    </li>
                </ul>
                <div class="user-menu">
                    <button class="btn btn-link nav-link dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-1"></i>
                        <?php echo htmlspecialchars($_SESSION['username']); ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                        <li>
                            <a class="dropdown-item" href="profile.php">
                                <i class="fas fa-user"></i> Mi Perfil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="progress.php">
                                <i class="fas fa-chart-line"></i> Mi Progreso
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="logout.php">
                                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container text-center">
            <h1 class="display-4 mb-4">Aprende Jugando con Realidad Aumentada</h1>
            <p class="lead mb-4">Descubre un mundo mágico de aprendizaje interactivo para preescolares</p>
            <a href="#niveles" class="btn btn-light btn-lg">
                <i class="fas fa-play me-2"></i>Comenzar Aventura
            </a>
        </div>
    </section>

    <!-- Mascota guía -->
    <div class="mascota-guia text-center mb-4">
        <img src="https://cdn.pixabay.com/photo/2017/01/31/13/14/owl-2027368_1280.png" alt="Búho guía" style="width:90px; height:auto; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.15));">
        <h4 style="color:#ff9800; font-weight:bold; margin-top:0.5rem;">¡Hola! Soy Búhito, tu guía en el mundo mágico de la Realidad Aumentada 🦉✨</h4>
    </div>

    <!-- Main Content -->
    <main class="container">
        <!-- Repositorio de Recursos Preescolar RA/RV -->
        <section id="niveles" class="mb-5">
            <h2 class="text-center mb-4" style="color:#4CAF50; font-weight:bold;">Explora y Juega con Apps de Realidad Aumentada</h2>
            <div class="row g-4">
                <!-- AR Flashcards -->
                <div class="col-md-4">
                    <div class="level-card recurso-preescolar text-center">
                        <span class="emoji" style="font-size:2.5rem;">🦁</span>
                        <h3>AR Flashcards</h3>
                        <p class="text-muted">Descubre animales y letras que cobran vida con tu cámara.</p>
                        <span class="badge bg-primary mb-2">Tarjetas RA</span><br>
                        <a href="https://arflashcards.com/" target="_blank" class="btn btn-primary btn-lg">Probar</a>
                    </div>
                </div>
                <!-- Quiver -->
                <div class="col-md-4">
                    <div class="level-card recurso-preescolar text-center">
                        <span class="emoji" style="font-size:2.5rem;">🎨</span>
                        <h3>Quiver</h3>
                        <p class="text-muted">Colorea y mira cómo tus dibujos se transforman en 3D animado.</p>
                        <span class="badge bg-success mb-2">Dibujo RA</span><br>
                        <a href="https://quivervision.com/" target="_blank" class="btn btn-success btn-lg">Probar</a>
                    </div>
                </div>
                <!-- Chromville -->
                <div class="col-md-4">
                    <div class="level-card recurso-preescolar text-center">
                        <span class="emoji" style="font-size:2.5rem;">📚</span>
                        <h3>Chromville</h3>
                        <p class="text-muted">Cuentos y actividades interactivas para aprender jugando.</p>
                        <span class="badge bg-warning mb-2">Cuentos RA</span><br>
                        <a href="https://chromville.com/" target="_blank" class="btn btn-warning btn-lg">Probar</a>
                    </div>
                </div>
                <!-- Animal 4D+ -->
                <div class="col-md-4">
                    <div class="level-card recurso-preescolar text-center">
                        <span class="emoji" style="font-size:2.5rem;">🐼</span>
                        <h3>Animal 4D+</h3>
                        <p class="text-muted">Conoce animales en 3D y aprende datos curiosos de cada uno.</p>
                        <span class="badge bg-info mb-2">Animales RA</span><br>
                        <a href="https://www.octagon.studio/animal-4d/" target="_blank" class="btn btn-info btn-lg">Probar</a>
                    </div>
                </div>
                <!-- ZooKazam -->
                <div class="col-md-4">
                    <div class="level-card recurso-preescolar text-center">
                        <span class="emoji" style="font-size:2.5rem;">🦋</span>
                        <h3>ZooKazam</h3>
                        <p class="text-muted">Explora la naturaleza y los animales en realidad aumentada.</p>
                        <span class="badge bg-primary mb-2">Naturaleza RA</span><br>
                        <a href="https://zookazam.com/" target="_blank" class="btn btn-primary btn-lg">Probar</a>
                    </div>
                </div>
                <!-- Catchy Words AR -->
                <div class="col-md-4">
                    <div class="level-card recurso-preescolar text-center">
                        <span class="emoji" style="font-size:2.5rem;">🔤</span>
                        <h3>Catchy Words AR</h3>
                        <p class="text-muted">Atrapa letras y forma palabras jugando en tu salón o casa.</p>
                        <span class="badge bg-success mb-2">Palabras RA</span><br>
                        <a href="https://catchywordsar.com/" target="_blank" class="btn btn-success btn-lg">Probar</a>
                    </div>
                </div>
                <!-- JigSpace -->
                <div class="col-md-4">
                    <div class="level-card recurso-preescolar text-center">
                        <span class="emoji" style="font-size:2.5rem;">🧩</span>
                        <h3>JigSpace</h3>
                        <p class="text-muted">Explora modelos 3D interactivos y aprende conceptos básicos.</p>
                        <span class="badge bg-info mb-2">Exploración 3D</span><br>
                        <a href="https://jig.space/" target="_blank" class="btn btn-info btn-lg">Probar</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- AR View -->
        <section id="ar" class="mb-5">
            <h2 class="text-center mb-4">Experiencia AR</h2>
            <div class="ar-container">
                <a-scene embedded arjs="sourceType: webcam; debugUIEnabled: false;">
                    <a-marker preset="hiro">
                        <a-box position="0 0.5 0" material="color: yellow;"></a-box>
                    </a-marker>
                    <a-entity camera></a-entity>
                </a-scene>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Plataforma Educativa Preescolar AR</h5>
                    <p class="mb-0">Aprende jugando con realidad aumentada</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">© 2025_CN Todos los derechos reservados</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 