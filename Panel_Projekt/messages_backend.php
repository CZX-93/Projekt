<?php
session_start();

require_once 'db_connect.php'; // Zentrale Datenbankverbindung

const UPLOAD_DIR = 'uploads/';
const EXPIRATION_DAYS = 30; // Standardmäßige Haltbarkeit

// Stelle sicher, dass das Upload-Verzeichnis existiert
if (!is_dir(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0777, true);
}

// Benutzerliste abrufen
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['get_users'])) {
    global $mysqli;
    $result = $mysqli->query("SELECT username FROM users");
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    echo json_encode($users);
    exit;
}

// Nachricht senden mit Anhang und Speicherung in der Datenbank
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recipient'], $_POST['message'])) {
    global $mysqli;
    $attachmentPath = null;
    
    // Datei-Upload verarbeiten
    if (!empty($_FILES['attachment']['name'])) {
        $fileName = basename($_FILES['attachment']['name']);
        $targetPath = UPLOAD_DIR . time() . "_" . $fileName;
        if (move_uploaded_file($_FILES['attachment']['tmp_name'], $targetPath)) {
            $attachmentPath = $targetPath;
        }
    }
    
    $sender = $_SESSION['username'] ?? 'Unbekannt';
    $recipient = $_POST['recipient'];
    $message = htmlspecialchars($_POST['message']);
    $timestamp = date('Y-m-d H:i:s');
    
    $stmt = $mysqli->prepare("INSERT INTO messages (sender, recipient, message, timestamp, attachment) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $sender, $recipient, $message, $timestamp, $attachmentPath);
    $stmt->execute();
    $stmt->close();
    
    echo json_encode(['status' => 'success', 'message' => 'Nachricht gesendet.', 'attachment' => $attachmentPath]);
    exit;
}

// Nachrichten abrufen zwischen zwei Nutzern
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['user'])) {
    global $mysqli;
    $currentUser = $_SESSION['username'];
    $chatUser = $_GET['user'];
    
    $stmt = $mysqli->prepare("SELECT * FROM messages WHERE (sender = ? AND recipient = ?) OR (sender = ? AND recipient = ?) ORDER BY timestamp ASC");
    $stmt->bind_param("ssss", $currentUser, $chatUser, $chatUser, $currentUser);
    $stmt->execute();
    $result = $stmt->get_result();
    $messages = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    
    echo json_encode($messages);
    exit;
}

// Tipp-Indikator aktualisieren
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['typing'], $_POST['recipient'])) {
    global $mysqli;
    $sender = $_SESSION['username'];
    $recipient = $_POST['recipient'];
    $typingStatus = $_POST['typing'] == 'true' ? 1 : 0;
    
    $stmt = $mysqli->prepare("INSERT INTO typing_status (sender, recipient, is_typing) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE is_typing = ?");
    $stmt->bind_param("ssii", $sender, $recipient, $typingStatus, $typingStatus);
    $stmt->execute();
    $stmt->close();
    exit;
}

// Tipp-Indikator abrufen
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['check_typing'], $_GET['recipient'])) {
    global $mysqli;
    $sender = $_GET['recipient'];
    $recipient = $_SESSION['username'];
    
    $stmt = $mysqli->prepare("SELECT is_typing FROM typing_status WHERE sender = ? AND recipient = ?");
    $stmt->bind_param("ss", $sender, $recipient);
    $stmt->execute();
    $result = $stmt->get_result();
    $status = $result->fetch_assoc();
    $stmt->close();
    
    echo json_encode(["typing" => $status['is_typing'] ?? 0]);
    exit;
}

// Nachricht löschen
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'], $_POST['message_id'])) {
    global $mysqli;
    $stmt = $mysqli->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->bind_param("i", $_POST['message_id']);
    $stmt->execute();
    $stmt->close();
    
    echo json_encode(['status' => 'success', 'message' => 'Nachricht gelöscht.']);
    exit;
}
