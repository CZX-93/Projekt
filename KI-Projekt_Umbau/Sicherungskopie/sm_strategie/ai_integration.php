<?php
session_start();

// Pfad zur XML-Datei
$xmlDirectory = __DIR__ . '/xml_archives/';
$sessionId = session_id();
$xmlFilePath = $xmlDirectory . "survey_{$sessionId}.xml";

// Wenn die XML-Datei existiert
if (file_exists($xmlFilePath)) {
    $xml = simplexml_load_file($xmlFilePath);
    $surveyString = "";

    // Extrahiere Fragen und Antworten
    foreach ($xml->question as $question) {
        $questionText = (string) $question->text;
        $answers = (string) $question->answer;

        // Kombiniere Frage und Antwort
        $surveyString .= "Frage: $questionText\nAntwort(en): $answers\n\n";
    }

    // Debugging: Ausgabe des generierten Strings
    echo "<pre>"; // Formatierte Ausgabe
    echo "Generierter String für ChatGPT:\n";
    echo $surveyString;
    echo "</pre>";


    // ChatGPT API-Aufruf (beispielhaft)
    $apiKey = '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'; // Ersetze dies mit deinem echten API-Schlüssel
    $url = 'https://api.openai.com/v1/chat/completions';

    $data = [
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            ['role' => 'system', 'content' => 'Du bist ein Social-media-marketing Profi.'],
            ['role' => 'system', 'content' => 'Du wirst dem kunden eine fundierte und professionelle Marketingstrategie basierend auf den antworten zu den Fragen liefern'],
            ['role' => 'system', 'content' => 'Du gibst dem Kunden bitte einen zusammenhängenden und gut strukturierten Text, ohne die Fragen und Antworten dem Kunden nochmal aufzulisten und ohne irgendwelche Formtags zu benutzen'],
            ['role' => 'system', 'content' => 'Starte deine Antwort immer mit "Antwort:"'],
            ['role' => 'user', 'content' => $surveyString]
        ]
    ];

    $options = [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey,
        ],
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
    ];

    $ch = curl_init();
    curl_setopt_array($ch, $options);
    $response = curl_exec($ch);
    curl_close($ch);

    $responseData = json_decode($response, true);
    $chatResponse = $responseData['choices'][0]['message']['content'] ?? 'Keine Antwort erhalten';

    // Hier filtern wir nur die lösungsorientierte Antwort von ChatGPT
    // Zum Beispiel, falls die Antwort mit "Antwort:" beginnt, können wir diesen Teil extrahieren.
    $answerOnly = trim(preg_replace("/^.*?Frage: /s", '', $chatResponse));
    // Beispiel: HTML formatierte Antwort (optional)
    $answerOnly = nl2br(htmlspecialchars($answerOnly));

    // Antwort von ChatGPT anzeigen
    echo $answerOnly; // Nur die Lösung wird hier zurückgegeben
} else {
    echo "Keine Umfrageantworten gefunden.";
}
?>
