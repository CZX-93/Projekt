document.addEventListener('DOMContentLoaded', function () {
    let currentQuestionIndex = 0;
    const questions = document.querySelectorAll('.question');
    const nextButton = document.getElementById('nextButton');
    const submitButton = document.getElementById('submitButton');
    const resultBox = document.getElementById('resultBox');
    const responseBox = document.getElementById('responseBox');

    // Zeige die erste Frage
    function showQuestion(index) {
        questions.forEach((question, i) => {
            question.style.display = i === index ? 'block' : 'none';
        });
    }

    // Wenn der "Next"-Button geklickt wird
    nextButton.addEventListener('click', function () {
        const answer = document.getElementById(`answer${currentQuestionIndex + 1}`).value;
        if (answer) {
            // Antwort in der Session speichern
            if (!sessionStorage.getItem('questions_answers')) {
                sessionStorage.setItem('questions_answers', JSON.stringify([]));
            }
            const answers = JSON.parse(sessionStorage.getItem('questions_answers'));
            answers[currentQuestionIndex] = { question: questions[currentQuestionIndex].querySelector('h2').innerText, answer: answer };
            sessionStorage.setItem('questions_answers', JSON.stringify(answers));
        }

        // Zur nächsten Frage gehen
        currentQuestionIndex++;
        if (currentQuestionIndex >= questions.length) {
            currentQuestionIndex = questions.length - 1;
            nextButton.disabled = true;
            submitButton.disabled = false;
        }
        showQuestion(currentQuestionIndex);
    });

    // Wenn der "Submit"-Button geklickt wird
    submitButton.addEventListener('click', function () {
        const answers = JSON.parse(sessionStorage.getItem('questions_answers'));

        // Sende die gesammelten Fragen und Antworten an das Backend
        fetch('backend.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ questions_answers: answers })
        })
        .then(response => response.json())
        .then(data => {
            // Antwort der KI im Response Box anzeigen
            responseBox.textContent = data.response;
            resultBox.style.display = 'block';
        })
        .catch(error => console.error('Fehler:', error));
    });

    // Initiale Frage anzeigen
    showQuestion(currentQuestionIndex);
});
