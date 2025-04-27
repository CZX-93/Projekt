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
</head>
<body>
    <!-- Sidebar Section -->
    <aside class="sidebar">
        <div class="logo">Admin Tools</div>
        <nav>
            <ul>
                <li><a href="dashboard.php" target="content-frame">Dashboard</a></li>
                <li><a href="user_management.php" target="content-frame">Benutzerverwaltung</a></li>
                <li><a href="project_creator_form.php" target="content-frame">Projekt erstellen</a></li>
                <li><a href="projektauswahl.php" target="content-frame">Projektauswahl und Bearbeitung</a></li>
                <li><a href="xml.php" target="content-frame">XML Editor</a></li>
                <li><a href="support.php" target="content-frame">Support</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content Section -->
    <main class="main-content">
        <header class="main-header">
            <div class="header-container">
                <div class="header-actions">
                    <div class="user-info">
                        <img src="<?php echo htmlspecialchars($user['avatar'] ?? 'uploads/avatars/default.png'); ?>" alt="Profilbild" width="40" height="40" style="border-radius: 50%; margin-right: 10px;">
                        <span><?php echo htmlspecialchars($user['username']); ?></span>
                    </div>
                    <div class="burger-menu">
                        <span class="menu-icon" onclick="toggleMenu()">&#9776;</span>
                        <div class="dropdown-menu">
                            <li><a href="profil.php" target="content-frame">Profil</a></li>
                            <li><a href="meine_projekte.php" target="content-frame">Meine Projekte</a></li>
                            <li><a href="messages_frontend.php" target="content-frame">Nachrichten</a></li>
                            <li><a href="logout.php">Logout</a></li>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area (Iframe für das Dashboard) -->
        <iframe name="content-frame" class="content-frame" src="dashboard.php"></iframe>
    </main>

    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('active');
        }

        function toggleMenu() {
            document.querySelector('.dropdown-menu').classList.toggle('show');
        }
    </script>
</body>
</html>