-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 26 août 2026 à 11:04
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tomtroc`
--

-- --------------------------------------------------------

--
-- Structure de la table `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE IF NOT EXISTS `books` (
  `id_book` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `author` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id_book`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `books`
--

INSERT INTO `books` (`id_book`, `title`, `author`, `image`, `description`, `status`, `created_at`, `updated_at`, `id_user`) VALUES
(33, 'Esther', 'Alabaster', '/assets/img/books/Esther.png', 'Une présentation illustrée du livre biblique d’Esther, qui raconte le parcours d’une jeune femme devenue reine et appelée à sauver son peuple. Cette édition associe le texte biblique à une mise en page artistique pour offrir une nouvelle façon de découvrir cette histoire.', 'available', '2022-03-14 10:24:18', '2022-06-02 16:41:05', 1),
(34, 'The Kinfolk Table', 'Nathan Williams', '/assets/img/books/The Kinfolk Table.png', 'Un livre consacré à la cuisine, au partage et à l’art de recevoir. Nathan Williams rassemble des recettes, des histoires et des rencontres autour d’une vision simple et conviviale de la vie quotidienne.', 'available', '2022-08-27 14:12:33', '2023-01-18 09:35:42', 2),
(35, 'Wabi Sabi', 'Beth Kempton', './assets/img/books/Wabi Sabi.png', 'Beth Kempton présente le wabi-sabi, une philosophie japonaise qui invite à accepter l’imperfection, apprécier la simplicité et profiter davantage du moment présent. Un ouvrage tourné vers le bien-être et une vie plus sereine.', 'available', '2023-02-11 08:45:27', '2026-08-26 12:46:47', 2),
(36, 'Milk & honey', 'Rupi Kaur', '/assets/img/books/Milk & honey.png', 'Un recueil de poésie divisé en quatre parties : la souffrance, l’amour, la rupture et la guérison. Rupi Kaur explore les blessures, les relations, la féminité et la reconstruction avec une écriture simple et directe.', 'available', '2023-05-19 17:31:52', '2023-09-07 11:14:36', 3),
(37, 'Delight!', 'Justin Rossow', '/assets/img/books/Delight!.png', 'Un ouvrage autour de la joie, de la reconnaissance et de la manière de trouver davantage de sens dans les expériences du quotidien.', 'unavailable', '2023-10-03 12:08:44', '2024-01-15 15:47:21', 4),
(38, 'Milwaukee Mission', 'Elder Cooper Low', '/assets/img/books/Milwaukee Mission.png', 'Un récit personnel lié à une mission à Milwaukee, partageant des expériences, des rencontres et des réflexions vécues au cours du parcours missionnaire.', 'available', '2024-02-22 09:17:13', '2024-03-29 13:26:58', 5),
(39, 'Minimalist Graphics', 'Julia Schonlau', '/assets/img/books/Minimalist Graphics.png', 'Une sélection de projets de design graphique reposant sur les principes du minimalisme. L\'ouvrage présente des identités visuelles, publications et créations imprimées où la simplicité des formes et de la composition permet une communication claire et efficace.', 'available', '2024-04-08 16:53:39', '2024-07-12 10:05:17', 6),
(40, 'Hygge', 'Meik Wiking', '/assets/img/books/Hygge.png', 'Meik Wiking explore le concept danois du hygge, associé au confort, à la convivialité et au bien-être. Le livre propose différentes façons de créer une atmosphère chaleureuse et de profiter davantage des petits plaisirs du quotidien.', 'available', '2024-08-31 11:42:06', '2024-11-19 17:34:25', 3),
(41, 'Innovation', 'Matt Ridley', '/assets/img/books/Innovation.png', 'Matt Ridley s\'intéresse à l\'origine et au fonctionnement de l\'innovation. Il montre comment les nouvelles idées et technologies apparaissent, se diffusent et transforment progressivement nos sociétés.', 'available', '2024-12-14 15:28:41', '2025-02-03 08:51:09', 7),
(42, 'Psalms', 'Alabaster', '/assets/img/books/Psalms.png', 'Une édition artistique du livre des Psaumes, associant le texte biblique à des illustrations et une mise en page soignée. Elle propose une lecture plus visuelle de ces textes consacrés notamment à la foi, à l\'espérance et aux émotions humaines.', 'available', '2025-03-06 10:36:55', '2025-05-27 14:13:47', 8),
(43, 'Thinking, Fast & Slow', 'Daniel Kahneman', '/assets/img/books/Thinking, Fast & Slow.png', 'Daniel Kahneman explore les deux grands modes de pensée qui influencent nos jugements et nos décisions : l\'un rapide et intuitif, l\'autre plus lent et réfléchi. Un ouvrage de référence sur les biais cognitifs et la prise de décision.', 'unavailable', '2025-06-18 18:07:24', '2025-08-09 09:22:38', 9),
(44, 'A Book Full Of Hope', 'Rupi Kaur', '/assets/img/books/A Book Full Of Hope.png', 'Un ouvrage poétique centré sur l\'espoir, la résilience et la possibilité de trouver de la lumière malgré les difficultés. Rupi Kaur y aborde les émotions et le cheminement personnel avec son style poétique caractéristique.', 'available', '2025-09-25 13:49:16', '2025-12-04 16:28:53', 10),
(45, 'The Subtle Art Of Not Giving a Fuck', 'Mark Manson', '/assets/img/books/The Subtle Art Of Not Giving a Fuck.png', 'Mark Manson propose une approche directe du développement personnel : plutôt que de chercher à éviter tous les problèmes, il invite à choisir ce qui mérite réellement notre attention et à accepter les difficultés inévitables de la vie.', 'available', '2026-01-17 09:15:32', '2026-02-28 12:44:07', 11),
(46, 'Narnia', 'C.S Lewis', '/assets/img/books/Narnia.png', 'Une grande aventure fantastique située dans le monde magique de Narnia, peuplé d\'animaux parlants, de créatures mythiques et de magie. La série suit plusieurs enfants de notre monde dans leurs aventures à travers ce royaume.', 'available', '2026-03-21 17:26:48', '2026-04-30 10:38:19', 12),
(47, 'Company Of One', 'Paul Jarvis', '/assets/img/books/Company Of One.png', 'Paul Jarvis défend une approche différente de l\'entrepreneuriat : privilégier une entreprise volontairement petite plutôt que rechercher constamment la croissance. Le livre aborde notamment l\'indépendance, la rentabilité, la liberté et l\'équilibre entre travail et vie personnelle.', 'available', '2026-05-12 11:03:27', '2026-06-16 15:52:34', 13),
(48, 'The Two Towers', 'J.R.R Tolkien', '/assets/img/books/The Two Towers.png', 'Deuxième partie du Seigneur des Anneaux, le récit suit les compagnons de l\'Anneau après leur séparation. Alors que Frodo et Sam poursuivent leur route vers le Mordor, leurs compagnons affrontent de nouvelles menaces au cœur de la Terre du Milieu.', 'available', '2026-07-09 14:37:51', '2026-08-18 09:46:12', 14);

-- --------------------------------------------------------

--
-- Structure de la table `conversations`
--

DROP TABLE IF EXISTS `conversations`;
CREATE TABLE IF NOT EXISTS `conversations` (
  `id_conversation` int NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_conversation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id_message` int NOT NULL AUTO_INCREMENT,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `is_read` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `id_user` int NOT NULL,
  `id_conversation` int NOT NULL,
  PRIMARY KEY (`id_message`),
  KEY `id_user` (`id_user`),
  KEY `id_conversation` (`id_conversation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `username`, `email`, `password`, `avatar`, `created_at`, `updated_at`) VALUES
(1, 'CamilleClubLit', 'CamilleClubLit@email.com', '$2y$10$kDOjO9d8BJPTd3z.MO4Juu.DmfUsDcIqJukfIhqU.8y4seq5dKYjG', '/assets/img/pictures/default.png', '2022-01-18 14:32:17', '2024-06-12 09:41:25'),
(2, 'Alexlecture', 'Alexlecture@email.com', '$2y$10$kDOjO9d8BJPTd3z.MO4Juu.DmfUsDcIqJukfIhqU.8y4seq5dKYjG', '/assets/img/pictures/alexlecture.png', '2022-05-09 10:17:42', '2025-02-21 16:28:11'),
(3, 'Hugo1990_12', 'Hugo1990_12@email.com', '$2y$10$kDOjO9d8BJPTd3z.MO4Juu.DmfUsDcIqJukfIhqU.8y4seq5dKYjG', '/assets/img/pictures/default.png', '2022-11-24 17:45:08', '2025-09-15 11:36:52'),
(4, 'Juju1432', 'Juju1432@email.com', '$2y$10$kDOjO9d8BJPTd3z.MO4Juu.DmfUsDcIqJukfIhqU.8y4seq5dKYjG', '/assets/img/pictures/default.png', '2023-04-13 09:26:31', '2024-08-07 14:52:19'),
(5, 'Christiane75014', 'Christiane75014@email.com', '$2y$10$kDOjO9d8BJPTd3z.MO4Juu.DmfUsDcIqJukfIhqU.8y4seq5dKYjG', '/assets/img/pictures/default.png', '2023-09-28 15:11:46', '2025-03-19 10:24:37'),
(6, 'Hamzalecture', 'Hamzalecture@email.com', '$2y$10$kDOjO9d8BJPTd3z.MO4Juu.DmfUsDcIqJukfIhqU.8y4seq5dKYjG', '/assets/img/pictures/default.png', '2023-12-06 11:38:22', '2025-07-26 18:05:14'),
(7, 'Lou&Ben50', 'Lou&Ben50@email.com', '$2y$10$kDOjO9d8BJPTd3z.MO4Juu.DmfUsDcIqJukfIhqU.8y4seq5dKYjG', '/assets/img/pictures/default.png', '2024-05-17 16:42:09', '2025-04-11 08:57:31'),
(8, 'Lolobzh', 'Lolobzh@email.com', '$2y$10$kDOjO9d8BJPTd3z.MO4Juu.DmfUsDcIqJukfIhqU.8y4seq5dKYjG', '/assets/img/pictures/default.png', '2024-09-23 13:14:55', '2025-11-08 17:33:27'),
(9, 'Sas634', 'Sas634@email.com', '$2y$10$kDOjO9d8BJPTd3z.MO4Juu.DmfUsDcIqJukfIhqU.8y4seq5dKYjG', '/assets/img/pictures/sas634.png', '2025-01-12 10:48:36', '2026-02-16 12:21:44'),
(10, 'ML95', 'ML95@email.com', '$2y$10$kDOjO9d8BJPTd3z.MO4Juu.DmfUsDcIqJukfIhqU.8y4seq5dKYjG', '/assets/img/pictures/default.png', '2025-04-29 18:06:12', '2026-01-27 09:15:38'),
(11, 'Verogo33', 'Verogo33@email.com', '$2y$10$kDOjO9d8BJPTd3z.MO4Juu.DmfUsDcIqJukfIhqU.8y4seq5dKYjG', '/assets/img/pictures/default.png', '2025-08-14 12:37:49', '2026-04-05 16:46:21'),
(12, 'AnnikaBrahms', 'AnnikaBrahms@email.com', '$2y$10$kDOjO9d8BJPTd3z.MO4Juu.DmfUsDcIqJukfIhqU.8y4seq5dKYjG', '/assets/img/pictures/default.png', '2025-11-02 09:54:28', '2026-05-19 14:08:53'),
(13, 'Victoirefabr912', 'Victoirefabr912@email.com', '$2y$10$kDOjO9d8BJPTd3z.MO4Juu.DmfUsDcIqJukfIhqU.8y4seq5dKYjG', '/assets/img/pictures/default.png', '2026-01-26 15:31:07', '2026-07-03 11:42:16'),
(14, 'Lotrfanclub67', 'Lotrfanclub67@email.com', '$2y$10$kDOjO9d8BJPTd3z.MO4Juu.DmfUsDcIqJukfIhqU.8y4seq5dKYjG', '/assets/img/pictures/default.png', '2026-03-18 10:22:41', '2026-08-08 17:19:34');

-- --------------------------------------------------------

--
-- Structure de la table `users_conversation`
--

DROP TABLE IF EXISTS `users_conversation`;
CREATE TABLE IF NOT EXISTS `users_conversation` (
  `id_user` int NOT NULL,
  `id_conversation` int NOT NULL,
  PRIMARY KEY (`id_user`,`id_conversation`),
  KEY `id_conversation` (`id_conversation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`id_conversation`) REFERENCES `conversations` (`id_conversation`);

--
-- Contraintes pour la table `users_conversation`
--
ALTER TABLE `users_conversation`
  ADD CONSTRAINT `users_conversation_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `users_conversation_ibfk_2` FOREIGN KEY (`id_conversation`) REFERENCES `conversations` (`id_conversation`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
