<?php
session_start();
require_once 'db_connect.php'; // Datenbankverbindung

// Benutzer-ID aus der Session sicherstellen
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == 0) {
    header("Location: ../login.php"); // Umleitung zur Login-Seite
    exit;
}
$user_id = $_SESSION['user_id'];

// Benutzerdaten abrufen
$sql = "SELECT username, email, avatar FROM users WHERE id = ?";
$stmt = $mysqli->prepare($sql);
if (!$stmt) {
    die("SQL-Fehler: " . $mysqli->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Sicherstellen, dass der Benutzername keine unerwarteten Zeichen enthält
$safe_username = preg_replace("/[^a-zA-Z0-9_-]/", "", $user['username']);

// Verzeichnis für Benutzer speichern (falls nicht vorhanden, erstellen)
$user_dir = "L:/Basti/Panel_Projekt/users/" . $safe_username;
$backup_dir = "$user_dir/backup/";
if (!is_dir($user_dir)) {
    mkdir($user_dir, 0777, true);
}
if (!is_dir($backup_dir)) {
    mkdir($backup_dir, 0777, true);
}

// Funktion: Maximal 3 Backups behalten
function manage_backups($backup_dir) {
    $backups = glob("$backup_dir/*.json");
    if (count($backups) > 3) {
        array_multisort(array_map('filemtime', $backups), SORT_DESC, $backups);
        foreach (array_slice($backups, 3) as $old_backup) {
            unlink($old_backup);
        }
    }
}

// Backup anlegen vor Änderungen
$backup_data = [
    "username" => $user['username'],
    "email" => $user['email'],
    "avatar" => $user['avatar']
];
file_put_contents("$backup_dir/backup_" . date("Y-m-d_H-i-s") . ".json", json_encode($backup_data, JSON_PRETTY_PRINT));
manage_backups($backup_dir);

// Profil aktualisieren
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $new_name = trim($_POST['name']);
    $new_email = trim($_POST['email']);
    $sql = "UPDATE users SET username = ?, email = ? WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssi", $new_name, $new_email, $user_id);
    $stmt->execute();
    $stmt->close();
    header("Location: profil.php?success=1");
    exit();
}

// Passwort ändern
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_password'])) {
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    $sql = "UPDATE users SET password = ? WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("si", $new_password, $user_id);
    $stmt->execute();
    $stmt->close();
    header("Location: profil.php?password_changed=1");
    exit();
}

// Avatar hochladen und speichern
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
    $upload_dir = '../uploads/avatars/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    $avatar_name = $user_id . '_' . basename($_FILES['avatar']['name']);
    $target_file = $upload_dir . $avatar_name;
    
    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target_file)) {
        $sql = "UPDATE users SET avatar = ? WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("si", $target_file, $user_id);
        $stmt->execute();
        $stmt->close();
        header("Location: profil.php?avatar_uploaded=1");
        exit();
    }
}

// Konto löschen
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_account'])) {
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
    session_destroy();
    
    // Benutzerverzeichnis entfernen
    array_map('unlink', glob("$user_dir/*.*"));
    rmdir($user_dir);
    
    header("Location: ../index.php?account_deleted=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mein Profil</title>
    <link rel="stylesheet" href="css/profil_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="profil">
        <div class="avatar">
            <h2>Mein Profil</h2>

            <img src="<?php echo htmlspecialchars($user['avatar'] ?? '../uploads/avatars/default.png'); ?>" alt="Profilbild">
            
        </div>
        <div class="profile-section">
            <h2>Meine Daten</h2>
                <label>Vorname:</label>
                <span id="firstname-display">Test</span>
                <input type="text" id="firstname-input" value="Test" style="display:none;">
                <i class="edit-icon" onclick="toggleEdit('firstname')">✏️</i>

                <label>Nachname:</label>
                <span id="lastname-display">Test</span>
                <input type="text" id="lastname-input" value="Test" style="display:none;">
                <i class="edit-icon" onclick="toggleEdit('lastname')">✏️</i>

                <label>Alias:</label>
                <span id="alias-display">Test</span>
                <input type="text" id="alias-input" value="Test" style="display:none;">
                <i class="edit-icon" onclick="toggleEdit('alias')">✏️</i>

                <label>Geburtsdatum:</label>
                <span id="birthdate-display">Test</span>
                <input type="text" id="birthdate-input" value="Test" style="display:none;">
                <i class="edit-icon" onclick="toggleEdit('birthdate')">✏️</i>

                <label>Firma:</label>
                <span id="company-display">Test</span>
                <input type="text" id="company-input" value="Test" style="display:none;">
                <i class="edit-icon" onclick="toggleEdit('company')">✏️</i>

                <label>Abteilung:</label>
                <span id="section-display">Test</span>
                <input type="text" id="section-input" value="Test" style="display:none;">
                <i class="edit-icon" onclick="toggleEdit('section')">✏️</i>
        </div>
        <div class="profile-container">
            <h2>Einstellungen</h2>
            <form method="POST" enctype="multipart/form-data">
                <label>Avatar hochladen:</label>
                <input type="file" name="avatar" accept="image/*">
                <button type="submit">Avatar speichern</button>
            </form>
            
            <form method="POST">
                <label>Name:</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                <button type="submit" name="update_profile">Speichern</button>
            </form>
            
            <h3>Passwort ändern</h3>
            <form method="POST">
                <label>Neues Passwort:</label>
                <input type="password" name="new_password" required>
                <button type="submit" name="update_password">Passwort ändern</button>
            </form>
        </div>
        <div class="description-text"></div>
            <h2>Beschreibung</h2>
    </div>


    <script src="js/profil_script2.js"></script>
</body>
</html>
