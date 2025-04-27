<?php
require_once 'session_handler.php';

// Falls Änderungen an einer Frage vorgenommen werden, wird die Session aktualisiert
if (isset($_POST['frage_id']) && isset($_POST['antwort'])) {
    $frageId = $_POST['frage_id'];
    $antwort = $_POST['antwort'];

    // Die Session mit der neuen Antwort aktualisieren
    updateSessionData($frageId, $antwort);
}
/**
 * Funktion zur Ermittlung des aktiven Projekts
 */
function getActiveProject($mysqli)
{
    $sql = "SELECT id, name FROM projekt WHERE is_active = 1";
    $result = mysqli_query($mysqli, $sql);

    if (!$result) {
        error_log("SQL-Fehler in getActiveProject: " . mysqli_error($mysqli));
        return null;
    }

    if (mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
    error_log("Kein aktives Projekt gefunden.");
    return null;
}

/**
 * Funktion zum Abrufen der Fragen und Antworten für das aktive Projekt
 */
function getQuestionsForProject($mysqli, $projectId) {
    $sql = "
        SELECT
            fragen.id AS frage_id,
            fragen.frage,
            fragen.typ AS typ_id,  -- Typ-ID wird hier korrekt abgerufen
            type.type AS typ_name,
            antworten.id AS antwort_id,
            antworten.antwort
        FROM fragen
        LEFT JOIN antworten ON fragen.id = antworten.frage_id
        LEFT JOIN type ON fragen.typ = type.id
        WHERE fragen.projekt_id = ?";

    $stmt = mysqli_prepare($mysqli, $sql);

    if (!$stmt) {
        error_log("Fehler beim Vorbereiten der Abfrage: " . mysqli_error($mysqli));
        return ['error' => 'Fehler beim Vorbereiten der Abfrage'];
    }

    mysqli_stmt_bind_param($stmt, "i", $projectId);
    if (!mysqli_stmt_execute($stmt)) {
        error_log("Fehler beim Ausführen der Abfrage: " . mysqli_stmt_error($stmt));
        return ['error' => 'Fehler beim Ausführen der Abfrage'];
    }

    $result = mysqli_stmt_get_result($stmt);
    if (!$result) {
        error_log("Fehler beim Abrufen der Fragen: " . mysqli_error($mysqli));
        return ['error' => 'Fehler beim Abrufen der Fragen'];
    }

    $questions = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $questionId = $row['frage_id'];

        if (!isset($questions[$questionId])) {
            $questions[$questionId] = [
                'id' => $row['frage_id'],
                'frage' => $row['frage'],
                'typ_id' => $row['typ_id'],  // Hier wurde der Fehler korrigiert
                'typ_name' => $row['typ_name'],
                'antworten' => []
            ];
        }
        //var_dump($row);
        if (!empty($row['antwort_id'])) { // Verhindert Hinzufügen von NULL-Werten
            $questions[$questionId]['antworten'][] = [
                'id' => $row['antwort_id'],
                'antwort' => $row['antwort']
            ];
        }
    }

    mysqli_stmt_close($stmt);

    return array_values($questions);
}






?>