js_content = ""
function toggleHeaderMenu() {
    const nav = document.querySelector('.admin-nav-horizontal');
    const overlay = document.getElementById('burgerOverlay');
    nav.classList.toggle('open');
    overlay.classList.toggle('active');
  }

  function closeBurgerMenu() {
    document.querySelector('.admin-nav-horizontal').classList.remove('open');
    document.getElementById('burgerOverlay').classList.remove('active');
  }



async function updateMessageBadge() {
    try {
        const response = await fetch('get_unread_messages.php');
        const data = await response.json();
        const badge = document.getElementById('msgBadge');

        if (data.unreadCount > 0) {
            badge.textContent = data.unreadCount;
            badge.style.display = 'inline-block';
        } else {
            badge.style.display = 'none';
        }
    } catch (err) {
        console.error("Fehler beim Laden der Nachrichtenanzahl", err);
    }
}

window.addEventListener('DOMContentLoaded', updateMessageBadge);
""

function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const grip = document.getElementById('sidebarGrip');
    sidebar.classList.toggle('active');

    // Griff-Richtung ändern
    if (sidebar.classList.contains('active')) {
      grip.innerHTML = '<span>&#x276E;</span>'; // ❮
    } else {
      grip.innerHTML = '<span>&#x276F;</span>'; // ❯
    }
    // Klick außerhalb schließt
    document.addEventListener('click', function handleClickOutside(e) {
      if (!sidebar.contains(e.target) && !e.target.closest('.sidebar-handle')) {
        sidebar.classList.remove('active');
        handle.innerHTML = '❯';
        document.removeEventListener('click', handleClickOutside);
      }
    });
  }



function toggleMenu() {
    document.querySelector('.dropdown-menu').classList.toggle('show');
}