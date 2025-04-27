document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.project-row').forEach(row => {
        row.addEventListener('click', function () {
            const projectId = this.dataset.projectId;
            toggleProjectDetails(projectId);
        });
    });
});

function toggleProjectDetails(projectId) {
    let detailContainer = document.getElementById(`projectDetails${projectId}`);
    if (detailContainer) {
        detailContainer.classList.toggle('hidden');
    } else {
        loadProjectDetails(projectId);
    }
}

async function loadProjectDetails(projectId) {
    try {
        const response = await fetch(`projektauswahl_backend_api.php?action=get_details&project_id=${projectId}`);
        const data = await response.json();

        const container = document.createElement('div');
        container.id = `projectDetails${projectId}`;
        container.classList.add('project-details', 'visible');

        let content = `<h3>Details zu Projekt: ${data.name}</h3>`;
        content += '<div class="question-list">';

        data.questions.forEach((question) => {
            content += `<div class="question-item">
                            <h4>Frage: <input type='text' value='${question.text}' onchange='updateQuestion(${question.id}, this.value)'></h4>
                            <div class='answers'>`;

            question.answers.forEach((answer) => {
                content += `<div class='answer-item'>
                                <input type='text' value='${answer.text}' onchange='updateAnswer(${answer.id}, this.value)'>
                                <button onclick='deleteAnswer(${answer.id})'>❌</button>
                            </div>`;
            });

            content += `<button onclick='addAnswer(${question.id})'>+ Antwort hinzufügen</button>
                        <button onclick='deleteQuestion(${question.id})'>❌ Frage löschen</button>
                        </div>
                        </div>`;
        });

        content += `<button onclick='addQuestion(${projectId})'>+ Neue Frage</button>`;
        content += '</div>';

        container.innerHTML = content;
        document.getElementById('projectsList').appendChild(container);
    } catch (error) {
        console.error('Fehler beim Laden der Projektdetails:', error);
    }
}

function updateQuestion(questionId, newText) {
    fetch('projektauswahl_backend_api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=update_question&question_id=${questionId}&text=${encodeURIComponent(newText)}`
    }).then(response => response.json()).then(data => {
        console.log('Frage aktualisiert:', data);
    });
}

function deleteQuestion(questionId) {
    if (!confirm('Möchtest du diese Frage wirklich löschen?')) return;
    fetch('projektauswahl_backend_api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=delete_question&question_id=${questionId}`
    }).then(response => response.json()).then(data => {
        console.log('Frage gelöscht:', data);
        location.reload();
    });
}

function addQuestion(projectId) {
    const questionText = prompt('Neue Frage eingeben:');
    if (!questionText) return;
    fetch('projektauswahl_backend_api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=add_question&project_id=${projectId}&text=${encodeURIComponent(questionText)}`
    }).then(response => response.json()).then(data => {
        console.log('Neue Frage hinzugefügt:', data);
        location.reload();
    });
}

function updateAnswer(answerId, newText) {
    fetch('projektauswahl_backend_api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=update_answer&answer_id=${answerId}&text=${encodeURIComponent(newText)}`
    }).then(response => response.json()).then(data => {
        console.log('Antwort aktualisiert:', data);
    });
}

function deleteAnswer(answerId) {
    if (!confirm('Möchtest du diese Antwort wirklich löschen?')) return;
    fetch('projektauswahl_backend_api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=delete_answer&answer_id=${answerId}`
    }).then(response => response.json()).then(data => {
        console.log('Antwort gelöscht:', data);
        location.reload();
    });
}

function addAnswer(questionId) {
    const answerText = prompt('Neue Antwort eingeben:');
    if (!answerText) return;
    fetch('projektauswahl_backend_api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=add_answer&question_id=${questionId}&text=${encodeURIComponent(answerText)}`
    }).then(response => response.json()).then(data => {
        console.log('Neue Antwort hinzugefügt:', data);
        location.reload();
    });
}
