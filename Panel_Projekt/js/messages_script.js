let lastTimestamp = '';
let typingTimeout;

function loadUsers() {
    $.get("messages_backend.php?get_users=true", function(data) {
        let users = JSON.parse(data);
        let userList = $("#userList");
        userList.empty();
        users.forEach(user => {
            userList.append(`<li onclick='openChat("${user.username}")'>${user.username}</li>`);
        });
    });
}

function openChat(user) {
    $("#recipient").val(user);
    $("#chatTitle").text(`Chat mit ${user}`);
    refreshMessages(user);
}

function refreshMessages(chatUser) {
    $.get("messages_backend.php?user=" + chatUser, function(data) {
        let messages = JSON.parse(data);
        let chatBox = $(".chat-box");
        chatBox.empty();
        messages.forEach(msg => {
            let messageClass = msg.sender === "<?= $_SESSION['username'] ?>" ? 'sent' : 'received';
            chatBox.append(`
                <div class="message ${messageClass}">
                    <span class='sender'>${msg.sender}</span>
                    ${msg.attachment ? `<br><a href="${msg.attachment}" target="_blank">📎 Anhang herunterladen</a>` : ''}
                    <p>${msg.message}</p>
                    <span class='timestamp'>${msg.timestamp}</span>
                </div>`);
        });
        chatBox.scrollTop(chatBox[0].scrollHeight);
    });
}

$("#messageForm").submit(function(event) {
    event.preventDefault();
    let formData = new FormData(this);
    
    $.ajax({
        url: "messages_backend.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $("#messageForm")[0].reset();
            refreshMessages($("#recipient").val());
        }
    });
});

$("#messageText").on("input", function() {
    clearTimeout(typingTimeout);
    let recipient = $("#recipient").val();
    if (recipient) {
        $.post("messages_backend.php", { typing: true, recipient: recipient });
        typingTimeout = setTimeout(function() {
            $.post("messages_backend.php", { typing: false, recipient: recipient });
        }, 3000);
    }
});

function checkTypingStatus() {
    let recipient = $("#recipient").val();
    if (recipient) {
        $.get("messages_backend.php?check_typing=true&recipient=" + recipient, function(data) {
            let status = JSON.parse(data);
            if (status.typing) {
                $("#chatTitle").text(`Chat mit ${recipient} - tippt...`);
            } else {
                $("#chatTitle").text(`Chat mit ${recipient}`);
            }
        });
    }
}

// Emoji Picker hinzufügen
$("#emojiButton").click(function() {
    let emojiPicker = $("#emojiPicker");
    emojiPicker.toggle();
});

$(".emoji-option").click(function() {
    let emoji = $(this).text();
    let textArea = $("#messageText");
    textArea.val(textArea.val() + emoji);
});

$(document).ready(function() {
    loadUsers();
});

// Nachrichten automatisch alle 5 Sekunden abrufen
setInterval(function() {
    let currentUser = $("#recipient").val();
    if (currentUser) {
        refreshMessages(currentUser);
        checkTypingStatus();
    }
}, 5000);
