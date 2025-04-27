<?php
// db_connect.php
// Funktion für die Datenbankverbindung
function db_connect() {
    // Datenbank-Konfigurationsdaten
    $host = "localhost";
    $dbname = "prakti_basti_Projekt";
    $dbusername = "root";
    $dbpassword = "";

    // Neue MySQLi-Verbindung herstellen
    $mysqli = new mysqli($host, $dbusername, $dbpassword, $dbname);

    // Überprüfen, ob die Verbindung erfolgreich war
    if ($mysqli->connect_error) {
        // Fehler protokollieren
        error_log("❌ DB-Verbindung fehlgeschlagen: " . $mysqli->connect_error, 3, "error_log.txt");
        die("❌ Die Verbindung zur Datenbank konnte nicht hergestellt werden. Bitte versuche es später erneut.");
    }
    // Rückgabe der MySQLi-Verbindung
    return $mysqli;
}

// Beispiel: Verwendung der Funktion in einer Datei
//$mysqli = db_connect(); // Verbindung herstellen
// Danach kannst du mit der $mysqli-Variable arbeiten
?>
