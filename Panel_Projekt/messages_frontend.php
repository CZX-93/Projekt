<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Nachrichtensystem</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/messages_style.css">
    <script src="js/messages_script.js" defer></script>
</head>
<body>
    <div class="chat-container">
        <div class="user-list">
            <h3>Chats</h3>
            <ul id="userList"></ul>
        </div>
        <div class="chat-window">
            <h2 id="chatTitle">Wähle einen Chat</h2>
            <div class="chat-box"></div>
            <form id="messageForm" enctype="multipart/form-data">
                <input type="hidden" id="recipient" name="recipient">
                <label>Nachricht:</label>
                <textarea id="messageText" name="message" required></textarea>
                <label>Anhang:</label>
                <input type="file" id="attachment" name="attachment">
                <button type="submit">Senden</button>
            </form>
        </div>
    </div>
</body>
</html>
