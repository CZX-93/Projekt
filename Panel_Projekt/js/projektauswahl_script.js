// Projekte laden und in der Tabelle anzeigen
async function loadProjects() {
    try {
        const response = await fetch('projektauswahl_backend.php');
        const projects = await response.json();

        const tableBody = document.querySelector('#projectsList');
        tableBody.innerHTML = '';

        projects.forEach(project => {
            const row = document.createElement('tr');

            // Name-Spalte
            const nameCell = document.createElement('td');
            nameCell.textContent = project.name;
            row.appendChild(nameCell);

            // Status-Spalte
            const statusCell = document.createElement('td');
            statusCell.textContent = project.is_active == 1 ? 'Aktiv' : 'Inaktiv';
            statusCell.style.color = project.is_active == 1 ? 'green' : 'red';
            row.appendChild(statusCell);

            // Aktiv-Spalte (Radio-Button)
            const activeCell = document.createElement('td');
            const checked = project.is_active == 1 ? 'checked' : ''; 
            activeCell.innerHTML = `<input type="radio" name="project_id" value="${project.id}" ${checked}>`;
            row.appendChild(activeCell);

            // Button zum Aktivieren des Projekts
            const activateButtonCell = document.createElement('td');
            const activateButton = document.createElement('button');
            activateButton.textContent = 'Aktivieren';
            activateButton.onclick = () => setActiveProject(project.id, project.name);
            activateButtonCell.appendChild(activateButton);
            row.appendChild(activateButtonCell);

            tableBody.appendChild(row);
        });
    } catch (error) {
        console.error('Fehler beim Laden der Projekte:', error);
    }
}

// Projekte beim Laden der Seite abrufen
window.onload = loadProjects;

// Funktion zum Aktivieren des Projekts
function setActiveProject(projectId, projectName) {
    if (confirm(`Möchten Sie das Projekt "${projectName}" als aktiv markieren?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'projektauswahl_backend.php';

        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'project_id';
        input.value = projectId;

        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }
}
