<?php
require_once 'session_handler.php';

// Falls Änderungen an einer Frage vorgenommen werden, wird die Session aktualisiert
if (isset($_POST['frage_id']) && isset($_POST['antwort'])) {
    $frageId = $_POST['frage_id'];
    $antwort = $_POST['antwort'];

    // Die Session mit der neuen Antwort aktualisieren
    updateSessionData($frageId, $antwort);
}
// db_connect.php einbinden
require_once('db_connect.php');

// Datenbankverbindung herstellen
$mysqli = db_connect();

// Überprüfen, ob die Verbindung erfolgreich war
if ($mysqli->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Datenbankverbindung konnte nicht hergestellt werden.']);
    exit;
}

// Abfrage für das aktive Projekt (is_active = 1)
$sql = "SELECT id FROM projekt WHERE is_active = 1 LIMIT 1"; // Nur das erste aktive Projekt
$stmt = $mysqli->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// Überprüfen, ob ein aktives Projekt gefunden wurde
if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Kein aktives Projekt gefunden.']);
    exit;
}

// Projekt-ID abrufen
$projekt = $result->fetch_assoc();
$projekt_id = $projekt['id']; // ID des aktiven Projekts

// **Debugging** - Überprüfen, ob die Projekt-ID korrekt ist
echo "<h3>Debugging Info</h3>";
echo "<pre>";
echo "Projekt ID: " . $projekt_id . "\n";
echo "</pre>";

// Abfrage für die Projekt-Daten
$sqlProject = "SELECT * FROM projekt WHERE id = ?";
$stmtProject = $mysqli->prepare($sqlProject);
$stmtProject->bind_param("i", $projekt_id);
$stmtProject->execute();
$projectResult = $stmtProject->get_result();

// Überprüfen, ob das Projekt existiert
if ($projectResult->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Projekt konnte nicht geladen werden.']);
    exit;
}

// Projekt-Details abrufen
$projectData = $projectResult->fetch_assoc();
$apiKeyId = $projectData['key']; // API Key ID aus der Projekt-Datenbank
$assistantKeyId = $projectData['assistant_key_id']; // Assistant Key ID aus der Projekt-Datenbank

// **Debugging** - Überprüfen, ob die Key-IDs korrekt sind
echo "<h3>Key-IDs</h3>";
echo "<pre>";
echo "API Key ID: " . $apiKeyId . "\n";
echo "Assistant Key ID: " . $assistantKeyId . "\n";
echo "</pre>";

// Abrufen der API Key-Daten
$sqlApiKey = "SELECT * FROM api_key WHERE id = ?";
$stmtApiKey = $mysqli->prepare($sqlApiKey);
$stmtApiKey->bind_param("i", $apiKeyId);
$stmtApiKey->execute();
$resultApiKey = $stmtApiKey->get_result();

// Fehlerbehandlung, falls der API Key nicht gefunden ist
if ($resultApiKey->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'API Key nicht gefunden.']);
    exit;
}
$apiKey = $resultApiKey->fetch_assoc()['key']; // Der API Key

// Abrufen der Assistant Key-Daten
$sqlAssistantKey = "SELECT * FROM assistant_key WHERE id = ?";
$stmtAssistantKey = $mysqli->prepare($sqlAssistantKey);
$stmtAssistantKey->bind_param("i", $assistantKeyId);
$stmtAssistantKey->execute();
$resultAssistantKey = $stmtAssistantKey->get_result();

// Fehlerbehandlung, falls der Assistant Key nicht gefunden ist
if ($resultAssistantKey->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Assistant Key nicht gefunden.']);
    exit;
}
$assistantKey = $resultAssistantKey->fetch_assoc()['key_value']; // Der Assistant Key

// **Debugging** - Überprüfen, ob die Keys korrekt abgerufen wurden
echo "<h3>API Key und Assistant Key</h3>";
echo "<pre>";
echo "API Key: " . $apiKey . "\n";
echo "Assistant Key: " . $assistantKey . "\n";
echo "</pre>";



// KI-Antwort zurückgeben
echo json_encode(['success' => true, 'ai_response' => $response]);

// Funktion, um die KI-Antwort von OpenAI zu holen
function getAIResponseFromOpenAI($apiKey, $assistantKey, $userInput) {
    $endpoint = "https://api.openai.com/v1/chat/completions";  // OpenAI ChatGPT-Endpoint

    // Beispiel-Daten, die an die API gesendet werden
    $postData = [
        'model' => 'gpt-3.5-turbo',  // Modell auswählen
        'messages' => [
            ['role' => 'user', 'content' => $userInput]  // Die Anfrage des Benutzers
        ],
        'max_tokens' => 200,  // Maximale Anzahl von Tokens für die Antwort
        'temperature' => 0.7   // Steuerung der Kreativität der Antwort
    ];

    // cURL initialisieren
    $ch = curl_init();

    // cURL-Optionen setzen
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $apiKey"  // API-Key verwenden
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

    // Deaktivierung der SSL-Verifizierung für Testzwecke
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    // Timeout auf 60 Sekunden setzen, um lange Wartezeiten zu vermeiden
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);

    // Protokollierung der cURL-Fehler
    curl_setopt($ch, CURLOPT_VERBOSE, true);  // Aktiviert Fehlerprotokolle für cURL

    // Anfrage ausführen und Antwort speichern
    $response = curl_exec($ch);

    // Fehlerbehandlung: Falls cURL einen Fehler hat
    if (curl_errno($ch)) {
        echo 'cURL Fehler: ' . curl_error($ch);  // cURL Fehler ausgeben
        curl_close($ch);
        return ['success' => false, 'message' => 'Fehler beim Senden des HTTP-Requests.'];
    }

    // HTTP-Statuscode prüfen
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($httpCode !== 200) {
        echo 'HTTP-Fehlercode: ' . $httpCode . "\n";  // HTTP-Fehlercode ausgeben
        echo 'Antwort: ' . $response . "\n";  // API-Antwort ausgeben
        curl_close($ch);
        return ['success' => false, 'message' => 'Fehler beim Abrufen der KI-Antwort: HTTP-Code ' . $httpCode];
    }

    // cURL-Verbindung schließen
    curl_close($ch);

    // Antwort von OpenAI dekodieren
    $responseData = json_decode($response, true);
    // Überprüfen, ob die Antwort erfolgreich dekodiert wurde
    if ($responseData && isset($responseData['choices'][0]['message']['content'])) {
        return [
            'success' => true,
            'message' => 'Erfolgreiche Antwort erhalten.',
            'response' => $responseData['choices'][0]['message']['content']  // KI-Antwort extrahieren
        ];
    } else {
        return ['success' => false, 'message' => 'Fehler beim Verarbeiten der KI-Antwort.'];
    }
}

// Beispiel für eine Benutzereingabe
$userInput = "Erzählen Sie mir mehr über die OpenAI GPT-Modelle.";

// Die OpenAI API- und Assistant-Keys, die du für die Anfrage verwendest
$apiKey = "**";  // Dein OpenAI API-Key
$assistantKey = "**";  // Dein Assistant Key (falls erforderlich)

// KI-Antwort abrufen
$result = getAIResponseFromOpenAI($apiKey, $assistantKey, $userInput);

// Ausgabe der Ergebnisse auf der Seite
echo "<h1>KI-Antwort</h1>";
echo "<pre>";
print_r($result);  // Die gesamte Antwort und Fehlermeldungen anzeigen
echo "</pre>";

// Falls gewünscht, kannst du die Antwort auch so ausgeben:
if ($result['success']) {
    echo "<h2>Antwort von der KI:</h2>";
    echo "<p>" . htmlspecialchars($result['response']) . "</p>";
} else {
    echo "<h2>Fehler:</h2>";
    echo "<p>" . htmlspecialchars($result['message']) . "</p>";
}
?>
