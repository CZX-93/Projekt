<?php
// Verbindung zur Datenbank herstellen und alle Assistant Keys abrufen
$assistantKeys = []; // Hier solltest du deine Daten aus der DB abrufen

// Beispiel für DB-Abfrage (dieses Beispiel geht davon aus, dass du die Datenbankverbindung bereits hergestellt hast)
// $query = "SELECT id, key FROM assistant_key"; 
// $result = mysqli_query($conn, $query);
// while ($row = mysqli_fetch_assoc($result)) {
//     $assistantKeys[] = $row;
// }
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projekt erstellen</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/project_editor_style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="my-4">Projekt erstellen</h1>

        <!-- Formular -->
        <form action="project_creator_backend.php" method="POST">
            <div class="mb-3">
                <label for="projectName" class="form-label">Projektname</label>
                <input type="text" class="form-control" id="projectName" name="projectName" required>
            </div>

            <!-- Assistant Key Auswahl -->
            <div class="mb-3">
                <label for="assistantKey" class="form-label">Assistant Key</label>
                <select class="form-select" id="assistantKey" name="assistantKey">
                    <option value="">Bitte wählen</option>
                    <?php foreach ($assistantKeys as $key): ?>
                        <option value="<?= $key['id'] ?>"><?= $key['key'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Neuer Assistant Key -->
            <div class="mb-3">
                <label for="newAssistantKey" class="form-label">Neuer Assistant Key</label>
                <input type="text" class="form-control" id="newAssistantKey" name="newAssistantKey">
                <small class="form-text text-muted">Falls kein passender Assistant Key vorhanden ist, geben Sie hier einen neuen ein.</small>
            </div>

            <!-- Fragen Container -->
            <div id="questionsContainer">
                <div class="mb-3" id="question0">
                    <label for="questions[0][question]" class="form-label">Frage 1</label>
                    <input type="text" class="form-control" id="questions[0][question]" name="questions[0][question]" required>
                    
                    <label for="questions[0][type]" class="mt-2">Typ der Frage</label>
                    <select class="form-select" id="questions[0][type]" name="questions[0][type]" required>
                        <option value="text">Text</option>
                        <option value="multiple">Multiple Choice</option>
                        <option value="radio">Radio</option>
                    </select>

                    <div class="mt-3">
                        <label class="form-label">Antworten</label>
                        <div class="answers" id="answersForQuestion0">
                            <input type="text" class="form-control mb-2" id="questions[0][answers][0]" name="questions[0][answers][0]" placeholder="Antwort hinzufügen" required>
                        </div>
                        <button type="button" class="btn btn-outline-secondary mt-2" onclick="addAnswer(0)">Weitere Antwort hinzufügen</button>
                        <button type="button" class="btn btn-outline-danger mt-2" onclick="removeQuestion(0)">Frage entfernen</button>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-success mt-3" onclick="addQuestion()">Weitere Frage hinzufügen</button>
            <button type="submit" class="btn btn-primary mt-3">Projekt erstellen</button>
        </form>
    </div>
    
    <!-- Bootstrap JS und jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="js/project_creator.js"></script>
</body>
</html>
