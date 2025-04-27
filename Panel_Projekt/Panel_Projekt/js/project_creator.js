let questionCount = 1; // Start bei Frage 1

// Funktion zum Hinzufügen einer Frage
function addQuestion() {
    const questionsContainer = document.getElementById('questionsContainer');
    const newQuestion = document.createElement('div');
    newQuestion.classList.add('mb-3');
    newQuestion.id = 'question' + questionCount;

    newQuestion.innerHTML = `
        <label for="questions[${questionCount}][question]" class="form-label">Frage ${questionCount + 1}</label>
        <input type="text" class="form-control" id="questions[${questionCount}][question]" name="questions[${questionCount}][question]" required>
        
        <label for="questions[${questionCount}][type]" class="mt-2">Typ der Frage</label>
        <select class="form-select" id="questions[${questionCount}][type]" name="questions[${questionCount}][type]" required>
            <option value="text">Text</option>
            <option value="multiple">Multiple Choice</option>
            <option value="radio">Radio</option>
        </select>

        <div class="mt-3">
            <label class="form-label">Antworten</label>
            <div class="answers" id="answersForQuestion${questionCount}">
                <input type="text" class="form-control mb-2" id="questions[${questionCount}][answers][0]" name="questions[${questionCount}][answers][0]" placeholder="Antwort hinzufügen" required>
            </div>
            <button type="button" class="btn btn-outline-secondary mt-2" onclick="addAnswer(${questionCount})">Weitere Antwort hinzufügen</button>
            <button type="button" class="btn btn-outline-danger mt-2" onclick="removeQuestion(${questionCount})">Frage entfernen</button>
        </div>
    `;
    questionsContainer.appendChild(newQuestion);
    questionCount++;
}

// Funktion zum Hinzufügen einer Antwort
function addAnswer(questionIndex) {
    const answersContainer = document.getElementById(`answersForQuestion${questionIndex}`);
    const answerCount = answersContainer.children.length;
    const newAnswer = document.createElement('input');
    newAnswer.type = 'text';
    newAnswer.classList.add('form-control', 'mb-2');
    newAnswer.id = `questions[${questionIndex}][answers][${answerCount}]`;
    newAnswer.name = `questions[${questionIndex}][answers][${answerCount}]`;
    newAnswer.placeholder = 'Antwort hinzufügen';
    answersContainer.appendChild(newAnswer);
}

// Funktion zum Entfernen einer Frage
function removeQuestion(questionIndex) {
    const question = document.getElementById('question' + questionIndex);
    question.remove();
}

// Funktion zum Überprüfen, ob entweder der Assistant Key oder der neue Assistant Key ausgefüllt ist
function validateAssistantKey() {
    const assistantKey = document.getElementById('assistantKey').value;
    const newAssistantKey = document.getElementById('newAssistantKey').value;

    if (!assistantKey && !newAssistantKey) {
        alert("Bitte geben Sie entweder einen bestehenden Assistant Key oder einen neuen Assistant Key ein.");
        return false;
    }
    return true;
}

// Funktion zum Überprüfen vor dem Absenden des Formulars
document.querySelector('form').onsubmit = function(event) {
    if (!validateAssistantKey()) {
        event.preventDefault();  // Verhindert das Absenden des Formulars
    }
};
