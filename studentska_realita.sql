-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Počítač: localhost:3306
-- Vytvořeno: Úte 17. úno 2026, 13:29
-- Verze serveru: 5.7.24
-- Verze PHP: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `studentska_realita`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `difficulty` int(11) NOT NULL,
  `atmosphere` int(11) NOT NULL,
  `content` text NOT NULL,
  `year_of_study` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `school_id`, `rating`, `difficulty`, `atmosphere`, `content`, `year_of_study`, `created_at`) VALUES
(1, 1, 10, 1, 5, 1, 'nechodte sem (na vlastni riziko)', 3, '2026-02-17 13:11:00');

-- --------------------------------------------------------

--
-- Struktura tabulky `schools`
--

CREATE TABLE `schools` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `schools`
--

INSERT INTO `schools` (`id`, `name`, `city`, `category`, `created_at`) VALUES
(1, 'Gymnázium Luďka Pika', 'Plzeň', 'Gymnázium', '2026-02-17 13:09:06'),
(2, 'Gymnázium, Plzeň, Mikulášské nám.', 'Plzeň', 'Gymnázium', '2026-02-17 13:09:06'),
(3, 'Církevní gymnázium Plzeň', 'Plzeň', 'Gymnázium', '2026-02-17 13:09:06'),
(4, 'Sportovní gymnázium Plzeň', 'Plzeň', 'Gymnázium', '2026-02-17 13:09:06'),
(5, 'Gymnázium Františka Křižíka a základní škola', 'Plzeň', 'Gymnázium', '2026-02-17 13:09:06'),
(6, 'PLZEŇSKÁ OBCHODNÍ AKADEMIE s.r.o.', 'Plzeň', 'Střední škola', '2026-02-17 13:09:06'),
(7, 'Hotelová škola Plzeň - Akademie hotelnictví a cestovního ruchu', 'Plzeň', 'Střední škola', '2026-02-17 13:09:06'),
(8, 'Obchodní akademie, Plzeň', 'Plzeň', 'Střední škola', '2026-02-17 13:09:06'),
(9, 'Střední uměleckoprůmyslová škola Zámeček', 'Plzeň', 'Střední škola', '2026-02-17 13:09:06'),
(10, 'Střední odborné učiliště elektrotechnické', 'Plzeň', 'Střední škola', '2026-02-17 13:09:06'),
(11, 'Odborná škola výroby a služeb', 'Plzeň', 'Střední škola', '2026-02-17 13:09:06'),
(12, 'Střední průmyslová škola dopravní', 'Plzeň', 'Střední škola', '2026-02-17 13:09:06'),
(13, 'Vyšší odborná škola a SPŠ elektrotechnická', 'Plzeň', 'Střední škola', '2026-02-17 13:09:06'),
(14, 'Střední odborná škola obchodu, užitého umění a designu', 'Plzeň', 'Střední škola', '2026-02-17 13:09:06');

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `birth_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `email`, `password_hash`, `birth_date`, `created_at`) VALUES
(1, 'dipex@seznam.cz', '$2y$10$QNUzDhqwshTys3tRy4DuGuO1ZxeAlbn1DxC4n9wVuV9wD7Yv9lrMW', '2007-05-31', '2026-02-17 13:09:48');

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `school_id` (`school_id`);

--
-- Indexy pro tabulku `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pro tabulku `schools`
--
ALTER TABLE `schools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`school_id`) REFERENCES `schools` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
