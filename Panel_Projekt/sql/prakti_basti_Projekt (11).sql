-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 20. Mrz 2025 um 14:53
-- Server-Version: 10.5.23-MariaDB-0+deb11u1
-- PHP-Version: 7.4.33

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `prakti_basti_Projekt`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `antworten`
--

DROP TABLE IF EXISTS `antworten`;
CREATE TABLE IF NOT EXISTS `antworten` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `antwort` text DEFAULT NULL,
  `erstellt_am` timestamp NOT NULL DEFAULT current_timestamp(),
  `erstellt_von` varchar(255) DEFAULT NULL,
  `letzte_Aenderung_am` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `letzte_Aenderung_von` varchar(255) DEFAULT NULL,
  `frage_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `antworten`
--

INSERT INTO `antworten` (`id`, `antwort`, `erstellt_am`, `erstellt_von`, `letzte_Aenderung_am`, `letzte_Aenderung_von`, `frage_id`) VALUES
(16, 'Markenbekanntheit steigern', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 12),
(17, 'Verkäufe fördern', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 12),
(18, 'Kundenbindung erhöhen', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 12),
(19, 'Lead-Generierung verbessern', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 12),
(20, 'Kundenservice verbessern', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 12),
(21, 'Jugendliche (13-17 Jahre)', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 13),
(22, 'Junge Erwachsene (18-24 Jahre)', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 13),
(23, 'Erwachsene (25-34 Jahre)', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 13),
(24, 'Mittleres Alter (35-54 Jahre)', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 13),
(25, 'Ältere Erwachsene (55+ Jahre)', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 13),
(26, 'Sehr wettbewerbsintensiv', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 14),
(27, 'Mäßig wettbewerbsintensiv', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 14),
(28, 'Wenig wettbewerbsintensiv', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 14),
(29, 'Facebook', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 15),
(30, 'Instagram', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 15),
(31, 'Twitter', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 15),
(32, 'LinkedIn', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 15),
(33, 'TikTok', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 15),
(34, 'YouTube', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 15),
(35, 'Videos', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 16),
(36, 'Textbeitrag', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 16),
(37, 'Bilder', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 16),
(38, 'Tutorials', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 16),
(39, 'Infografiken', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 16),
(40, 'Podcasts', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 16),
(41, 'Unter 500 € pro Monat', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 17),
(42, '500 € bis 1.000 € pro Monat', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 17),
(43, '1.000 € bis 5.000 € pro Monat', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 17),
(44, 'Über 5.000 € pro Monat', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 17),
(45, 'Weniger als 5 Stunden', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 18),
(46, '5 bis 10 Stunden', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 18),
(47, '10 bis 20 Stunden', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 18),
(48, 'Mehr als 20 Stunden', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 18),
(49, 'Sehr aktiv', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 19),
(50, 'Moderat aktiv', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 19),
(51, 'Wenig aktiv', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 19),
(52, 'Nicht vorhanden', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 19),
(53, 'Direkter Verkauf', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 20),
(54, 'Lead-Generierung', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 20),
(55, 'Beides', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 20),
(56, 'Keines von beidem', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 20),
(57, 'Direktes Feedback über Social Media', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 21),
(58, 'Umfragen', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 21),
(59, 'Bewertungsplattformen', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 21),
(60, 'Persönliches Feedback', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 21),
(61, 'Keine systematische Erfassung', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 21),
(62, 'Sehr wichtig', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 22),
(63, 'Wichtig', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 22),
(64, 'Weniger wichtig', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 22),
(65, 'Unwichtig', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 22),
(66, 'Formal', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 23),
(67, 'Informell', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 23),
(68, 'Humorvoll', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 23),
(69, 'Ernst', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 23),
(70, 'Inspirierend', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 23),
(71, 'Ja, regelmäßig', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 24),
(72, 'Gelegentlich', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 24),
(73, 'Nein, aber geplant', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 24),
(74, 'Nein, nicht geplant', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 24),
(75, 'Rabatte und Sonderangebote', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 25),
(76, 'Gewinnspiele', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 25),
(77, 'Produktdemonstrationen', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 25),
(78, 'Partnerschaften', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 25),
(79, 'Keine', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 25),
(80, 'Ja, sehr stark', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 26),
(81, 'Ja, aber überschaubar', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 26),
(82, 'Nein', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 26),
(83, 'B2C ausschließlich', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 27),
(84, 'B2B auschließlich', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 27),
(85, 'B2B/B2C teilweise', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 27),
(86, 'Starke Expansion auf neuen Plattformen', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 28),
(87, 'Vertiefung der bestehenden Präsenz', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 28),
(88, 'Experimentieren mit neuen Formaten', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 28),
(89, 'Stabilisierung der aktuellen Situation', '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 28);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `api_key`
--

DROP TABLE IF EXISTS `api_key`;
CREATE TABLE IF NOT EXISTS `api_key` (
  `id` int(11) NOT NULL,
  `key` text DEFAULT NULL,
  `erstellt_am` timestamp NOT NULL DEFAULT current_timestamp(),
  `erstellt_von` varchar(255) DEFAULT NULL,
  `letzte_Aenderung_am` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `letzte_Aenderung_von` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `api_key`
--

INSERT INTO `api_key` (`id`, `key`, `erstellt_am`, `erstellt_von`, `letzte_Aenderung_am`, `letzte_Aenderung_von`) VALUES
(1, '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\r\n', '2025-01-17 15:32:02', NULL, '2025-02-20 07:53:17', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `assistant_key`
--

DROP TABLE IF EXISTS `assistant_key`;
CREATE TABLE IF NOT EXISTS `assistant_key` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key_value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key_value` (`key_value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `assistant_key`
--

INSERT INTO `assistant_key` (`id`, `key_value`) VALUES
(4, 'asst_FP0ZqPIx0Q2pdbQUEHLCo8Ap');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fragen`
--

DROP TABLE IF EXISTS `fragen`;
CREATE TABLE IF NOT EXISTS `fragen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `frage` text DEFAULT NULL,
  `typ` int(11) NOT NULL,
  `erstellt_am` timestamp NOT NULL DEFAULT current_timestamp(),
  `erstellt_von` varchar(255) DEFAULT NULL,
  `letzte_Aenderung_am` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `letzte_Aenderung_von` varchar(255) DEFAULT NULL,
  `projekt_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `typ` (`typ`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `fragen`
--

INSERT INTO `fragen` (`id`, `frage`, `typ`, `erstellt_am`, `erstellt_von`, `letzte_Aenderung_am`, `letzte_Aenderung_von`, `projekt_id`) VALUES
(12, 'Unternehmensziele', 2, '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 13),
(13, 'Zielgruppe', 3, '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 13),
(14, 'Branche und Wettbewerb', 3, '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 13),
(15, 'Bisherige Aktivitäten', 2, '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 13),
(16, 'Content-Vorlieben', 2, '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 13),
(17, 'Ressourcen', 3, '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 13),
(18, 'Zeitlicher eigener Einsatz pro Woche', 3, '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 13),
(19, 'Kundeninteraktion', 3, '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 13),
(20, 'Vertriebswege', 3, '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 13),
(21, 'Kundenfeedback', 2, '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 13),
(22, 'Markenkonsistenz', 3, '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 13),
(23, 'Sprache und Ton', 3, '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 13),
(24, 'Einbindung von Influencern', 3, '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 13),
(25, 'Werbeaktionen und Kampagnen', 2, '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 13),
(26, 'Saisonabhängigkeit', 3, '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 13),
(27, 'Zielgruppe/Kunden', 3, '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 13),
(28, 'Zukunftsvision', 3, '2025-02-25 14:57:22', NULL, '2025-02-25 14:57:22', NULL, 13);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` varchar(255) NOT NULL,
  `recipient` varchar(255) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `attachment` varchar(255) DEFAULT NULL,
  `read_status` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `messages`
--

INSERT INTO `messages` (`id`, `sender`, `recipient`, `subject`, `message`, `timestamp`, `attachment`, `read_status`) VALUES
(1, 'test1', 'test1', 'h', 'hi', '2025-03-20 12:22:02', NULL, 0),
(3, 'test1', 'test2', 'asd', 'cvhbs fg sadfg ', '2025-03-20 12:24:05', NULL, 0),
(4, 'test1', 'test2', 'afdgadfg', 'dfgafdg', '2025-03-20 12:24:18', NULL, 0),
(5, 'test1', 'test2', '1', 'dahsgeibfciegbfiew', '2025-03-20 12:30:38', NULL, 0),
(6, 'test1', 'test1', NULL, 'hiho', '2025-03-20 12:36:59', NULL, 0),
(7, 'test1', 'test1', NULL, 'hi\r\n:)\r\n\r\n', '2025-03-20 12:37:20', NULL, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `projekt`
--

DROP TABLE IF EXISTS `projekt`;
CREATE TABLE IF NOT EXISTS `projekt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `key` int(10) DEFAULT NULL,
  `assistant_key_id` int(11) DEFAULT NULL,
  `erstellt_am` timestamp NOT NULL DEFAULT current_timestamp(),
  `erstellt_von` varchar(255) DEFAULT NULL,
  `letzte_Aenderung_am` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `letzte_Aenderung_von` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 0,
  `debug` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `key` (`key`),
  KEY `assistant_key` (`assistant_key_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `projekt`
--

INSERT INTO `projekt` (`id`, `name`, `key`, `assistant_key_id`, `erstellt_am`, `erstellt_von`, `letzte_Aenderung_am`, `letzte_Aenderung_von`, `is_active`, `debug`) VALUES
(12, 'AlphaTest', 1, 4, '2025-02-20 07:56:19', NULL, '2025-02-28 10:33:49', NULL, 0, 0),
(13, 'Social Media Strategie', 1, 4, '2025-02-25 14:57:22', NULL, '2025-03-20 10:18:39', NULL, 1, 1),
(14, 'BetaTest', 1, 4, '2025-02-20 07:56:19', NULL, '2025-02-27 14:53:06', NULL, 0, 0),
(15, 'Test', NULL, NULL, '2025-03-17 10:05:39', '2', '2025-03-17 10:05:50', NULL, 0, 0),
(16, '1', NULL, NULL, '2025-03-17 10:41:28', '2', '2025-03-17 10:42:00', NULL, 0, 0),
(17, '2', NULL, NULL, '2025-03-20 10:18:32', '2', '2025-03-20 10:18:39', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `type`
--

DROP TABLE IF EXISTS `type`;
CREATE TABLE IF NOT EXISTS `type` (
  `id` int(11) NOT NULL,
  `type` text DEFAULT NULL,
  `erstellt_am` timestamp NOT NULL DEFAULT current_timestamp(),
  `erstellt_von` varchar(255) DEFAULT NULL,
  `letzte_Aenderung_am` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `letzte_Aenderung_von` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `type`
--

INSERT INTO `type` (`id`, `type`, `erstellt_am`, `erstellt_von`, `letzte_Aenderung_am`, `letzte_Aenderung_von`) VALUES
(1, 'text', '2025-02-19 11:18:46', NULL, '2025-02-19 11:18:46', NULL),
(2, 'checkbox', '2025-02-19 11:18:46', NULL, '2025-02-28 10:44:42', NULL),
(3, 'radio', '2025-02-19 11:19:44', NULL, '2025-02-19 11:19:44', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `role` enum('superadmin','admin','moderator') DEFAULT 'admin',
  `erstellt_am` timestamp NOT NULL DEFAULT current_timestamp(),
  `erstellt von` varchar(255) DEFAULT NULL,
  `letzte_Aenderung_am` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `letzte_Aenderung_von` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT '../uploads/avatars/default.png',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `full_name`, `role`, `erstellt_am`, `erstellt von`, `letzte_Aenderung_am`, `letzte_Aenderung_von`, `avatar`) VALUES
(2, 'test1', '$2y$10$bJgQMT2pmBnv8f3Z.fjZKOZVKhZMMK2qJfr9Cmp3yfPzvPr6QtTku', 'test2@test2.de', NULL, 'superadmin', '2025-01-14 15:37:12', NULL, '2025-03-17 10:58:43', NULL, '../uploads/avatars/2_mustericon.png'),
(6, 'test2', '$2y$10$uhHQZQv8aPfyrjl2tkp1DuAGD095FyRXt3rG4YXJIX6YYD.6eOKg2', 'abc123@abc.de', NULL, '', '2025-02-18 12:57:21', NULL, '2025-02-18 12:57:21', NULL, '../uploads/avatars/default.png');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `zuweisung_fa`
--

DROP TABLE IF EXISTS `zuweisung_fa`;
CREATE TABLE IF NOT EXISTS `zuweisung_fa` (
  `id` int(11) NOT NULL,
  `frage_id` int(11) NOT NULL,
  `antwort_id` int(11) NOT NULL,
  `erstellt_am` timestamp NOT NULL DEFAULT current_timestamp(),
  `erstellt_von` varchar(255) DEFAULT NULL,
  `letzte_Aenderung_am` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `letzte_Aenderung_von` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `frage_antwort` (`frage_id`,`antwort_id`),
  KEY `antwort_id` (`antwort_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `zuweisung_pf`
--

DROP TABLE IF EXISTS `zuweisung_pf`;
CREATE TABLE IF NOT EXISTS `zuweisung_pf` (
  `id` int(11) NOT NULL,
  `projekt_id` int(11) NOT NULL,
  `fa_id` int(11) NOT NULL,
  `erstellt_am` timestamp NOT NULL DEFAULT current_timestamp(),
  `erstellt_von` varchar(255) DEFAULT NULL,
  `letzte_Aenderung_am` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `letzte_Aenderung_von` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `projekt_fragen` (`projekt_id`,`fa_id`),
  KEY `fa_id` (`fa_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `fragen`
--
ALTER TABLE `fragen`
  ADD CONSTRAINT `fragen_ibfk_1` FOREIGN KEY (`typ`) REFERENCES `type` (`id`);

--
-- Constraints der Tabelle `projekt`
--
ALTER TABLE `projekt`
  ADD CONSTRAINT `projekt_assistant_key_fk` FOREIGN KEY (`assistant_key_id`) REFERENCES `assistant_key` (`id`) ON DELETE SET NULL;

--
-- Constraints der Tabelle `zuweisung_fa`
--
ALTER TABLE `zuweisung_fa`
  ADD CONSTRAINT `zuweisung_fa_ibfk_1` FOREIGN KEY (`antwort_id`) REFERENCES `antworten` (`id`),
  ADD CONSTRAINT `zuweisung_fa_ibfk_2` FOREIGN KEY (`frage_id`) REFERENCES `fragen` (`id`);

--
-- Constraints der Tabelle `zuweisung_pf`
--
ALTER TABLE `zuweisung_pf`
  ADD CONSTRAINT `zuweisung_pf_ibfk_1` FOREIGN KEY (`fa_id`) REFERENCES `zuweisung_fa` (`id`),
  ADD CONSTRAINT `zuweisung_pf_ibfk_2` FOREIGN KEY (`projekt_id`) REFERENCES `projekt` (`id`);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
