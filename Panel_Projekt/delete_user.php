<?php
// Session starten (nur einmal, falls noch nicht gestartet)
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Überprüfen, ob der Administrator eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Einbinden der Datenbankverbindung
require_once 'db_connect.php';

// Überprüfen, ob die ID per POST übermittelt wurde
if (isset($_POST['user_id']) && is_numeric($_POST['user_id'])) {
    $user_id = (int)$_POST['user_id']; // Die ID auf Integer setzen

    // Sicherstellen, dass der Admin sich nicht selbst löscht
    if ($user_id == $_SESSION['admin_id']) {
        echo "Sie können sich nicht selbst löschen.";
        exit();
    }

    // Überprüfen, ob der Benutzer existiert
    $checkSql = "SELECT id FROM admins WHERE id = ?";
    $checkStmt = $mysqli->prepare($checkSql);
    $checkStmt->bind_param("i", $user_id);
    $checkStmt->execute();
    $checkStmt->store_result();

    // Wenn der Benutzer nicht existiert
    if ($checkStmt->num_rows === 0) {
        echo "Benutzer nicht gefunden.";
        exit();
    }
    $checkStmt->close();

    // SQL-Statement zum Löschen des Benutzers
    $sql = "DELETE FROM admins WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $user_id);

    // Überprüfen, ob das Löschen erfolgreich war
    if ($stmt->execute()) {
        $stmt->close();
        $message = "Benutzer erfolgreich gelöscht.";
        header("Location: user_management.php?message=" . urlencode($message));
        exit();
    } else {
        echo "Fehler beim Löschen.";
    }
    $stmt->close();
} else {
    header("Location: user_management.php?message=" . urlencode("Ungültige Benutzer-ID."));
    exit();
}
?>
