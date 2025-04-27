<?php 
// Session starten (nur einmal, falls noch nicht gestartet)
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Datenbankverbindung einbinden
require_once 'db_connect.php';

// Überprüfen, ob der Admin eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$username = htmlspecialchars($_SESSION['username']); // Schutz vor XSS

// Überprüfen, ob die Verbindung existiert
if (!$mysqli) {
    die("Datenbankverbindung nicht vorhanden.");
}

// Anzahl der aktiven Benutzer abrufen
$query = $mysqli->query("SELECT COUNT(*) AS total_users FROM users");
$total_users = $query->fetch_assoc()['total_users'];

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/dashboard.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="container content">
        <h1>Willkommen im Admin Dashboard, <?php echo $username; ?>!</h1>
        <p>Hier finden Sie eine Übersicht über wichtige Kennzahlen und Optionen.</p>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Aktive Benutzer</div>
                    <div class="card-body">
                        <h5 class="card-title">Aktuelle Benutzeranzahl</h5>
                        <p class="card-text"><span class="highlight"><?php echo $total_users; ?></span></p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Erfolgreiche Projekte</div>
                    <div class="card-body">
                        <h5 class="card-title">Abgeschlossene Projekte</h5>
                        <p class="card-text"><span class="highlight">45</span></p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Anstehende Deadlines</div>
                    <div class="card-body">
                        <h5 class="card-title">Nächste Deadline</h5>
                        <p class="card-text"><span class="highlight">3 Tage</span></p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header">Systemfehler</div>
                    <div class="card-body">
                        <h5 class="card-title">Kritische Meldungen</h5>
                        <p class="card-text"><span class="highlight">2</span></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-sections row">
            <div class="col-md-4">
                <section class="card flip-card">
                    <div class="flip-card-inner">
                        <div class="flip-card-front">
                            <h3>Benutzerstatistik</h3>
                            <p>Anzahl registrierter Benutzer: <span class="highlight"><?php echo $total_users; ?></span></p>
                        </div>
                        <div class="flip-card-back">
                            <div class="chart-placeholder">Statistik-Diagramm</div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-4">
                <section class="card flip-card">
                    <div class="flip-card-inner">
                        <div class="flip-card-front">
                            <h3>Projektstatus</h3>
                            <p>Offene Projekte: <span class="highlight">5</span></p>
                        </div>
                        <div class="flip-card-back">
                            <div class="chart-placeholder">Projektübersicht</div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-4">
                <section class="card flip-card">
                    <div class="flip-card-inner">
                        <div class="flip-card-front">
                            <h3>Systemmeldungen</h3>
                            <p>Letzte Meldungen werden hier angezeigt.</p>
                        </div>
                        <div class="flip-card-back">
                            <div class="chart-placeholder">Meldungs-Widget</div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div class="dashboard-stats row">
            <div class="col-md-4">
                <section class="stat-card">
                    <h3>Umsatzentwicklung</h3>
                    <div class="chart-placeholder">Umsatzgraph</div>
                </section>
            </div>
            <div class="col-md-4">
                <section class="stat-card">
                    <h3>Benutzerwachstum</h3>
                    <div class="chart-placeholder">Benutzerwachstumsgraph</div>
                </section>
            </div>
            <div class="col-md-4">
                <section class="stat-card">
                    <h3>Aktivitätsübersicht</h3>
                    <div class="chart-placeholder">Aktivitätsgraph</div>
                </section>
            </div>
        </div>
    </div>

    <!-- jQuery lokal einbinden -->
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
