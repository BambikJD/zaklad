-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 27 Kwi 2023, 21:55
-- Wersja serwera: 10.4.24-MariaDB
-- Wersja PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `myjnia`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `karnety`
--

CREATE TABLE `karnety` (
  `idk` int(11) NOT NULL,
  `nazwa` varchar(11) NOT NULL,
  `cena` int(11) NOT NULL,
  `iloscwizyt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `karnety`
--

INSERT INTO `karnety` (`idk`, `nazwa`, `cena`, `iloscwizyt`) VALUES
(1, 'Iron', 200, 5),
(2, 'Gold', 400, 10),
(3, 'Diax', 999, 20);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `idu` int(11) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `pracownik` tinyint(1) NOT NULL,
  `imie` varchar(30) NOT NULL,
  `nazwisko` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `adres` varchar(40) NOT NULL,
  `telefon` varchar(9) NOT NULL,
  `placa` int(11) DEFAULT NULL,
  `karnet` int(11) DEFAULT NULL,
  `login` varchar(40) NOT NULL,
  `haslo` text NOT NULL,
  `datakarnetu` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`idu`, `admin`, `pracownik`, `imie`, `nazwisko`, `email`, `adres`, `telefon`, `placa`, `karnet`, `login`, `haslo`, `datakarnetu`) VALUES
(5, 1, 0, 'admin', 'admin', 'admin', 'admin', 'admin', 40000, NULL, 'admin', 'admin', NULL),
(6, 0, 1, 'pracownik', 'pracownik', 'pracownik', 'pracownik', 'pracownik', 2000, NULL, 'pracownik', 'pracownik', NULL),
(7, 0, 0, 'rzyd', 'rzyd', 'rzyd', 'rzyd', 'rzyd', NULL, 2, 'rzyd', 'rzyd', '2023-04-27');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uslugi`
--

CREATE TABLE `uslugi` (
  `iduslugi` int(11) NOT NULL,
  `nazwa` varchar(30) NOT NULL,
  `cena` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `uslugi`
--

INSERT INTO `uslugi` (`iduslugi`, `nazwa`, `cena`) VALUES
(1, 'Mycie', 20),
(2, 'Piana', 40),
(3, 'Polerowanie', 40);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wizyty`
--

CREATE TABLE `wizyty` (
  `idw` int(11) NOT NULL,
  `cena` varchar(6) NOT NULL,
  `idu` int(11) NOT NULL,
  `data` date NOT NULL,
  `godzina` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `wizyty`
--

INSERT INTO `wizyty` (`idw`, `cena`, `idu`, `data`, `godzina`) VALUES
(2, 'karnet', 3, '2025-04-11', '10:50:00'),
(12, 'karnet', 3, '2023-04-29', '21:05:00');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `karnety`
--
ALTER TABLE `karnety`
  ADD PRIMARY KEY (`idk`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idu`),
  ADD KEY `karnet` (`karnet`);

--
-- Indeksy dla tabeli `uslugi`
--
ALTER TABLE `uslugi`
  ADD PRIMARY KEY (`iduslugi`);

--
-- Indeksy dla tabeli `wizyty`
--
ALTER TABLE `wizyty`
  ADD PRIMARY KEY (`idw`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `karnety`
--
ALTER TABLE `karnety`
  MODIFY `idk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `idu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `uslugi`
--
ALTER TABLE `uslugi`
  MODIFY `iduslugi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `wizyty`
--
ALTER TABLE `wizyty`
  MODIFY `idw` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`karnet`) REFERENCES `karnety` (`idk`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
