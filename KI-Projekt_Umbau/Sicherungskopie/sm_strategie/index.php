<?php
// _____________Fragenarray_________________
$questions = [
    [
        'id' => 'goals',
        'text' => 'Unternehmensziele (Mehrfachauswahl)',
        'type' => 'checkbox',
        'options' => [
            'brand_awareness' => 'Markenbekanntheit steigern',
            'sales' => 'Verkäufe fördern',
            'customer_loyalty' => 'Kundenbindung erhöhen',
            'lead_generation' => 'Lead-Generierung verbessern',
            'customer_service' => 'Kundenservice verbessern'
        ]
    ],
    [
        'id' => 'target_audience',
        'text' => 'Zielgruppe (Einfachauswahl)',
        'type' => 'radio',
        'options' => [
            'teens' => 'Jugendliche (13-17 Jahre)',
            'young_adults' => 'Junge Erwachsene (18-24 Jahre)',
            'adults' => 'Erwachsene (25-34 Jahre)',
            'middle_aged' => 'Mittleres Alter (35-54 Jahre)',
            'older_adults' => 'Ältere Erwachsene (55+ Jahre)'
        ]
    ],
    [
        'id' => 'industry_competition',
        'text' => 'Branche und Wettbewerb (Einfachauswahl)',
        'type' => 'radio',
        'options' => [
            'high' => 'Sehr wettbewerbsintensiv',
            'moderate' => 'Mäßig wettbewerbsintensiv',
            'low' => 'Wenig wettbewerbsintensiv'
        ]
    ],
    [
        'id' => 'previous_activities',
        'text' => 'Bisherige Aktivitäten (Mehrfachauswahl)',
        'type' => 'checkbox',
        'options' => [
            'facebook' => 'Facebook',
            'instagram' => 'Instagram',
            'twitter' => 'Twitter',
            'linkedin' => 'LinkedIn',
            'tiktok' => 'TikTok',
            'youtube' => 'YouTube'
        ]
    ],
    [
        'id' => 'content_preferences',
        'text' => 'Content-Vorlieben (Mehrfachauswahl)',
        'type' => 'checkbox',
        'options' => [
            'videos' => 'Videos',
            'articles' => 'Artikel',
            'images' => 'Bilder',
            'tutorials' => 'Tutorials',
            'infographics' => 'Infografiken',
            'podcasts' => 'Podcasts'
        ]
    ],
    [
        'id' => 'resources',
        'text' => 'Ressourcen (Einfachauswahl)',
        'type' => 'radio',
        'options' => [
            'under_500' => 'Unter $500 pro Monat',
            '500_1000' => '$500 bis $1.000 pro Monat',
            '1000_5000' => '$1.000 bis $5.000 pro Monat',
            'over_5000' => 'Über $5.000 pro Monat'
        ]
    ],
    [
        'id' => 'time_commitment',
        'text' => 'Zeitlicher eigener Einsatz pro Woche (Einfachauswahl)',
        'type' => 'radio',
        'options' => [
            'less_5' => 'Weniger als 5 Stunden',
            '5_10' => '5 bis 10 Stunden',
            '10_20' => '10 bis 20 Stunden',
            'over_20' => 'Mehr als 20 Stunden'
        ]
    ],
    [
        'id' => 'customer_interaction',
        'text' => 'Kundeninteraktion (Einfachauswahl)',
        'type' => 'radio',
        'options' => [
            'very_active' => 'Sehr aktiv',
            'moderate_active' => 'Moderat aktiv',
            'less_active' => 'Wenig aktiv',
            'none' => 'Nicht vorhanden'
        ]
    ],
    [
        'id' => 'sales_channels',
        'text' => 'Verkaufskanäle (Einfachauswahl)',
        'type' => 'radio',
        'options' => [
            'direct_sales' => 'Direkter Verkauf',
            'lead_generation' => 'Lead-Generierung',
            'both' => 'Beides',
            'none' => 'Keines von beidem'
        ]
    ],
    [
        'id' => 'customer_feedback',
        'text' => 'Kundenfeedback (Mehrfachauswahl)',
        'type' => 'checkbox',
        'options' => [
            'direct_social_media' => 'Direktes Feedback über Social Media',
            'surveys' => 'Umfragen',
            'review_platforms' => 'Bewertungsplattformen',
            'personal_feedback' => 'Persönliches Feedback',
            'no_systematic' => 'Keine systematische Erfassung'
        ]
    ],
    [
        'id' => 'crisis_management',
        'text' => 'Krisenmanagement (Einfachauswahl)',
        'type' => 'radio',
        'options' => [
            'experienced' => 'Erfahren im Umgang mit Krisen',
            'some_experience' => 'Einige Erfahrungen',
            'no_experience' => 'Keine Erfahrungen'
        ]
    ],
    [
        'id' => 'brand_consistency',
        'text' => 'Markenkonsistenz (Einfachauswahl)',
        'type' => 'radio',
        'options' => [
            'very_important' => 'Sehr wichtig',
            'important' => 'Wichtig',
            'less_important' => 'Weniger wichtig',
            'unimportant' => 'Unwichtig'
        ]
    ],
    [
        'id' => 'tone',
        'text' => 'Sprache und Ton (Einfachauswahl)',
        'type' => 'radio',
        'options' => [
            'formal' => 'Formal',
            'informal' => 'Informell',
            'humorous' => 'Humorvoll',
            'serious' => 'Ernst',
            'inspiring' => 'Inspirierend'
        ]
    ],
    [
        'id' => 'influencer_involvement',
        'text' => 'Einbindung von Influencern (Einfachauswahl)',
        'type' => 'radio',
        'options' => [
            'regular' => 'Ja, regelmäßig',
            'occasional' => 'Gelegentlich',
            'planned' => 'Nein, aber geplant',
            'not_planned' => 'Nein, nicht geplant'
        ]
    ],
    [
        'id' => 'campaigns',
        'text' => 'Werbeaktionen und Kampagnen (Mehrfachauswahl)',
        'type' => 'checkbox',
        'options' => [
            'discounts' => 'Rabatte und Sonderangebote',
            'contests' => 'Gewinnspiele',
            'product_demos' => 'Produktdemonstrationen',
            'partnerships' => 'Partnerschaften',
            'none' => 'Keine'
        ]
    ],
    [
        'id' => 'seasonality',
        'text' => 'Saisonabhängigkeit (Einfachauswahl)',
        'type' => 'radio',
        'options' => [
            'very_strong' => 'Ja, sehr stark',
            'manageable' => 'Ja, aber überschaubar',
            'none' => 'Nein'
        ]
    ],
    [
        'id' => 'compliance',
        'text' => 'Datenschutz und Compliance (Einfachauswahl)',
        'type' => 'radio',
        'options' => [
            'high' => 'Hohe Anforderungen',
            'moderate' => 'Moderate Anforderungen',
            'low' => 'Geringe Anforderungen'
        ]
    ],
    [
        'id' => 'tools',
        'text' => 'Technologie und Tools (Mehrfachauswahl)',
        'type' => 'checkbox',
        'options' => [
            'social_media_management' => 'Social-Media-Management-Tools',
            'analytics_tools' => 'Analytik-Tools',
            'automation_tools' => 'Automatisierungs-Tools',
            'no_special_tools' => 'Keine speziellen Tools'
        ]
    ],
    [
        'id' => 'training',
        'text' => 'Ausbildung und Fortbildung (Einfachauswahl)',
        'type' => 'radio',
        'options' => [
            'regular' => 'Regelmäßige Schulungen',
            'occasional' => 'Gelegentliche Schulungen',
            'none' => 'Keine Schulungen'
        ]
    ],
    [
        'id' => 'future_vision',
        'text' => 'Zukunftsvision (Einfachauswahl)',
        'type' => 'radio',
        'options' => [
            'expansion' => 'Starke Expansion auf neuen Plattformen',
            'deepening_presence' => 'Vertiefung der bestehenden Präsenz',
            'experimenting_formats' => 'Experimentieren mit neuen Formaten',
            'stabilization' => 'Stabilisierung der aktuellen Situation'
        ]
    ]

];
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fragebogen</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Header-Bereich -->
    <header>
        <div class="logo">
            <img src="img/WEBAN-Logo.svg" alt="WEBAN Logo">
        <h1>Mehr <span class="highlight">Erfolg</span> für dein Unternehmen</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nonummy nibh...</p>
    </header>

    <main>
        <!-- Einleitungsbereich -->
        <section id="introSection">
            <div class="intro-text">
                <p>Willkommen zu unserer Umfrage! Ihre Antworten helfen uns, wertvolle Einblicke zu gewinnen. Bitte nehmen Sie sich einen Moment Zeit, um teilzunehmen.</p>
                <button id="startSurveyButton">Umfrage starten</button>
            </div>
        </section>

        <!-- Fragebereich -->

        <section class="question-wrapper" id="questionWrapper" style="display: none;">
            <div class="question-container">
                <form id="questionForm" method="POST">

                    <?php
                    // ____________Schleifen für Fragen_____________
                    foreach ($questions as $i => $q) {
                        echo "<div class='question' id='question" . $i . "'>";
                        echo "<h2>" . ($i + 1) . ". " . $q['text'] . "</h2>";

                        foreach ($q['options'] as $value => $text) {
                            $inputType = $q['type'] === 'checkbox' ? 'checkbox' : 'radio';
                            $name = $q['type'] === 'checkbox' ? $q['id'] . '[]' : $q['id'];

                            echo "<label>";
                            echo "<input type='$inputType' name='$name' value='$value'> $text";
                            echo "</label>";
                        }

                        echo "</div>";
                    }
                    ?>
                </form>
            </div>

            <!-- Navigationsbereich -->
            <div class="navigation">
                <button id="prevButton" style="display: none;">&lt; Zurück</button>
                <button id="nextButton" style="display: none;">Weiter &gt;</button>
                <button id="submitButton" style="display: none;">Abschicken</button>
            </div>

            <!-- Fortschrittsanzeige -->
            <div class="progress-container">
                <progress id="progressBar" value="0" max="100"></progress>
                <div id="progressTextContainer">
                    <p id="progressText">Frage 1 von <?php echo count($questions); ?></p>
                </div>
            </div>
        </section>


        <!-- Antwortbereich -->
        <section class="response-wrapper" id="responseWrapper" style="display: none;">
            <textarea id="response" placeholder="Antwort von ChatGPT"></textarea>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <p>&copy; 2024 WEBAN UG / B.Wollny. Alle Rechte vorbehalten.</p>
            <nav>
                <ul>
                    <li><a href="impressum.html">Impressum</a></li>
                    <li><a href="datenschutz.html">Datenschutz</a></li>
                    <li><a href="agb.html">AGB</a></li>
                </ul>
            </nav>
        </div>
    </footer>

    <!-- JavaScript Verlinkungen -->
    <script src="js/script.js"></script>
    <script src="js/progressbar.js"></script>
</body>
</html>