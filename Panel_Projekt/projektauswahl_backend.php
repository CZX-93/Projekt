<?php
/* Fehleranzeigen aktivieren (nur zum Debuggen – später entfernen)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */

// Session starten (nur einmal, falls noch nicht gestartet)
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once 'db_connect.php'; // Zentrale DB-Verbindung einbinden

// Überprüfen, ob die Verbindung zur Datenbank erfolgreich war
if (!$mysqli) {
    die("Datenbankverbindung fehlgeschlagen.");
}

// Wenn der Benutzer eine Änderung absendet (Status + Debug aktualisieren)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    // Alle Projekte auf "inaktiv" setzen
    $query = "UPDATE projekt SET is_active = 0";
    if (!$mysqli->query($query)) {
        echo json_encode([
            "status" => "error", 
            "message" => "Fehler beim Zurücksetzen des Status: " . $mysqli->error
        ]);
        exit;
    }

    // Das Projekt, das aktiv gesetzt werden soll
    if (isset($_POST['project_id'])) {
        $project_id = intval($_POST['project_id']); // Sicherheitsmaßnahme: Project ID als Integer

        // Aktivieren des ausgewählten Projekts
        $query = "UPDATE projekt SET is_active = 1 WHERE id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("i", $project_id);

        if (!$stmt->execute()) {
            echo json_encode([
                "status" => "error", 
                "message" => "Fehler beim Aktivsetzen des Projekts."
            ]);
            $stmt->close();
            exit;
        }
        $stmt->close();
    }

    // Debug-Modus für das gewählte Projekt aktualisieren
    if (isset($_POST['debug'][$project_id])) {
        $debug = intval($_POST['debug'][$project_id]); // Boolean-Wert (0 oder 1)

        $query = "UPDATE projekt SET debug = ? WHERE id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("ii", $debug, $project_id);

        if (!$stmt->execute()) {
            echo json_encode([
                "status" => "error", 
                "message" => "Fehler beim Aktualisieren des Debug-Modus."
            ]);
            $stmt->close();
            exit;
        }
        $stmt->close();
    }

    echo json_encode([
        "status" => "success", 
        "message" => "Einstellungen erfolgreich gespeichert."
    ]);
    exit;
}

// Wenn kein POST-Update erfolgt, Projekte abrufen:
$query = "SELECT id, name, is_active, debug FROM projekt";
$result = $mysqli->query($query);
$projects = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
} else {
    echo "Fehler bei der Abfrage: " . $mysqli->error;
}

if ($_POST['action'] === 'add_question') {
    $projectId = (int) $_POST['project_id'];
    $text = trim($_POST['text'] ?? '');
    $type = trim($_POST['type'] ?? '');

    if (!$projectId || !$text || !$type) {
        echo json_encode(['success' => false, 'error' => 'Fehlende Daten']);
        exit;
    }

    $stmt = $mysqli->prepare("INSERT INTO fragen (frage, typ, projekt_id, erstellt_von) VALUES (?, ?, ?, 'System')");
    $stmt->bind_param("sii", $text, $type, $projectId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $mysqli->error]);
    }
    exit;
}

?>


