-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 14 Paź 2023, 19:05
-- Wersja serwera: 10.4.14-MariaDB
-- Wersja PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `zs1quiz_blank`
--
CREATE DATABASE IF NOT EXISTS `zs1quiz_blank` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `zs1quiz_blank`;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `guests`
--

CREATE TABLE `guests` (
  `id` varchar(128) NOT NULL,
  `username` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `correctAnswers` int(11) DEFAULT 1,
  `contents` text DEFAULT NULL,
  `answer1` text DEFAULT NULL,
  `answer2` text DEFAULT NULL,
  `answer3` text DEFAULT NULL,
  `answer4` text DEFAULT NULL,
  `answer5` text DEFAULT NULL,
  `answer6` text DEFAULT NULL,
  `image` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `questions`
--

INSERT INTO `questions` (`id`, `correctAnswers`, `contents`, `answer1`, `answer2`, `answer3`, `answer4`, `answer5`, `answer6`, `image`) VALUES
(1, 1, 'Przykładowe pytanie 1', 'Odpowiedź 1 (poprawna)', 'Odpowiedź 2', NULL, NULL, NULL, NULL, NULL),
(2, 1, 'Przykładowe pytanie 2', 'Odpowiedź 1 (poprawna)', 'Odpowiedź 2', 'Odpowiedź 3', 'Odpowiedź 4', NULL, NULL, NULL),
(3, 1, 'Przykładowe pytanie 3', 'Odpowiedź 2 (poprawna)', 'Odpowiedź 1', 'Odpowiedź 3', 'Odpowiedź 4', NULL, NULL, NULL),
(4, 3, 'Przykładowe pytanie 4', 'Odpowiedź 1 (poprawna)', 'Odpowiedź 2 (poprawna)', 'Odpowiedź 3 (poprawna)', 'Odpowiedź 4', 'Odpowiedź 5', 'Odpowiedź 6', NULL),
(5, 1, 'Przykładowe pytanie 5', 'Odpowiedź 1 (poprawna)', 'Odpowiedź 2', 'Odpowiedź 3', NULL, NULL, NULL, NULL),
(6, 2, 'Przykładowe pytanie 6', 'Odpowiedź 1 (poprawna)', 'Odpowiedź 2 (poprawna)', 'Odpowiedź 3', 'Odpowiedź 4', NULL, NULL, NULL),
(7, 1, 'Przykładowe pytanie 7', 'Odpowiedź 3 (poprawna)', 'Odpowiedź 1', 'Odpowiedź 2', 'Odpowiedź 4', NULL, NULL, 'placeholder.png'),
(8, 1, 'Przykładowe pytanie 8', 'Odpowiedź 1 (poprawna)', 'Odpowiedź 2', NULL, NULL, NULL, NULL, 'placeholder.png');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `scores`
--

CREATE TABLE `scores` (
  `id` int(11) NOT NULL,
  `guestID` varchar(128) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `startTime` int(11) NOT NULL,
  `finishTime` int(11) DEFAULT NULL,
  `ip` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `scoresForeignKey1` (`guestID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT dla tabeli `scores`
--
ALTER TABLE `scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `scores`
--
ALTER TABLE `scores`
  ADD CONSTRAINT `scores_ibfk_1` FOREIGN KEY (`guestID`) REFERENCES `guests` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
