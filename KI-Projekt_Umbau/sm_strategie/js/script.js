document.addEventListener('DOMContentLoaded', function () {
    const startButton = document.getElementById('startSurveyButton');
    const questionWrapper = document.getElementById('questionWrapper');
    const responseWrapper = document.getElementById('responseWrapper');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    const prevButton = document.getElementById('prevButton');
    const nextButton = document.getElementById('nextButton');
    const submitButton = document.getElementById('submitButton');

    let currentQuestionIndex = 0;
    let questions = document.querySelectorAll('.question');
    let totalQuestions = questions.length;

    console.log("Lade Fragen...");
    console.log("Gefundene Fragen:", questions);
    console.log("Anzahl Fragen:", totalQuestions);

    if (startButton) {
        startButton.addEventListener('click', () => {
            questionWrapper.style.display = 'block';
            startButton.style.display = 'none';
            updateQuestionVisibility();
        });
    }

    function updateQuestionVisibility() {
        questions.forEach(q => q.style.display = 'none');
        if (questions[currentQuestionIndex]) {
            questions[currentQuestionIndex].style.display = 'block';
        }
        const progressPercentage = ((currentQuestionIndex + 1) / totalQuestions) * 100;
        progressBar.value = progressPercentage;
        progressText.textContent = `Frage ${currentQuestionIndex + 1} von ${totalQuestions}`;
        prevButton.style.display = currentQuestionIndex === 0 ? 'none' : 'inline-block';
        nextButton.style.display = currentQuestionIndex === totalQuestions - 1 ? 'none' : 'inline-block';
        submitButton.style.display = currentQuestionIndex === totalQuestions - 1 ? 'inline-block' : 'none';
    }

    function saveAnswer() {
        const currentQuestion = questions[currentQuestionIndex];
        const questionId = currentQuestion.getAttribute('data-question-id');
        let answer = '';
        let answerText = '';
        if (currentQuestion.querySelector('input[type="radio"]:checked')) {
            let selectedOption = currentQuestion.querySelector('input[type="radio"]:checked');
            answer = selectedOption.value;
            answerText = selectedOption.nextSibling.textContent.trim();
        } else if (currentQuestion.querySelector('input[type="checkbox"]:checked')) {
            let selectedCheckboxes = Array.from(currentQuestion.querySelectorAll('input[type="checkbox"]:checked'));
            answer = selectedCheckboxes.map(checkbox => checkbox.value);
            answerText = selectedCheckboxes.map(checkbox => checkbox.nextSibling.textContent.trim()).join(', ');
        } else if (currentQuestion.querySelector('textarea')) {
            answer = currentQuestion.querySelector('textarea').value.trim();
        } else if (currentQuestion.querySelector('input[type="text"]')) {
            answer = currentQuestion.querySelector('input[type="text"]').value.trim();
        }
        console.log(`Antwort für Frage ${questionId}: ${answerText} (ID: ${questionId})`);
        if (answer && questionId) {
            let storedAnswers = JSON.parse(sessionStorage.getItem('qa_data')) || {};
            storedAnswers[questionId] = {
                question: currentQuestion.querySelector('h2').textContent.trim(),
                answer: answer,
                answerText: answerText
            };
            sessionStorage.setItem('qa_data', JSON.stringify(storedAnswers));
            console.log("Antwort gespeichert:", storedAnswers);
        }
    }

    nextButton.addEventListener('click', () => {
        saveAnswer();
        currentQuestionIndex++;
        updateQuestionVisibility();
    });

    prevButton.addEventListener('click', () => {
        saveAnswer();
        currentQuestionIndex--;
        updateQuestionVisibility();
    });

    submitButton.addEventListener('click', (event) => {
        event.preventDefault();
        saveAnswer();
        let storedAnswers = sessionStorage.getItem("qa_data");
        if (!storedAnswers) {
            displayResponse("<p class='error-text'>Keine Antworten gespeichert!</p>");
            return;
        }
        storedAnswers = JSON.parse(storedAnswers);
        console.log("📤 Gesendete Daten an Backend:", storedAnswers);
        fetch("prozess_ki_anfrage.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ answers: storedAnswers })
        })
        .then(response => response.json())
        .then(data => {
            console.log("📥 Antwort von OpenAI:", data);
            if (data.error) {
                displayResponse(`<p class='error-text'>${data.error}</p>`);
            } else {
                displayResponse(`<div class='response-box'><h3>Antwort:</h3><p>${data.antwort}</p></div>`);
            }
        })
        .catch(error => {
            console.error("❌ Fehler beim API-Request:", error);
            displayResponse("<p class='error-text'>Fehler beim Laden der KI-Antwort.</p>");
        });
    });

    function displayResponse(content) {
        const responseWrapper = document.getElementById("responseWrapper");
        responseWrapper.innerHTML = content;
        responseWrapper.style.display = "block";
    }

    updateQuestionVisibility();
});