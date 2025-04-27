<?php
// Fehlerberichterstattung aktivieren
//(ini_set('display_errors', 1);
//error_reporting(E_ALL);
session_start();

// Session-Handler einbinden (falls extern definiert)
require_once('session_handler.php');

// Sicherstellen, dass das Array für Fragen/Antworten existiert
if (!isset($_SESSION['qa_data'])) {
    $_SESSION['qa_data'] = [];
}

// Wenn das Formular abgesendet wurde, die Antworten speichern
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Durchlaufe alle Fragen und speichere die Antworten
    foreach ($_POST as $key => $answer) {
        // Extrahiere die Frage-ID aus dem Namen des Inputs (z.B. question_1, question_2, ...)
        if (preg_match('/question_(\d+)/', $key, $matches)) {
            $questionId = (int)$matches[1];  // Die Frage-ID extrahieren
            $answer_value = is_array($answer) ? implode(", ", $answer) : $answer; // Falls Multiple-Choice (Checkboxen), Antworten zusammenfügen

            // Antwort in die Session-Daten einfügen
            $_SESSION['qa_data'][$questionId] = $answer_value; // Die Antwort wird jetzt als `answerText` gespeichert
        }
    }
}

// Verbindung zur Datenbank und Fragen holen
require_once('db_connect.php');
$mysqli = db_connect();
require_once('fragenverwaltung.php');

// Aktives Projekt abrufen
$activeProject = getActiveProject($mysqli);

if (!$activeProject) {
    echo json_encode(['error' => 'Kein aktives Projekt gefunden.']);
    exit;
}

$questions = getQuestionsForProject($mysqli, $activeProject['id']);

// Debug-Status aus der Datenbank abrufen
$debugStatus = false;
$query = "SELECT debug FROM projekt WHERE id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $activeProject['id']);
$stmt->execute();
$stmt->bind_result($debugStatus);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fragebogen</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Header-Bereich -->
    <header>
        <div class="logo">
            <img src="img/WEBAN-Logo.svg" alt="WEBAN Logo">
        </div>
        <h1>Mehr <span class="highlight">Erfolg</span> für dein Unternehmen</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nonummy nibh...</p>
    </header>
    <?php if ($debugStatus): ?>
        <aside id="aside_debug" class="sidebar">
            <iframe style="width:100%;height:100vh" class="frame" src="debug_console.php"></iframe>
        </aside>
    <?php else: ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("aside_debug")?.remove();
            });
        </script>
    <?php endif; ?>
    <main>
        <!-- Einleitungsbereich -->
        <section id="introSection">
            <div class="intro-text">
                <p>Willkommen zu unserer Umfrage! Ihre Antworten helfen uns, wertvolle Einblicke zu gewinnen. Bitte nehmen Sie sich einen Moment Zeit, um teilzunehmen.</p>
                <button id="startSurveyButton">Analyse starten</button>
            </div>
        </section>

        <!-- Fragebereich -->
        <section class="question-wrapper" id="questionWrapper" style="display: none;">
            <div class="question-container">
            <form id="questionForm" method="POST">
                <?php
                // Mapping der Typ-IDs zu HTML-Input-Typen
                $inputTypeMapping = [
                    1 => "text",       // Beispiel: Single Choice
                    2 => "checkbox",    // Beispiel: Multiple Choice
                    3 => "radio",        // Beispiel: Freitext
                    4 => "textarea"     // Beispiel: Langtext
                ];

                // Fragen für das aktive Projekt abrufen
                $questions = getQuestionsForProject($mysqli, $activeProject['id']);

                // JSON mit Debug-Infos ausgeben
                $response = [
                    'project' => $activeProject,
                    'questions' => $questions
                ];
                error_log("API Response: " . json_encode($response, JSON_PRETTY_PRINT));

                foreach ($questions as $i => $q) {
                    $questionId = $q['id'];
                    $questionText = $q['frage'];
                    $questionTypeId = $q['typ_id'];
                    $questionType = $q['typ_name'] ?? 'Unbekannter Typ';
                    $inputType = $inputTypeMapping[$questionTypeId] ?? 'text'; // Standardmäßig Textfeld

                    // Füge data-question-id hinzu
                    echo "<div class='question' id='question$i' data-question-id='$questionId'>";
                    echo "<h2>" . ($i + 1) . ". " . $questionText . " <span class='question-type'>($questionType)</span></h2>";

                    // Antwortmöglichkeiten für Radio/Checkbox
                    if ($inputType === "radio" || $inputType === "checkbox") {
                        foreach ($q['antworten'] as $answer) {
                            $answerText = htmlspecialchars($answer['antwort']);
                            // Korrektes Name-Attribut je nach Input-Typ
                            $nameAttribute = $inputType === 'checkbox'
                                ? 'name="question_' . $questionId . '[]"'
                                : 'name="question_' . $questionId . '"';

                            echo "<label>";
                            echo "<input type='$inputType' $nameAttribute value='" . htmlspecialchars($answer['id']) . "'> $answerText";
                            echo "</label><br>";
                        }
                    }
                    // Eingabefeld für Text & Textarea
                    else {
                        if ($inputType === "textarea") {
                            echo "<textarea name='question_$questionId'></textarea>";
                        } else {
                            echo "<input type='$inputType' name='question_$questionId'>";
                        }
                    }
                    echo "</div>";
                }
                ?>
            </form>

            </div>

            <!-- Navigationsbereich -->
            <div class="navigation">
                <button id="prevButton" style="display: none;">&lt; Zurück</button>
                <button id="nextButton">Weiter &gt;</button>
                <button id="submitButton" style="display: none;">Abschicken</button>
            </div>

            <!-- Fortschrittsanzeige -->
            <div class="progress-container">
                <progress id="progressBar" value="0" max="100"></progress>
                <div id="progressTextContainer">
                    <p id="progressText">Frage 1 von <?php echo count($questions); ?></p>
                </div>
            </div>
        </section>

        <!-- Antwortbereich (Versteckt bis zum Abschicken) -->
        <?php
        if (isset($_GET['finished']) && $_GET['finished'] == 1): ?>
            <section class="response-wrapper" id="responseWrapper" style="display: block;">
                <h3>Antwort der KI:</h3>
                <textarea readonly><?php echo htmlspecialchars($_SESSION['ai_response'] ?? ''); ?></textarea>
            </section>
        <?php else: ?>
            <section class="response-wrapper" id="responseWrapper">
                <h3>Antwort der KI:</h3>
                <textarea id="responseField" readonly></textarea>
            </section>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <nav>
                <ul>
                    <li><a href="https://www.weban.de/inside/impressum/">Impressum</a></li>
                    <li><a href="https://www.weban.de/inside/datenschutz">Datenschutz</a></li>
                </ul>
            </nav>
        </div>
    </footer>

    <!-- JavaScript Verlinkungen -->
    <script src="js/script.js"></script>
</body>
</html>
