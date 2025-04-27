document.addEventListener("DOMContentLoaded", () => {
    let currentQuestionIndex = 0; // Index der aktuellen Frage
    const questions = document.querySelectorAll(".question"); // Alle Fragen aus dem DOM
    const totalQuestions = questions.length;

    const introSection = document.getElementById("introSection");
    const startSurveyButton = document.getElementById("startSurveyButton");
    const questionWrapper = document.getElementById("questionWrapper");
    const responseWrapper = document.getElementById("responseWrapper");
    const prevButton = document.getElementById("prevButton");
    const nextButton = document.getElementById("nextButton");
    const submitButton = document.getElementById("submitButton");
    const progressBar = document.getElementById("progressBar");
    const progressText = document.getElementById("progressText");
    const responseField = document.getElementById("response");

    // Buttons initial ausblenden
    prevButton.style.display = "none";
    nextButton.style.display = "none";
    submitButton.style.display = "none";

    // Umfrage starten
    startSurveyButton.addEventListener("click", () => {
        introSection.style.display = "none";
        questionWrapper.style.display = "flex";
        responseWrapper.style.display = "block";

        updateVisibility();
        updateProgress();
    });

    // Sichtbarkeit der Fragen steuern
    function updateVisibility() {
        questions.forEach((question, index) => {
            question.style.display = index === currentQuestionIndex ? "flex" : "none";
        });

        prevButton.style.display = currentQuestionIndex > 0 ? "inline-block" : "none";
        nextButton.style.display = currentQuestionIndex < totalQuestions - 1 ? "inline-block" : "none";
        submitButton.style.display = currentQuestionIndex === totalQuestions - 1 ? "inline-block" : "none";
    }

    // Fortschrittsanzeige aktualisieren
    function updateProgress() {
        const progressValue = ((currentQuestionIndex + 1) / totalQuestions) * 100;
        progressBar.value = progressValue;
        progressText.textContent = `Frage ${currentQuestionIndex + 1} von ${totalQuestions}`;
    }

    // Antwort speichern
    function saveAnswer() {
        const currentQuestion = questions[currentQuestionIndex];
        if (!currentQuestion) return;

        const questionId = currentQuestion.id; // z.B. question0
        const questionTextElement = currentQuestion.querySelector("h2"); // Frage-Text in <h2>

        // Prüfen, ob die Fragestellung existiert
        if (!questionTextElement) {
            console.warn(`Warnung: Keine Frage gefunden für ID ${questionId}`);
            return;
        }

        const questionText = questionTextElement.textContent;
        const inputs = currentQuestion.querySelectorAll("input");
        const answers = [];

        inputs.forEach((input) => {
            if ((input.type === "checkbox" || input.type === "radio") && input.checked) {
                answers.push(input.value);
            }
        });

        // Debugging: Ausgabe der Daten
        console.log("Frage:", questionText, "Antworten:", answers);

        if (answers.length > 0) {
            fetch("xml.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    questionId: questionId,
                    questionText: questionText,
                    answers: answers,
                }),
            }).catch((error) => console.error("Fehler beim Speichern der Antwort:", error));
        }
    }

    // Navigation: Vorherige Frage
    prevButton.addEventListener("click", () => {
        saveAnswer();
        if (currentQuestionIndex > 0) {
            currentQuestionIndex--;
            updateVisibility();
            updateProgress();
        }
    });

    // Navigation: Nächste Frage
    nextButton.addEventListener("click", () => {
        saveAnswer();
        if (currentQuestionIndex < totalQuestions - 1) {
            currentQuestionIndex++;
            updateVisibility();
            updateProgress();
        }
    });

    // Umfrage abschicken
    submitButton.addEventListener("click", () => {
        saveAnswer();
        responseField.value = "Antwort wird verarbeitet...";

        fetch("ai_integration.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ completed: true }),
        })
            .then((response) => response.text())
            .then((result) => {
                responseField.value = result;
            })
            .catch((error) => {
                console.error("Fehler beim Senden der Antworten:", error);
            });
    });
});


