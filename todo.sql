-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2024 at 09:15 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `todo`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `notatka`
--

CREATE TABLE `notatka` (
  `notatka_id` int(11) NOT NULL,
  `Nazwa_Notatki` varchar(255) NOT NULL,
  `Tresc` text NOT NULL,
  `Priorytet` int(11) NOT NULL,
  `Uzytkownik_id` int(11) NOT NULL,
  `zrobione` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notatka`
--

INSERT INTO `notatka` (`notatka_id`, `Nazwa_Notatki`, `Tresc`, `Priorytet`, `Uzytkownik_id`, `zrobione`) VALUES
(1, 'notatka 1', 'asdasda', 1, 6, 0),
(2, 'notatka 1', 'dasdas', 3, 6, 0),
(3, 'notatka 1', 'dasdas', 3, 6, 0),
(4, 'notatka 1', 'dasdas', 3, 6, 0),
(5, 'notatka 11231', 'dasad', 1, 6, 0),
(6, 'bumcykcyk', 'koń zvalony', 1, 7, 0),
(7, 'xcvcvx', 'vxcvxc', 1, 7, 0),
(8, 'piwo', 'wwwww', 1, 7, 0),
(9, 'aaa', 'aaaa', 2, 9, 0),
(10, 'aaa', 'aa', 1, 9, 0),
(11, '2', '23', 3, 9, 0),
(12, 'cvb', 'cvbcvb', 1, 7, 0),
(13, 'fsd', '31', 1, 7, 0),
(14, 'lol', 'lol', 3, 7, 0),
(17, 'dsads', 'ddd', 1, 10, 0),
(18, 'vv', 'vv', 1, 10, 0),
(19, 'dxf', 'fedf', 1, 10, 0),
(20, 'fsfs', 'sss', 1, 10, 0),
(21, 'dassda', 'ddd', 1, 10, 0),
(22, 'adaw', '22', 1, 10, 0),
(23, 'sfddfs', 'fff', 1, 10, 0),
(27, 'fds', 'ffdfs\r\nsdf\r\nsfd\r\nsfd\r\nfs', 1, 10, 0),
(28, 'asdasdas', 'dasdasdasdasdasda', 1, 10, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `uzytkownik_id` int(11) NOT NULL,
  `Login` char(50) NOT NULL,
  `Haslo` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`uzytkownik_id`, `Login`, `Haslo`) VALUES
(5, 'jarp', 'jarp'),
(6, 'jarpe', 'jarp'),
(7, 'oskar', '1234'),
(8, 'oskar123', 'oskar123'),
(9, 'duzoa', 'aaa'),
(10, 'oskarr', '123');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `notatka`
--
ALTER TABLE `notatka`
  ADD PRIMARY KEY (`notatka_id`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`uzytkownik_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notatka`
--
ALTER TABLE `notatka`
  MODIFY `notatka_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `uzytkownik_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
