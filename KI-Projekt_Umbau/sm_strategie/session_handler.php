<?php
session_start();

/**
 * Aktualisiert die Session-Daten als JSON und speichert Änderungen mit Verlauf.
 *
 * @param string $key Der Schlüssel für die zu speichernden Daten.
 * @param mixed $value Der Wert, der gespeichert oder aktualisiert wird.
 */
function updateSessionData($key, $value) {
    if (!isset($_SESSION['json_data'])) {
        $_SESSION['json_data'] = [];
    }

    // Aktuellen Zeitstempel für Verlauf speichern
    $currentTime = date('Y-m-d H:i:s');
    $_SESSION['json_data']['history'][] = [
        'time' => $currentTime,
        'key' => $key,
        'old_value' => $_SESSION['json_data'][$key] ?? null,
        'new_value' => $value
    ];

    // Daten aktualisieren
    $_SESSION['json_data'][$key] = $value;

    // JSON-String generieren und in der Session speichern
    $_SESSION['json_string'] = json_encode($_SESSION['json_data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}

/**
 * Gibt die Session-Daten als JSON aus (z. B. für Debugging oder API-Antworten).
 */
function getSessionAsJson() {
    header('Content-Type: application/json');
    echo isset($_SESSION['json_string']) ? $_SESSION['json_string'] : json_encode(["message" => "Keine Daten vorhanden."]);
}

/**
 * Aktualisiert die Session-Daten basierend auf JSON-Input (z. B. von einer API oder JavaScript).
 *
 * @param string $jsonData JSON-Daten als String.
 */
function updateSessionFromJson($jsonData) {
    $data = json_decode($jsonData, true);
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            updateSessionData($key, $value);
        }
    }
}

// Falls JSON-Daten über POST gesendet wurden, diese verarbeiten
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answers'])) {
    updateSessionFromJson($_POST['answers']);
}

// Falls `debug` als GET-Parameter gesetzt ist, JSON-Daten ausgeben
if (isset($_GET['debug'])) {
    getSessionAsJson();
}
?>
