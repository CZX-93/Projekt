<?php
// Session starten (nur einmal, falls noch nicht gestartet)
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Wenn der Benutzer bereits eingeloggt ist, wird er zur homesite.php weitergeleitet
if (isset($_SESSION['user_id'])) {
    header('Location: homesite.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Willkommen - Projektname</title>
    <link rel="stylesheet" href="css/index.css"> <!-- Dein Stylesheet -->
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Startseite</a></li>
                <li><a href="register.php">Registrieren</a></li>
            </ul>
        </nav>
    </header>

    <main class="login-container">
        <section class="login-form">
            <h1>Willkommen zu unserem Projekt!</h1>
            <p>Bitte logge dich ein, um fortzufahren:</p>

            <!-- Button, um das Login-iframe anzuzeigen -->
            <button class="login-button" id="showLoginBtn">Login</button>

            <!-- Eingebettetes Iframe für das Login -->
            <div id="loginFrameContainer">
                <iframe src="login.php" id="loginFrame" title="Login"></iframe>
            </div>

            <p class="error-message">
                <?php
                if (isset($_SESSION['login_error'])) {
                    echo $_SESSION['login_error'];
                    unset($_SESSION['login_error']);
                }
                ?>
            </p>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Dein Projektname</p>
    </footer>

    <script src="js/index.js"></script> <!-- Dein JavaScript -->
</body>
</html>
