document.addEventListener('DOMContentLoaded', function () {
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    const nextButton = document.getElementById('nextButton');
    const prevButton = document.getElementById('prevButton');

    let currentQuestion = 1; // Startwert der Frage
    const totalQuestions = surveyData.questions.length; // Dynamische Gesamtanzahl der Fragen aus surveyData

    // Funktion, um den Fortschritt zu aktualisieren
    function updateProgressBar() {
        const progress = (currentQuestion / totalQuestions) * 100;
        progressBar.value = progress;
        progressText.textContent = `Frage ${currentQuestion} von ${totalQuestions}`;
    }

    // Funktion, um zur nächsten Frage zu navigieren
    nextButton.addEventListener('click', function () {
        if (currentQuestion < totalQuestions) {
            currentQuestion++;
            loadQuestion(currentQuestion - 1);  // Indizes sind 0-basiert, daher -1
            updateProgressBar();
        }
    });

    // Funktion, um zur vorherigen Frage zu navigieren
    prevButton.addEventListener('click', function () {
        if (currentQuestion > 1) {
            currentQuestion--;
            loadQuestion(currentQuestion - 1);
            updateProgressBar();
        }
    });

    // Funktion, um die Frage zu laden
    function loadQuestion(index) {
        const question = surveyData.questions[index];
        const questionElement = document.createElement('div');
        questionElement.innerHTML = `<h2>${index + 1}. ${question.frage}</h2>`;

        let answerHtml = '';
        question.antworten.forEach((answer, i) => {
            answerHtml += `<div><input type="radio" name="answer" id="answer_${i}" value="${answer.id}"> ${answer.antwort}</div>`;
        });

        const questionForm = document.getElementById('questionForm');
        questionForm.innerHTML = questionElement.outerHTML + answerHtml;

        updateProgressBar(); // Fortschritt anzeigen
    }

    // Initiale Frage laden
    loadQuestion(currentQuestion - 1);
});
