<?php
// Session starten (nur einmal, falls noch nicht gestartet)
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Admin-Login prüfen
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once "db_connect.php";
require_once "projektauswahl_backend.php";
$message = isset($message) ? htmlspecialchars($message) : '';
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel: Projekt-Auswahl</title>
    <link rel="stylesheet" href="css/projektauswahl_style.css">
    <script src="js/projektauswahl_combined.js" defer></script>
</head>
<body>
    <h1>Admin Panel: Projekt-Auswahl</h1>
    <?php if (!empty($message)): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <form id="projektForm" method="POST" action="projektauswahl_backend.php">
        <table>
            <thead>
                <tr>
                    <th>Projektname</th>
                    <th>Status</th>
                    <th>Aktionen</th>
                    <th>Debug-Modus</th>
                </tr>
            </thead>
            <tbody id="projectsList">
                <?php if (isset($projects) && is_array($projects) && count($projects) > 0): ?>
                    <?php foreach ($projects as $project): ?>
                        <tr class="project-row" data-project-id="<?php echo $project['id']; ?>">
                            <td><?php echo htmlspecialchars($project['name']); ?></td>
                            <td>
                                <input type="radio" name="project_id" value="<?php echo $project['id']; ?>" <?php echo $project['is_active'] ? 'checked' : ''; ?>>
                                <span><?php echo $project['is_active'] ? 'Aktiv' : 'Inaktiv'; ?></span>
                            </td>
                            <td>
                                <button type="button" onclick="toggleProjectDetails(<?php echo $project['id']; ?>)">Details anzeigen</button>
                            </td>
                            <td>
                                <select name="debug[<?php echo $project['id']; ?>]">
                                    <option value="1" <?php echo $project['debug'] ? 'selected' : ''; ?>>Ja</option>
                                    <option value="0" <?php echo !$project['debug'] ? 'selected' : ''; ?>>Nein</option>
                                </select>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4">Keine Projekte gefunden.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <button type="submit" name="update_status" value="1">Änderungen speichern</button>
    </form>

    <!-- MODAL-OVERLAY -->
    <div id="questionModal" class="modal-overlay hidden">
        <div class="modal-content">
            <span class="modal-close" onclick="closeModal()">×</span>
            <div id="modalContentWrapper">
                <!-- Grid wird hier dynamisch eingefügt -->
            </div>
        </div>
    </div>
</body>
</html>
