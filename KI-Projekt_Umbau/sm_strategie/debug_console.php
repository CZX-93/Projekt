
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug Console</title>
    <style>
        #debugBox {
            position: absolute;
            left: 0;
            top: 0; /* Setzt die Box an den oberen Rand */
            bottom: 0; /* Dehnt die Box bis zum unteren Rand */
            width: 100%;
            background: #222;
            color: #fff;
            padding: 10px;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.5);
            overflow-y: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #444;
        }

    </style>
</head>
<body>
    <div id="debugBox">
        <h3>Debug-Informationen</h3>
        <button id="updateDebugButton" onclick="updateDebug()">🔄 Aktualisieren</button>
        <table>
            <thead>
                <tr>
                    <th>Frage-ID</th>
                    <th>Frage</th>
                    <th>Antwort</th>
                    <th>Antwort-Text</th>
                </tr>
            </thead>
            <tbody id="debugContent">
                <tr><td colspan="4">Keine Daten vorhanden.</td></tr>
            </tbody>
        </table>
    </div>

    <script>
        function updateDebug() {
            let storedAnswers = JSON.parse(sessionStorage.getItem('qa_data')) || {};
            let debugContent = document.getElementById('debugContent');
            debugContent.innerHTML = '';
            if (Object.keys(storedAnswers).length === 0) {
                debugContent.innerHTML = '<tr><td colspan="4">Keine Daten vorhanden.</td></tr>';
                return;
            }
            for (let key in storedAnswers) {
                let row = `<tr>
                    <td>${key}</td>
                    <td>${storedAnswers[key].question}</td>
                    <td>${storedAnswers[key].answer}</td>
                    <td>${storedAnswers[key].answerText}</td>
                </tr>`;
                debugContent.innerHTML += row;
            }
        }

        // Funktion, die alle 5 Sekunden den "Aktualisieren"-Button klickt
        function autoClickUpdateButton() {
            setInterval(() => {
                document.getElementById('updateDebugButton').click();  // Simuliert den Button-Klick
            }, 5000);  // Alle 5 Sekunden
        }

        // Automatisches Klicken starten
        autoClickUpdateButton();
    </script>
</body>
</html>
