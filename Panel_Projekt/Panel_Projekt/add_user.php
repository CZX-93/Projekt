<?php
// Session starten (nur einmal, falls noch nicht gestartet)
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Sicherstellen, dass der Nutzer eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once "db_connect.php"; // Datenbankverbindung einbinden

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Eingabewerte validieren
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $full_name = $_POST['full_name'];
    $role = $_POST['role'];

    // Passwort hashen
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // SQL-Abfrage für das Hinzufügen eines neuen Benutzers
    $sql = "INSERT INTO admins (username, password, email, full_name, role) 
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $mysqli->prepare($sql);
    
    if (!$stmt) {
        die("Fehler beim Vorbereiten der SQL-Abfrage: " . $mysqli->error);
    }

    // Parameter binden und ausführen
    $stmt->bind_param("sssss", $username, $hashed_password, $email, $full_name, $role);
    
    if ($stmt->execute()) {
        header('Location: user_management.php'); // Nach dem Hinzufügen zurück zur Benutzerverwaltung
        exit();
    } else {
        echo "Fehler beim Hinzufügen des Benutzers: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neuen Benutzer hinzufügen</title>
</head>
<body>
    <h1>Neuen Benutzer hinzufügen</h1>
    <form method="POST" action="add_user.php">
        <label>Benutzername:</label>
        <input type="text" name="username" required><br><br>
        
        <label>Passwort:</label>
        <input type="password" name="password" required><br><br>
        
        <label>Email:</label>
        <input type="email" name="email" required><br><br>
        
        <label>Vollständiger Name:</label>
        <input type="text" name="full_name" required><br><br>
        
        <label>Rolle:</label>
        <input type="text" name="role" required><br><br>
        
        <button type="submit">Hinzufügen</button>
    </form>
</body>
</html>
