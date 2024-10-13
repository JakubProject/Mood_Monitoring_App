-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Paź 13, 2024 at 09:43 PM
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
-- Database: `moodapp_db`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `moods`
--

CREATE TABLE `moods` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mood_level` int(2) NOT NULL,
  `mood_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `energy_level` int(2) DEFAULT NULL,
  `stress_level` int(2) DEFAULT NULL,
  `sleep_quality` int(2) DEFAULT NULL,
  `motivation_level` int(2) DEFAULT NULL,
  `anxiety_level` int(2) DEFAULT NULL,
  `physical_activity` int(4) DEFAULT NULL,
  `concentration_level` int(2) DEFAULT NULL,
  `physical_symptoms` text DEFAULT NULL,
  `happiness_level` int(2) DEFAULT NULL,
  `day_satisfaction` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `moods`
--

INSERT INTO `moods` (`id`, `user_id`, `mood_level`, `mood_text`, `created_at`, `energy_level`, `stress_level`, `sleep_quality`, `motivation_level`, `anxiety_level`, `physical_activity`, `concentration_level`, `physical_symptoms`, `happiness_level`, `day_satisfaction`) VALUES
(2, 2, 8, '', '2024-09-25 13:37:15', 10, 2, 9, 6, 1, 60, 6, 'Brak objawów', 9, 9),
(3, 2, 4, '', '2024-09-25 13:48:49', 4, 4, 4, 4, 4, 0, 4, 'Ból głowy', 4, 4),
(4, 2, 6, '', '2024-09-25 13:49:07', 5, 3, 2, 1, 1, 80, 3, 'Zmęczenie', 3, 3),
(5, 2, 7, '', '2024-09-25 13:49:23', 7, 7, 7, 7, 7, 77, 7, 'Brak', 7, 7),
(6, 2, 3, '', '2024-09-27 14:07:40', 3, 3, 3, 3, 3, 33, 3, 'Brak', 3, 3),
(7, 3, 10, '', '2024-10-13 19:02:44', 10, 10, 1, 1, 1, 1, 1, 'Brak', 1, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, '', 'test@wp.pl', '$2y$10$1HPDpiDu/o6B4zAA6dOR0e4t5OfpEiqXo4WYkZv/SYEsobF9M.VY6'),
(2, '', 'Rakowski@wp.pl', '$2y$10$TuQf/FeYJrJdNMVfTEsWn.PFJQN2k1VxIRn8i7NoQ25Q1bDliSvVa'),
(3, '', 'testowy@wp.pl', '$2y$10$yvTolcPdUD/6tleldYwyjOeHxQ1.hTfztfIoBjWevMLmdnFGfU.Pa');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `moods`
--
ALTER TABLE `moods`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `moods`
--
ALTER TABLE `moods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
