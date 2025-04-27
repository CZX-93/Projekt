function toggleEdit(field) {
    const display = document.getElementById(`${field}-display`);
    const input = document.getElementById(`${field}-input`);
  
    if (display.style.display === 'none') {
      display.style.display = 'inline';
      input.style.display = 'none';
    } else {
      display.style.display = 'none';
      input.style.display = 'inline';
      input.focus();
    }
  }
  
  function saveProfile() {
    ['firstname', 'lastname', 'alias', 'birthdate'].forEach(field => {
      const display = document.getElementById(`${field}-display`);
      const input = document.getElementById(`${field}-input`);
      
      display.textContent = input.value;
      display.style.display = 'inline';
      input.style.display = 'none';
    });
  
    alert("Profil gespeichert!");
  }
  
// Globale Variable zur Nachverfolgung des aktuellen Edit-Felds
let currentEditField = null;

function toggleEdit(field) {
  const display = document.getElementById(`${field}-display`);
  const input = document.getElementById(`${field}-input`);

  // Toggle Logik
  if (display.style.display !== 'none') {
    display.style.display = 'none';
    input.style.display = 'inline';
    input.focus();
    currentEditField = field;
  }

  // Event Listener einmalig hinzufügen
  document.addEventListener('click', handleOutsideClick);
}

function handleOutsideClick(event) {
  if (!currentEditField) return;

  const input = document.getElementById(`${currentEditField}-input`);
  const icon = input.nextElementSibling;
  const display = document.getElementById(`${currentEditField}-display`);

  // Wenn der Klick NICHT auf das Eingabefeld oder das Icon geht
  if (!input.contains(event.target) && !icon.contains(event.target)) {
    display.textContent = input.value;
    display.style.display = 'inline';
    input.style.display = 'none';
    currentEditField = null;

    // Listener wieder entfernen
    document.removeEventListener('click', handleOutsideClick);
  }
}
