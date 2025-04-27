<?php
require 'db_connect.php';

if (!isset($_GET['id'])) {
    echo "Keine Benutzer-ID übergeben.";
    exit;
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
    echo "Benutzer nicht gefunden.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Benutzer bearbeiten</title>
    <link rel="stylesheet" href="user_management_style.css">
</head>
<body>
<div class="container">
    <h2>Benutzer bearbeiten</h2>
    <form action="user_management_backend.php" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">

        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
        </div>

        <div>
            <label for="email">E-Mail:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>

        <div>
            <label for="role">Rolle:</label>
            <select name="role" required>
                <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
                <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>

        <button type="submit" name="update_user">Speichern</button>
    </form>
</div>
</body>
</html>
