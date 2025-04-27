<?php
// Verbindung zur Datenbank herstellen (wenn nicht schon vorhanden)
if (!isset($mysqli)) {
    $mysqli = new mysqli("HOST", "USER", "PASSWORT", "DATENBANK");
    if ($mysqli->connect_error) {
        die("Datenbankverbindung fehlgeschlagen: " . $mysqli->connect_error);
    }
}

// Prüfen, ob ein aktives Projekt existiert
if (!isset($_SESSION['active_project_id'])) {
    die("Kein aktives Projekt in der Session gespeichert.");
}

$activeProjectId = $_SESSION['active_project_id'];

// API-Key & Assistant-Key ID aus `projekt` abrufen
$sql = "SELECT `key`, `assistant_key_id` FROM projekt WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $activeProjectId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $apiKeyId = $row['key'];
    $assistantKeyId = $row['assistant_key_id'];
} else {
    die("Fehler: API-Key oder Assistant-Key nicht gefunden.");
}

// API-Key abrufen
$sql = "SELECT keytext FROM api_key WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $apiKeyId);
$stmt->execute();
$result = $stmt->get_result();
$apiKey = $result->fetch_assoc()['keytext'] ?? die("Fehler: API-Key nicht gefunden.");

// Assistant-Key abrufen
$sql = "SELECT keytext FROM assistant_key WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $assistantKeyId);
$stmt->execute();
$result = $stmt->get_result();
$assistantKey = $result->fetch_assoc()['keytext'] ?? die("Fehler: Assistant-Key nicht gefunden.");
?>
