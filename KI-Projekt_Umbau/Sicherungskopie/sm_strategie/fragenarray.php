<?php


// Definiere die Fragen als Array
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
        'text' => 'Aktuell genutze Social Media Plattformen (Mehrfachauswahl)',
        'type' => 'checkbox',
        'options' => [
            'facebook' => 'Facebook',
            'instagram' => 'Instagram',
            'x' => 'X',
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
            'under_500' => 'Unter 500 € pro Monat',
            '500_1000' => '500 € bis 1.000 € pro Monat',
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
header('Content-Type: application/json');
echo json_encode($questions);

