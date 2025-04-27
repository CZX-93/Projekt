<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Session starten (nur einmal, falls noch nicht gestartet)
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Überprüfen, ob der Admin eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require_once "db_connect.php";
require_once "user_management_backend.php";

$message = isset($message) ? htmlspecialchars($message) : ''; // Sicherheit bei der Ausgabe
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzerverwaltung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/user_management_style.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Benutzerverwaltung</h1>

        <!-- Nachricht anzeigen -->
        <?php if ($message) { echo "<div class='alert alert-success'>$message</div>"; } ?>

        <!-- Formular zum Hinzufügen eines neuen Benutzers -->
        <div class="card mb-4">
            <div class="card-header">Benutzer hinzufügen</div>
            <div class="card-body">
                <form action="user_management_backend.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Benutzername</label>
                        <input type="text" id="username" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-Mail</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Passwort</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Rolle</label>
                        <select id="role" name="role" class="form-select" required>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    <button type="submit" name="add_user" class="btn btn-primary">Benutzer hinzufügen</button>
                </form>
            </div>
        </div>

        <!-- Tabelle zur Anzeige der Benutzer -->
        <div class="card">
            <div class="card-header">Benutzerliste</div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Benutzername</th>
                            <th>E-Mail</th>
                            <th>Rolle</th>
                            <th>Aktionen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($users)) {
                            foreach ($users as $row) {
                                echo "<tr>
                                    <td>" . htmlspecialchars($row['id']) . "</td>
                                    <td>" . htmlspecialchars($row['username']) . "</td>
                                    <td>" . htmlspecialchars($row['email']) . "</td>
                                    <td>" . htmlspecialchars($row['role']) . "</td>
                                    <td>
                                        <a href='edit_user.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-warning btn-sm'>Bearbeiten</a>
                                        <form action='user_management_backend.php' method='POST' style='display:inline;' onsubmit='return confirm(\"Möchten Sie diesen Benutzer wirklich löschen?\");'>
                                            <input type='hidden' name='user_id' value='" . htmlspecialchars($row['id']) . "'>
                                            <button type='submit' name='delete_user' class='btn btn-danger btn-sm'>Löschen</button>
                                        </form>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center'>Keine Benutzer gefunden</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>


