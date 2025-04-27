let currentQuestion = 1; // Die aktuelle Frage (Startwert)
const totalQuestions = 20; // Gesamtanzahl der Fragen

const progressBar = document.getElementById('progressBar');
const progressText = document.getElementById('progressText');

// Funktion, um den Fortschritt zu aktualisieren
function updateProgressBar() {
    const progress = (currentQuestion / totalQuestions) * 100;
    progressBar.value = progress;
    progressText.textContent = `Frage ${currentQuestion} von ${totalQuestions}`;
}

// Beispiel für das Navigieren durch die Fragen
document.getElementById('nextButton').addEventListener('click', function () {
    if (currentQuestion < totalQuestions) {
        currentQuestion++;
        updateProgressBar();
    }
});

document.getElementById('prevButton').addEventListener('click', function () {
    if (currentQuestion > 1) {
        currentQuestion--;
        updateProgressBar();
    }
});

// Initiale Aktualisierung des Fortschrittsbalkens
updateProgressBar();
