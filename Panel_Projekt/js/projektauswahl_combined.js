document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.project-row').forEach(row => {
        row.addEventListener('click', function () {
            const projectId = this.dataset.projectId;
            toggleProjectDetails(projectId);
        });
    });
});

function toggleProjectDetails(projectId) {
    const modal = document.getElementById("questionModal");
    modal.classList.remove("hidden");
    modal.classList.add("visible");

    const wrapper = document.getElementById("modalContentWrapper");
    wrapper.innerHTML = '<p>Lade Projektdetails...</p>';
    document.getElementById("questionModal").dataset.projectId = projectId;


    loadProjectDetails(projectId, wrapper);
}

function closeModal() {
    const modal = document.getElementById("questionModal");
    modal.classList.add("hidden");
    modal.classList.remove("visible");
}

async function loadProjectDetails(projectId, targetWrapper = null) {
    try {
        const response = await fetch(`projektauswahl_backend_api.php?action=get_details&project_id=${projectId}`);
        const text = await response.text();
        const data = JSON.parse(text);

        if (!data.questions || !Array.isArray(data.questions)) {
            console.warn("Keine gültigen Fragen erhalten:", data);
            alert("Fehler beim Laden der Projektdetails: " + (data.error || "Unbekannter Fehler"));
            return;
        }

        const questionList = targetWrapper || document.getElementById(`questionList${projectId}`);
        questionList.innerHTML = '';

        const gridContainer = document.createElement('div');
        gridContainer.classList.add('grid-container');
        gridContainer.style.display = 'grid';
        gridContainer.style.gridTemplateColumns = 'repeat(3, 1fr)';
        gridContainer.style.gap = '16px';

        data.questions.forEach((question, index) => {
            let questionHTML = `<div class="question-item">
                <h4>Frage ${index + 1}: <input type='text' value='${question.text}' onchange='updateQuestion(${question.id}, this.value)'></h4>
                <label>Typ: </label>
                <select onchange='updateQuestionType(${question.id}, this.value)'>
                    <option value="text" ${question.type === 'text' ? 'selected' : ''}>Text</option>
                    <option value="radio" ${question.type === 'radio' ? 'selected' : ''}>Radio</option>
                    <option value="checkbox" ${question.type === 'checkbox' ? 'selected' : ''}>Checkbox</option>
                </select>
                <div class='answers'>`;

            question.answers.forEach((answer) => {
                questionHTML += `<div class='answer-item'>
                    <input type='text' value='${answer.text}' onchange='updateAnswer(${answer.id}, this.value)'>
                    <button class='delete' onclick='deleteAnswer(${answer.id})'>❌</button>
                </div>`;
            });

            questionHTML += `<button onclick='addAnswer(${question.id})'>+ Antwort hinzufügen</button>
                <button class='delete' onclick='deleteQuestion(${question.id})'>❌ Frage löschen</button>
                </div>
            </div>`;

            const questionDiv = document.createElement('div');
            questionDiv.classList.add('question-item');
            questionDiv.setAttribute('data-question-id', question.id);
            questionDiv.innerHTML = questionHTML;
            gridContainer.appendChild(questionDiv);
        });

        const addBtnWrapper = document.createElement('div');
        addBtnWrapper.style.gridColumn = 'span 3';
        addBtnWrapper.innerHTML = `<button onclick='addNewQuestion(${projectId})'>➕ Weitere Frage hinzufügen</button>`;

        questionList.appendChild(gridContainer);
        questionList.appendChild(addBtnWrapper);

    } catch (error) {
        console.error('Fehler beim Laden der Projektdetails:', error);
        alert("Fehler beim Verarbeiten der Antwort: " + error.message);
    }
}

function addNewQuestion(projectId) {
    const frage = prompt("Text der neuen Frage eingeben:");
    if (!frage) return;

    const type = prompt("Fragetyp angeben (text, radio, checkbox):", "text");
    if (!type || !['text', 'radio', 'checkbox'].includes(type)) {
        alert("Ungültiger Typ. Gültige Typen: text, radio, checkbox");
        return;
    }

    fetch('projektauswahl_backend_api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=add_question&project_id=${projectId}&text=${encodeURIComponent(frage)}&type=${type}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Neue Frage dynamisch anhängen
            loadProjectDetails(projectId, document.getElementById("modalContentWrapper"));
        } else {
            alert("Fehler beim Hinzufügen der Frage: " + (data.error || "Unbekannter Fehler"));
        }
    })
    .catch(error => {
        console.error("Fehler beim Hinzufügen der Frage:", error);
        alert("Netzwerkfehler");
    });
}


function updateQuestionType(questionId, newType) {
    fetch('projektauswahl_backend_api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=update_question_type&question_id=${questionId}&type=${newType}`
    });
}

function updateQuestion(questionId, newText) {
    fetch('projektauswahl_backend_api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=update_question&question_id=${questionId}&text=${encodeURIComponent(newText)}`
    });
}

function deleteQuestion(questionId) {
    if (!confirm('Möchtest du diese Frage wirklich löschen?')) return;

    fetch('projektauswahl_backend_api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=delete_question&question_id=${questionId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const questionElement = document.querySelector(`[data-question-id="${questionId}"]`);
            if (questionElement) questionElement.remove();
        } else {
            alert('Fehler beim Löschen: ' + (data.error || 'Unbekannter Fehler'));
        }
    });
}


function updateAnswer(answerId, newText) {
    fetch('projektauswahl_backend_api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=update_answer&answer_id=${answerId}&text=${encodeURIComponent(newText)}`
    });
}

function deleteAnswer(answerId) {
    if (!confirm('Möchtest du diese Antwort wirklich löschen?')) return;
    fetch('projektauswahl_backend_api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=delete_answer&answer_id=${answerId}`
    }).then(() => {
        loadProjectDetails(projectId, document.getElementById("modalContentWrapper"));
    });
}

function addAnswer(questionId) {
    const answerText = prompt('Neue Antwort eingeben:');
    if (!answerText) return;
    fetch('projektauswahl_backend_api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=add_answer&question_id=${questionId}&text=${encodeURIComponent(answerText)}`
    }).then(() => {
        loadProjectDetails(projectId, document.getElementById("modalContentWrapper"));
    });
}

// Modal bei Klick außerhalb schließen
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("questionModal");
    const modalContent = document.querySelector(".modal-content");

    modal.addEventListener("click", function (e) {
        // Wenn auf die Overlay-Fläche geklickt wurde (nicht auf das Modal selbst)
        if (!modalContent.contains(e.target)) {
            closeModal();
        }
    });
});
