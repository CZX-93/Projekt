<?php
// Session starten (nur einmal, falls noch nicht gestartet)
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Datenbankverbindung einbinden (stellt sicher, dass sie nur einmal geladen wird)
require_once 'db_connect.php'; 

// Falls Login-Formular abgesendet wurde
if (isset($_POST['login'])) {
    // Benutzereingaben
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Login-Funktion einbinden und den Fehler ermitteln
    require_once 'db_login.php'; // Deine Logik zum Login wird hier eingebunden

    // Login überprüfen
    $error = login_user($mysqli, $username, $password);
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin Panel</title>
    <link rel="stylesheet" href="css/login_style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Admin Login</h2>
            
            <?php
            // Erfolgsmeldung anzeigen
            if (isset($_SESSION['message'])) {
                echo "<p class='success'>" . htmlspecialchars($_SESSION['message']) . "</p>";
                unset($_SESSION['message']);
            }
            ?>

            <form action="login.php" method="POST">
                <label for="username">Benutzername</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Passwort</label>
                <input type="password" id="password" name="password" required>

                <button type="submit" name="login">Einloggen</button>
            </form>

            <?php
            // Fehler anzeigen, falls vorhanden
            if (isset($error)) {
                echo "<p class='error'>" . htmlspecialchars($error) . "</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
