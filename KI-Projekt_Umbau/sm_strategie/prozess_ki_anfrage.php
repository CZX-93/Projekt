<?php
header('Content-Type: application/json');

// Debugging aktivieren
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Datenbankverbindung herstellen
require_once 'db_connect.php';
$mysqli = db_connect(); // Verwenden der richtigen Verbindungsfunktion

// Prüfen, ob die Verbindung existiert
if (!$mysqli) {
    echo json_encode(["error" => "Datenbankverbindung konnte nicht hergestellt werden."]);
    exit;
}

// 1️⃣ Aktives Projekt abrufen
$query = "SELECT id, `key`, assistant_key_id FROM projekt WHERE is_active = 1 LIMIT 1";
$result = $mysqli->query($query);

if (!$result) {
    echo json_encode(["error" => "Fehler bei der Projektabfrage: " . $mysqli->error]);
    exit;
}

if ($result->num_rows === 0) {
    echo json_encode(["error" => "Kein aktives Projekt gefunden."]);
    exit;
}

$row = $result->fetch_assoc();
$projectId = $row['id'];
$keyId = $row['key'];
$assistantKeyId = $row['assistant_key_id'];

// 2️⃣ API-Key aus der Datenbank abrufen (Tabelle: api_key)
$query = "SELECT `key` FROM api_key WHERE id = ?";
$stmt = $mysqli->prepare($query);
if (!$stmt) {
    echo json_encode(["error" => "Fehler bei der Vorbereitung der API-Key-Abfrage: " . $mysqli->error]);
    exit;
}
$stmt->bind_param("i", $keyId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["error" => "Kein API-Key für das aktive Projekt gefunden."]);
    exit;
}

$row = $result->fetch_assoc();
$apiKey = trim($row['key']); // Sicherstellen, dass der Key ohne Leerzeichen übernommen wird
$stmt->close();
$mysqli->close();

// 3️⃣ KI-Prompt generieren
$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

if (!isset($data['answers']) || empty($data['answers'])) {
    echo json_encode(["error" => "Keine Antworten erhalten."]);
    exit;
}
$answers = $data['answers'];

$prompt = "Bitte analysiere die folgenden Antworten und erstelle eine individuelle Strategie:\n\n";
foreach ($answers as $questionId => $answer) {
    $antwortText = is_array($answer) ? json_encode($answer) : $answer;
    $prompt .= "Frage: " . htmlspecialchars($questionId) . "\nAntwort: " . htmlspecialchars($antwortText) . "\n\n";
}

// 4️⃣ API-Request vorbereiten
$payload = [
    "model" => "gpt-3.5-turbo",
    "messages" => [
        ["role" => "system", "content" => "Du bist ein Marketing-Experte, der eine personalisierte Strategie erstellt."],
        ["role" => "user", "content" => $prompt]
    ],
    "temperature" => 0.5,
    "max_tokens" => 300
];

$ch = curl_init('https://api.openai.com/v1/chat/completions');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30); // Timeout auf 30 Sekunden setzen
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

// 5️⃣ API-Request ausführen
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

// 6️⃣ Debugging: Fehleranalyse direkt in die API-Antwort einfügen
$debugData = [
    "http_code" => $httpCode,
    "raw_response" => $response ?: "Keine Antwort",
    "curl_error" => $error ?: "Kein cURL-Fehler",
    "api_key_length" => strlen($apiKey) // Überprüfung der Key-Länge
];

if ($error) {
    echo json_encode(["error" => "cURL-Fehler: " . $error, "debug" => $debugData]);
    exit;
}

if ($httpCode !== 200) {
    echo json_encode(["error" => "Fehlerhafte HTTP-Antwort von OpenAI", "debug" => $debugData]);
    exit;
}

if (!$response) {
    echo json_encode(["error" => "Leere Antwort von OpenAI erhalten.", "debug" => $debugData]);
    exit;
}

// 7️⃣ Antwort von OpenAI verarbeiten
$result = json_decode($response, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["error" => "JSON-Fehler: " . json_last_error_msg(), "debug" => $debugData]);
    exit;
}

if (!isset($result["choices"][0]["message"]["content"])) {
    echo json_encode(["error" => "Ungültige Antwort von OpenAI.", "debug" => $debugData]);
    exit;
}

$aiResponse = $result["choices"][0]["message"]["content"];

// 8️⃣ Ausgabe für das Frontend mit Debugging-Infos
echo json_encode([
    "antwort" => nl2br(htmlspecialchars($aiResponse)),
    "debug" => $debugData
]);
exit;
