<?php
// Session starten, falls noch nicht gestartet
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Datenbank-Konfigurationsdaten
$host = "localhost";
$dbname = "prakti_basti_Projekt";
$dbusername = "root";
$dbpassword = "";

// Neue MySQLi-Verbindung herstellen
$mysqli = new mysqli($host, $dbusername, $dbpassword, $dbname);

// Überprüfen, ob die Verbindung erfolgreich hergestellt wurde
/*if ($mysqli->connect_error) {
    die("❌ DB-Verbindung fehlgeschlagen: " . $mysqli->connect_error);
} else {
    echo "✅ DB-Verbindung erfolgreich!<br>";
}*/
?>

