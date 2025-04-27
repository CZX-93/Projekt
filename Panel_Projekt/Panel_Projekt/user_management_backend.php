<?php
// Session starten (nur einmal, falls noch nicht gestartet)
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once "db_connect.php";  // Einbinden der Datenbankverbindung

// Sicherstellen, dass die Datenbankverbindung existiert
if (!isset($mysqli) || !$mysqli) {
    die("Fehler: Keine gültige Datenbankverbindung.");
}

// Benutzer hinzufügen
if (isset($_POST['add_user'])) {
    if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['role'])) {
        $new_username = $_POST['username'];
        $new_email = $_POST['email'];
        $new_password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $new_role = $_POST['role'];

        $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssss", $new_username, $new_email, $new_password, $new_role);
            if ($stmt->execute()) {
                $message = "Benutzer erfolgreich hinzugefügt!";
            } else {
                $message = "Fehler beim Hinzufügen des Benutzers: " . $stmt->error;
            }
        } else {
            $message = "Datenbankfehler: " . $mysqli->error;
        }
    } else {
        $message = "Alle Felder müssen ausgefüllt werden!";
    }
}

// Alle Benutzer abrufen
$sql = "SELECT id, username, email, role FROM users";
$result = $mysqli->query($sql);

$users = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
} else {
    $message = "Fehler beim Abrufen der Benutzerdaten: " . $mysqli->error;
}

// Rückgabe der Daten
return $users;
?>
