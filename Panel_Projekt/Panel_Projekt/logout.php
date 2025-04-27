<?php
// Session starten (nur einmal, falls noch nicht gestartet)
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Alle Session-Daten entfernen
session_unset();

// Session zerstören
session_destroy();

// Session-ID löschen (zusätzlich zur Zerstörung der Session)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}

// Nachricht in der Session speichern
$_SESSION['message'] = "Sie wurden erfolgreich abgemeldet.";

// Weiterleitung zur Login-Seite
header("Location: login.php");
exit();
?>

