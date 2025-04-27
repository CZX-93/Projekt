<?php
session_start();

// Funktion zum Löschen von XML-Dateien, die älter als 24 Stunden sind
function cleanXmlFiles($directory, $logFile) {
    // Hole alle Dateien im Verzeichnis
    $files = glob($directory . '*.xml');

    // Aktuelles Datum und Uhrzeit
    $currentTime = time();

    // Erstelle das Log-File, falls es nicht existiert
    if (!file_exists($logFile)) {
        file_put_contents($logFile, "XML Cleaner Log\n\n");
    }

    foreach ($files as $file) {
        // Hole das letzte Änderungsdatum der Datei
        $fileModificationTime = filemtime($file);

        // Wenn die Datei älter als 24 Stunden ist, löschen
        if ($currentTime - $fileModificationTime > 24 * 60 * 60) {
            // Lösche die Datei
            if (unlink($file)) {
                // Logge die gelöschte Datei
                $logMessage = "[" . date('Y-m-d H:i:s') . "] GELÖSCHT: $file\n";
            } else {
                // Logge den Fehler, falls das Löschen fehlgeschlagen ist
                $logMessage = "[" . date('Y-m-d H:i:s') . "] FEHLER BEIM LÖSCHEN: $file\n";
            }

            // Schreibe das Log in die Log-Datei
            file_put_contents($logFile, $logMessage, FILE_APPEND);
        }
    }
}

// Verzeichnis für XML-Dateien und Log-Datei
$xmlDirectory = __DIR__ . '/xml_archives/';
$logFile = __DIR__ . '/xml_cleaner_log.txt'; // Pfad zur Log-Datei

// Erstelle das Verzeichnis für XML-Dateien, wenn es nicht existiert
if (!is_dir($xmlDirectory)) {
    mkdir($xmlDirectory, 0777, true);
}

// Rufe den Cleaner auf, um alte XML-Dateien zu löschen
cleanXmlFiles($xmlDirectory, $logFile);

// Session-ID-basierter Dateiname für die XML-Datei
$sessionId = session_id();
$xmlFilePath = $xmlDirectory . "survey_{$sessionId}.xml";

// XML erstellen oder laden
if (!file_exists($xmlFilePath)) {
    // Wenn die XML-Datei nicht existiert, erstellen wir eine neue
    $xml = new SimpleXMLElement('<survey></survey>');
    $xml->asXML($xmlFilePath);
} else {
    // Wenn die XML-Datei existiert, laden wir sie
    $xml = simplexml_load_file($xmlFilePath);
}

// Antworten speichern
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!empty($data)) {
        // Verhindern, dass doppelte Einträge in der gleichen Session gespeichert werden
        $existingQuestion = $xml->xpath("/survey/question[@id='{$data['questionId']}']");

        if (empty($existingQuestion)) {
            // Wenn die Frage noch nicht gespeichert wurde, speichern wir sie
            $questionElement = $xml->addChild('question');
            $questionElement['id'] = $data['questionId'];
            $questionElement->addChild('text', htmlspecialchars($data['questionText']));
            $questionElement->addChild('answer', htmlspecialchars(implode(',', $data['answers'])));
        }
    }

    // Speichern der XML-Datei
    $xml->asXML($xmlFilePath);
}

// Optional: Ausgabe der XML-Daten zur Debugging-Zwecken
header('Content-Type: application/xml');
echo $xml->asXML();
?>

