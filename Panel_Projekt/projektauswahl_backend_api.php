<?php
require 'db_connect.php'; // Verbindung zur Datenbank

header('Content-Type: application/json');

$action = $_POST['action'] ?? $_GET['action'] ?? '';
$projectId = $_POST['project_id'] ?? $_GET['project_id'] ?? '';

if (!$projectId && !in_array($action, ['update_question', 'update_question_type', 'delete_question', 'update_answer', 'delete_answer', 'add_answer'])) {
    echo json_encode(['error' => 'Projekt-ID fehlt']);
    exit();
}

switch ($action) {
    case 'get_details':
        getProjectDetails($projectId);
        break;
    case 'update_question':
        updateQuestion($_POST['question_id'], $_POST['text']);
        break;
    case 'update_question_type':
        updateQuestionType($_POST['question_id'], $_POST['type']);
        break;
    case 'delete_question':
        deleteQuestion($_POST['question_id']);
        break;
    case 'add_question':
        addQuestion($projectId, $_POST['text'], $_POST['type']);
        break;
    case 'update_answer':
        updateAnswer($_POST['answer_id'], $_POST['text']);
        break;
    case 'delete_answer':
        deleteAnswer($_POST['answer_id']);
        break;
    case 'add_answer':
        addAnswer($_POST['question_id'], $_POST['text']);
        break;
    default:
        echo json_encode(['error' => 'Ungültige Aktion']);
        exit();
}

function getProjectDetails($projectId) {
    global $mysqli;

    try {
        $stmt = $mysqli->prepare("SELECT id, frage AS text, typ AS type FROM fragen WHERE projekt_id = ?");
        if (!$stmt) {
            echo json_encode(['error' => 'SQL-Fehler: ' . $mysqli->error]);
            exit();
        }
        $stmt->bind_param("i", $projectId);
        $stmt->execute();
        $result = $stmt->get_result();
        $fragen = [];

        while ($row = $result->fetch_assoc()) {
            $qId = $row['id'];
            $answersStmt = $mysqli->prepare("SELECT id, antwort AS text FROM antworten WHERE frage_id = ?");
            if (!$answersStmt) {
                echo json_encode(['error' => 'SQL-Fehler: ' . $mysqli->error]);
                exit();
            }
            $answersStmt->bind_param("i", $qId);
            $answersStmt->execute();
            $answersResult = $answersStmt->get_result();

            $row['answers'] = [];
            while ($answerRow = $answersResult->fetch_assoc()) {
                $row['answers'][] = $answerRow;
            }
            $fragen[] = $row;
        }

        echo json_encode(['questions' => $fragen]);
    } catch (Exception $e) {
        error_log("Fehler in getProjectDetails: " . $e->getMessage());
        echo json_encode(['error' => 'Fehler beim Abrufen der Daten']);
    }
    exit();
}

function updateQuestion($questionId, $text) {
    global $mysqli;
    $stmt = $mysqli->prepare("UPDATE fragen SET frage = ? WHERE id = ?");
    $stmt->bind_param("si", $text, $questionId);
    $stmt->execute();
    echo json_encode(['success' => true]);
    exit();
}

function updateQuestionType($questionId, $type) {
    global $mysqli;
    $stmt = $mysqli->prepare("UPDATE fragen SET typ = ? WHERE id = ?");
    $stmt->bind_param("si", $type, $questionId);
    $stmt->execute();
    echo json_encode(['success' => true]);
    exit();
}

function deleteQuestion($questionId) {
    global $mysqli;
    $stmt = $mysqli->prepare("DELETE FROM antworten WHERE frage_id = ?");
    $stmt->bind_param("i", $questionId);
    $stmt->execute();

    $stmt = $mysqli->prepare("DELETE FROM fragen WHERE id = ?");
    $stmt->bind_param("i", $questionId);
    $stmt->execute();
    echo json_encode(['success' => true]);
    exit();
}

function addQuestion($projectId, $text, $type) {
    global $mysqli;
    $typ_map = ['text' => 1, 'radio' => 2, 'checkbox' => 3];
    $typeInt = is_numeric($type) ? (int)$type : ($typ_map[$type] ?? 0);

    if (!$typeInt) {
        echo json_encode(['success' => false, 'error' => 'Ungültiger Fragetyp']);
        exit();
    }

    $stmt = $mysqli->prepare("INSERT INTO fragen (projekt_id, frage, typ) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $projectId, $text, $typeInt);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'question_id' => $mysqli->insert_id]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Einfügen fehlgeschlagen']);
    }
    exit();
}


function updateAnswer($answerId, $text) {
    global $mysqli;
    $stmt = $mysqli->prepare("UPDATE antworten SET antwort = ? WHERE id = ?");
    $stmt->bind_param("si", $text, $answerId);
    $stmt->execute();
    echo json_encode(['success' => true]);
    exit();
}

function deleteAnswer($answerId) {
    global $mysqli;
    $stmt = $mysqli->prepare("DELETE FROM antworten WHERE id = ?");
    $stmt->bind_param("i", $answerId);
    $stmt->execute();
    echo json_encode(['success' => true]);
    exit();
}

function addAnswer($questionId, $text) {
    global $mysqli;
    $stmt = $mysqli->prepare("INSERT INTO antworten (frage_id, antwort) VALUES (?, ?)");
    $stmt->bind_param("is", $questionId, $text);
    $stmt->execute();
    echo json_encode(['answer_id' => $mysqli->insert_id]);
    exit();
}
