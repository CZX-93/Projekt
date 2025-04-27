<?php
// Fehleranzeigen aktivieren (nur zum Debuggen)
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

// Session starten (nur einmal, falls noch nicht gestartet)
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
require_once 'db_connect.php'; // Zentrale DB-Verbindung einbinden

echo "🚀 Debugging gestartet!<br>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "✅ POST-Request erkannt!<br>";

    // Debug-Ausgabe aller POST-Daten
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    // Überprüfen, ob der Projektname vorhanden ist
    if (empty($_POST['projectName'])) { 
        die("❌ Fehler: Der Projektname darf nicht leer sein!");
    }

    // Eingaben sichern
    $project_name = $mysqli->real_escape_string($_POST['projectName']);
    $assistant_key = (isset($_POST['assistantKey']) && !empty($_POST['assistantKey']))
        ? $mysqli->real_escape_string($_POST['assistantKey'])
        : NULL;

    // Falls der assistantKey leer ist, den newAssistantKey verwenden
    if (empty($assistant_key) && isset($_POST['newAssistantKey']) && !empty($_POST['newAssistantKey'])) {
        $assistant_key = $mysqli->real_escape_string($_POST['newAssistantKey']);
    }

    // Sicherstellen, dass der `assistant_key` in der `assistant_key`-Tabelle existiert oder hinzugefügt wird
    if ($assistant_key) {
        // Checken, ob der Assistant Key bereits existiert
        $sql_check = "SELECT id FROM assistant_key WHERE key_value = '$assistant_key' LIMIT 1";
        $result = $mysqli->query($sql_check);
        if ($result->num_rows == 0) {
            // Falls der Key noch nicht existiert, einfügen
            $sql_insert_key = "INSERT INTO assistant_key (key_value) VALUES ('$assistant_key')";
            if ($mysqli->query($sql_insert_key) === TRUE) {
                echo "✅ Assistant Key erfolgreich hinzugefügt.<br>";
                // Hole die ID des hinzugefügten Assistant Keys
                $assistant_key_id = $mysqli->insert_id;
            } else {
                die("❌ Fehler beim Hinzufügen des Assistant Keys: " . $mysqli->error);
            }
        } else {
            // Hole die ID des vorhandenen Assistant Keys
            $row = $result->fetch_assoc();
            $assistant_key_id = $row['id'];
        }
    } else {
        // Falls kein Assistant Key übermittelt wurde, setze ihn auf NULL
        $assistant_key_id = NULL;
    }

    // SQL-Befehl zum Einfügen in die Tabelle "projekt"
    $sql_project = "INSERT INTO projekt (name, assistant_key_id) VALUES ('$project_name', $assistant_key_id)";
    echo "🔎 SQL Projekt: " . htmlspecialchars($sql_project) . "<br>";

    if ($mysqli->query($sql_project) === TRUE) {
        $project_id = $mysqli->insert_id;
        echo "✅ Projekt erfolgreich erstellt! Projekt-ID: $project_id<br>";
    } else {
        die("❌ Fehler beim Erstellen des Projekts: " . $mysqli->error);
    }

    // Mapping von Fragtypen zu numerischen IDs
    $question_types = [
        'text' => 1,
        'multiple' => 2,
        'radio' => 3
    ];

    // Falls Fragen übermittelt wurden, diese in der Tabelle "fragen" einfügen
    if (isset($_POST['questions']) && is_array($_POST['questions'])) {
        foreach ($_POST['questions'] as $questionData) {
            // Überprüfen, ob Frage und Typ vorhanden sind
            if (!isset($questionData['question']) || empty($questionData['question']) || !isset($questionData['type'])) {
                echo "⚠ Ungültige Frage-Daten, überspringe diesen Eintrag.<br>";
                continue;
            }
            
            $question_text = $mysqli->real_escape_string($questionData['question']);
            
            // Typ des Fragentyps sicherstellen und umwandeln
            $type_str = strtolower(trim($questionData['type']));
            $type_id = isset($question_types[$type_str]) ? $question_types[$type_str] : 1; // Standardwert 'text' (ID 1)

            // SQL-Befehl zum Einfügen der Frage
            $sql_question = "INSERT INTO fragen (projekt_id, frage, typ) VALUES ('$project_id', '$question_text', '$type_id')";
            echo "🔎 SQL Frage: " . htmlspecialchars($sql_question) . "<br>";
            
            if ($mysqli->query($sql_question) === TRUE) {
                $question_id = $mysqli->insert_id;
                echo "✅ Frage erfolgreich eingefügt! Frage-ID: $question_id<br>";
                
                // Antworten einfügen, falls vorhanden
                if (isset($questionData['answers']) && is_array($questionData['answers'])) {
                    foreach ($questionData['answers'] as $answer) {
                        $answer_text = $mysqli->real_escape_string($answer);
                        
                        $sql_answer = "INSERT INTO antworten (frage_id, antwort) VALUES ('$question_id', '$answer_text')";
                        echo "🔎 SQL Antwort: " . htmlspecialchars($sql_answer) . "<br>";
                        
                        if ($mysqli->query($sql_answer) === TRUE) {
                            echo "✅ Antwort erfolgreich eingefügt!<br>";
                        } else {
                            echo "❌ Fehler beim Einfügen der Antwort: " . $mysqli->error . "<br>";
                        }
                    }
                }
            } else {
                echo "❌ Fehler beim Einfügen der Frage: " . $mysqli->error . "<br>";
            }
        }
    } else {
        echo "⚠ Keine Fragen erhalten.<br>";
    }
    
} else {
    echo "⚠ Kein POST-Request empfangen!";
}

$mysqli->close();
?>
