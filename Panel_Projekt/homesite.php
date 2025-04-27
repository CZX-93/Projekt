<?php
// Session starten (nur einmal, falls noch nicht gestartet)
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Überprüfen, ob der Admin eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    // Wenn der Admin nicht eingeloggt ist, zurück zur Login-Seite leiten
    header("Location: login.php");
    exit();
}

require_once 'db_connect.php';

// Benutzer-ID aus der Session holen
$user_id = $_SESSION['user_id'];

// Benutzerdaten abrufen
$sql = "SELECT username, avatar FROM users WHERE id = ?";
$stmt = $mysqli->prepare($sql);
if (!$stmt) {
    die("SQL-Fehler: " . $mysqli->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/admin_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="sidebar-grip" onclick="toggleSidebar()" id="sidebarGrip">
    <span>&#x276F;</span> <!-- Unicode: ❯ -->
    </div>

    <!-- Sidebar Section -->
    <aside class="sidebar">
        <div class="logo">Admin Tools</div>
        <nav>
            <ul>
                <li><a href="dashboard.php" target="content-frame">Dashboard</a></li>
                <li><a href="user_management.php" target="content-frame">Benutzerverwaltung</a></li>
                <li><a href="project_creator_form.php" target="content-frame">Projekt erstellen</a></li>
                <li><a href="projektauswahl.php" target="content-frame">Projektauswahl und Bearbeitung</a></li>
                <li><a href="support.php" target="content-frame">Support</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content Section -->
    <main class="main-content">
        <header class="main-header">
        <div class="burger-overlay" id="burgerOverlay" onclick="closeBurgerMenu()"></div>

            <div class="welcome-message">
                <h2>Willkommen</h2>
            </div>
            <div class="burger-toggle" onclick="toggleHeaderMenu()">☰</div>
            <div class="admin-nav-horizontal">
                    <a href="profil.php" target="content-frame" class="user-info">
                    <img src="<?php echo htmlspecialchars($user['avatar'] ?? 'uploads/avatars/default.png'); ?>" alt="Profilbild">
                    <span><?php echo htmlspecialchars($user['username']); ?></span>
                    </a>

                    <a href="profil.php" target="content-frame">
                    <i class="fas fa-user"></i><span>Profil</span>
                    </a>
                    <a href="meine_projekte.php" target="content-frame">
                    <i class="fas fa-folder-open"></i><span>Meine Projekte</span>
                    </a>
                    <a href="messages_frontend.php" target="content-frame">
                    <i class="fas fa-envelope"></i><span>Nachrichten</span>
                    <span class="badge" id="msgBadge">0</span>
                    </a>

                    <a href="logout.php">
                    <i class="fas fa-sign-out-alt"></i><span>Logout</span>
                    </a>
                </div>
        </header>

        <!-- Content Area (Iframe für das Dashboard) -->
        <iframe name="content-frame" class="content-frame" src="dashboard.php"></iframe>
    </main>

    <script src="js/homesite.js"></script>
</body>
</html>