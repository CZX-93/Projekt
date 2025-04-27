<?php
// Session starten (nur einmal, falls noch nicht gestartet)
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
require_once __DIR__ . '/db_connect.php'; // Verbindung zur Datenbank herstellen

function login_user(mysqli $mysqli, string $username, string $password): ?string {
    // Nutzer anhand des Benutzernamens abrufen
    $stmt = $mysqli->prepare("SELECT id, username, password FROM users WHERE username = ?");
    if (!$stmt) {
        return "Datenbankfehler: " . $mysqli->error;
    }

    // Parameter binden und ausführen
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user && password_verify($password, $user['password'])) {
        // Session starten und Nutzer speichern
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Erfolgreicher Login -> Weiterleitung ins Admin-Panel
        $_SESSION['message'] = "Erfolgreich eingeloggt!"; // Erfolgsmeldung setzen
        header("Location: homesite.php"); // Redirect zum Dashboard
        exit();
    } else {
        return "Ungültiger Benutzername oder Passwort.";
    }
}
?>
