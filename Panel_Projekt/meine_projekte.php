<?php
session_start();
require_once 'db_connect.php'; // Datenbankverbindung

// Benutzer-ID aus der Session sicherstellen
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == 0) {
    header("Location: ../login.php"); // Umleitung zur Login-Seite
    exit;
}
$user_id = $_SESSION['user_id'];

// Projekte des Benutzers abrufen
$sql = "SELECT id, name, is_active FROM projekt WHERE erstellt_von = ?";
$stmt = $mysqli->prepare($sql);
if (!$stmt) {
    die("SQL-Fehler: " . $mysqli->error);
}
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$projects = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Neues Projekt hinzufügen
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_project'])) {
    $project_title = trim($_POST['project_title']);
    $sql = "INSERT INTO projekt (name, erstellt_von, is_active) VALUES (?, ?, 1)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $project_title, $user_id);
    $stmt->execute();
    $stmt->close();
    header("Location: meine_projekte.php?added=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meine Projekte</title>
    <link rel="stylesheet" href="../styles/projects_style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .projects-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="projects-container">
        <h2>Meine Projekte</h2>
        <form method="POST">
            <label>Neues Projekt erstellen:</label>
            <input type="text" name="project_title" required>
            <button type="submit" name="new_project">Projekt hinzufügen</button>
        </form>

        <h3>Bestehende Projekte</h3>
        <table>
            <tr>
                <th>Titel</th>
                <th>Status</th>
            </tr>
            <?php foreach ($projects as $project): ?>
            <tr>
                <td><?php echo htmlspecialchars($project['name']); ?></td>
                <td><?php echo $project['is_active'] ? 'Aktiv' : 'Inaktiv'; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
