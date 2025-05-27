<?php
session_start();
require_once '../config/database.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Obtener estadísticas
$stats = [
    'levels' => mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM levels"))['count'],
    'users' => mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM users"))['count'],
    'completed' => mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM user_progress WHERE completed = 1"))['count']
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Plataforma Educativa Preescolar AR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 250px;
        }
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            width: var(--sidebar-width);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem;
            transition: all 0.3s ease;
        }
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
        }
        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.8rem 1rem;
            border-radius: 10px;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
        }
        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }
        .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        .stat-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #764ba2;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="d-flex align-items-center mb-4">
            <i class="fas fa-user-shield fa-2x me-2"></i>
            <h4 class="mb-0">Admin Panel</h4>
        </div>
        <nav class="nav flex-column">
            <a class="nav-link active" href="dashboard.php">
                <i class="fas fa-home me-2"></i> Dashboard
            </a>
            <a class="nav-link" href="levels.php">
                <i class="fas fa-layer-group me-2"></i> Niveles
            </a>
            <a class="nav-link" href="users.php">
                <i class="fas fa-users me-2"></i> Usuarios
            </a>
            <a class="nav-link" href="content.php">
                <i class="fas fa-cube me-2"></i> Contenido AR
            </a>
            <a class="nav-link" href="settings.php">
                <i class="fas fa-cog me-2"></i> Configuración
            </a>
            <a class="nav-link text-danger" href="logout.php">
                <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Dashboard</h2>
            <div class="user-info">
                <span class="me-2">Bienvenido, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['admin_username']); ?>" 
                     class="rounded-circle" width="40" height="40" alt="Admin">
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <i class="fas fa-layer-group stat-icon"></i>
                    <h3><?php echo $stats['levels']; ?></h3>
                    <p class="text-muted mb-0">Niveles Totales</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <i class="fas fa-users stat-icon"></i>
                    <h3><?php echo $stats['users']; ?></h3>
                    <p class="text-muted mb-0">Usuarios Registrados</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <i class="fas fa-check-circle stat-icon"></i>
                    <h3><?php echo $stats['completed']; ?></h3>
                    <p class="text-muted mb-0">Niveles Completados</p>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">Actividad Reciente</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Actividad</th>
                                <th>Nivel</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT u.username, p.activity, l.name as level_name, p.created_at 
                                   FROM user_progress p 
                                   JOIN users u ON p.user_id = u.id 
                                   JOIN levels l ON p.level_id = l.id 
                                   ORDER BY p.created_at DESC LIMIT 5";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['activity']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['level_name']) . "</td>";
                                echo "<td>" . date('d/m/Y H:i', strtotime($row['created_at'])) . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 