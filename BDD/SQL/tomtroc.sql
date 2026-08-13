-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 13 août 2026 à 20:58
-- Version du serveur : 8.4.7
-- Version de PHP : 8.3.28

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
  `title` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `author` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `status` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id_book`),
  KEY `id_user` (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `books`
--

INSERT INTO `books` (`id_book`, `title`, `author`, `image`, `description`, `status`, `created_at`, `updated_at`, `id_user`) VALUES
(1, 'Esther', 'Alabaster', '/assets/img/books/Esther.svg', 'Une présentation illustrée du livre biblique d’Esther, qui raconte le parcours d’une jeune femme devenue reine et appelée à sauver son peuple. Cette édition associe le texte biblique à une mise en page artistique pour offrir une nouvelle façon de découvrir cette histoire.', 'available', '2026-08-13 21:00:00', '2026-08-13 21:00:00', 1),
(2, 'The Kinfolk Table', 'Nathan Williams', '/assets/img/books/The Kinfolk Table.svg', 'Un livre consacré à la cuisine, au partage et à l’art de recevoir. Nathan Williams rassemble des recettes, des histoires et des rencontres autour d’une vision simple et conviviale de la vie quotidienne.', 'available', '2026-08-14 21:00:00', '2026-08-14 21:00:00', 2),
(3, 'Wabi Sabi', 'Beth Kempton', '/assets/img/books/Wabi Sabi.svg', 'Beth Kempton présente le wabi-sabi, une philosophie japonaise qui invite à accepter l’imperfection, apprécier la simplicité et profiter davantage du moment présent. Un ouvrage tourné vers le bien-être et une vie plus sereine.', 'available', '2026-08-15 21:00:00', '2026-08-15 21:00:00', 2),
(4, 'Milk & honey', 'Rupi Kaur', '/assets/img/books/Milk & honey.svg', 'Un recueil de poésie divisé en quatre parties : la souffrance, l’amour, la rupture et la guérison. Rupi Kaur explore les blessures, les relations, la féminité et la reconstruction avec une écriture simple et directe.', 'available', '2026-08-16 21:00:00', '2026-08-16 21:00:00', 3),
(5, 'Delight!', 'Justin Rossow', '/assets/img/books/Delight!.svg', 'Un ouvrage autour de la joie, de la reconnaissance et de la manière de trouver davantage de sens dans les expériences du quotidien.', 'unavailable', '2026-08-17 21:00:00', '2026-08-17 21:00:00', 4),
(6, 'Milwaukee Mission', 'Elder Cooper Low', '/assets/img/books/Milwaukee Mission.svg', 'Un récit personnel lié à une mission à Milwaukee, partageant des expériences, des rencontres et des réflexions vécues au cours du parcours missionnaire.', 'available', '2026-08-18 21:00:00', '2026-08-18 21:00:00', 5),
(7, 'Minimalist Graphics', 'Julia Schonlau', '/assets/img/books/Minimalist Graphics.svg', 'Une sélection de projets de design graphique reposant sur les principes du minimalisme. L\'ouvrage présente des identités visuelles, publications et créations imprimées où la simplicité des formes et de la composition permet une communication claire et efficace.', 'available', '2026-08-19 21:00:00', '2026-08-19 21:00:00', 6),
(8, 'Hygge', 'Meik Wiking', '/assets/img/books/Hygge.svg', 'Meik Wiking explore le concept danois du hygge, associé au confort, à la convivialité et au bien-être. Le livre propose différentes façons de créer une atmosphère chaleureuse et de profiter davantage des petits plaisirs du quotidien.', 'available', '2026-08-20 21:00:00', '2026-08-20 21:00:00', 3),
(9, 'Innovation', 'Matt Ridley', '/assets/img/books/Innovation.svg', 'Matt Ridley s\'intéresse à l\'origine et au fonctionnement de l\'innovation. Il montre comment les nouvelles idées et technologies apparaissent, se diffusent et transforment progressivement nos sociétés.', 'available', '2026-08-21 21:00:00', '2026-08-21 21:00:00', 7),
(10, 'Psalms', 'Alabaster', '/assets/img/books/Psalms.svg', 'Une édition artistique du livre des Psaumes, associant le texte biblique à des illustrations et une mise en page soignée. Elle propose une lecture plus visuelle de ces textes consacrés notamment à la foi, à l\'espérance et aux émotions humaines.', 'available', '2026-08-22 21:00:00', '2026-08-22 21:00:00', 8),
(11, 'Thinking, Fast & Slow', 'Daniel Kahneman', '/assets/img/books/Thinking, Fast & Slow.svg', 'Daniel Kahneman explore les deux grands modes de pensée qui influencent nos jugements et nos décisions : l\'un rapide et intuitif, l\'autre plus lent et réfléchi. Un ouvrage de référence sur les biais cognitifs et la prise de décision.', 'unavailable', '2026-08-23 21:00:00', '2026-08-23 21:00:00', 9),
(12, 'A Book Full Of Hope', 'Rupi Kaur', '/assets/img/books/A Book Full Of Hope.svg', 'Un ouvrage poétique centré sur l\'espoir, la résilience et la possibilité de trouver de la lumière malgré les difficultés. Rupi Kaur y aborde les émotions et le cheminement personnel avec son style poétique caractéristique.', 'available', '2026-08-24 21:00:00', '2026-08-24 21:00:00', 10),
(13, 'The Subtle Art Of Not Giving a Fuck', 'Mark Manson', '/assets/img/books/The Subtle Art Of Not Giving a Fuck.svg', 'Mark Manson propose une approche directe du développement personnel : plutôt que de chercher à éviter tous les problèmes, il invite à choisir ce qui mérite réellement notre attention et à accepter les difficultés inévitables de la vie.', 'available', '2026-08-25 21:00:00', '2026-08-25 21:00:00', 11),
(14, 'Narnia', 'C.S Lewis', '/assets/img/books/Narnia.svg', 'Une grande aventure fantastique située dans le monde magique de Narnia, peuplé d\'animaux parlants, de créatures mythiques et de magie. La série suit plusieurs enfants de notre monde dans leurs aventures à travers ce royaume.', 'available', '2026-08-26 21:00:00', '2026-08-26 21:00:00', 12),
(15, 'Company Of One', 'Paul Jarvis', '/assets/img/books/Company Of One.svg', 'Paul Jarvis défend une approche différente de l\'entrepreneuriat : privilégier une entreprise volontairement petite plutôt que rechercher constamment la croissance. Le livre aborde notamment l\'indépendance, la rentabilité, la liberté et l\'équilibre entre travail et vie personnelle.', 'available', '2026-08-27 21:00:00', '2026-08-27 21:00:00', 13),
(16, 'The Two Towers', 'J.R.R Tolkien', '/assets/img/books/The Two Towers.svg', 'Deuxième partie du Seigneur des Anneaux, le récit suit les compagnons de l\'Anneau après leur séparation. Alors que Frodo et Sam poursuivent leur route vers le Mordor, leurs compagnons affrontent de nouvelles menaces au cœur de la Terre du Milieu.', 'available', '2026-08-28 21:00:00', '2026-08-28 21:00:00', 14);

-- --------------------------------------------------------

--
-- Structure de la table `conversations`
--

DROP TABLE IF EXISTS `conversations`;
CREATE TABLE IF NOT EXISTS `conversations` (
  `id_conversation` int NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_conversation`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id_message` int NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8mb4_general_ci,
  `is_read` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `id_user` int NOT NULL,
  `id_conversation` int NOT NULL,
  PRIMARY KEY (`id_message`),
  KEY `id_user` (`id_user`),
  KEY `id_conversation` (`id_conversation`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `firstname` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lastname` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `avatar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `username`, `email`, `password`, `firstname`, `lastname`, `phone`, `description`, `avatar`, `created_at`, `updated_at`) VALUES
(1, 'CamilleClubLit', 'CamilleClubLit@email.com', '$2y$10$kDOjO9d8BJPTd3z.MO4Juu.DmfUsDcIqJukfIhqU.8y4seq5dKYjG', 'Thomas', 'Martin', '06 12 34 56 78', 'Passionné de littérature et toujours à la recherche de nouvelles histoires à découvrir.', '/assets/img/pictures/alexlecture.svg', '2026-08-13 21:00:00', '2026-08-13 21:00:00'),
(2, 'Alexlecture', 'Alexlecture@email.com', '$2y$10$kDOjO9d8BJPTd3z.MO4Juu.DmfUsDcIqJukfIhqU.8y4seq5dKYjG', 'Emma', 'Bernard', '06 23 45 67 89', 'J’aime découvrir de nouveaux auteurs et partager les livres qui m’ont particulièrement marquée.', '/assets/img/pictures/default.png', '2026-08-14 21:00:00', '2026-08-14 21:00:00'),
(3, 'Hugo1990_12', 'Hugo1990_12@email.com', '$2y$10$kDOjO9d8BJPTd3z.MO4Juu.DmfUsDcIqJukfIhqU.8y4seq5dKYjG', 'Lucas', 'Petit', '06 34 56 78 90', 'Grand amateur de romans et de littérature fantastique. Je préfère échanger plutôt que laisser mes livres prendre la poussière.', '/assets/img/pictures/default.png', '2026-08-15 21:00:00', '2026-08-15 21:00:00'),
(4, 'Juju1432', 'Juju1432@email.com', '$2y$10$kDOjO9d8BJPTd3z.MO4Juu.DmfUsDcIqJukfIhqU.8y4seq5dKYjG', 'Chloé', 'Robert', '06 45 67 89 01', 'Lectrice régulière, avec une préférence pour les ouvrages autour du développement personnel et du bien-être.', '/assets/img/pictures/default.png', '2026-08-16 21:00:00', '2026-08-16 21:00:00'),
(5, 'Christiane75014', 'Christiane75014@email.com', '$2y$10$kDOjO9d8BJPTd3z.MO4Juu.DmfUsDcIqJukfIhqU.8y4seq5dKYjG', 'Nathan', 'Richard', '06 56 78 90 12', 'Je lis principalement des livres de philosophie, de réflexion et de développement personnel.', '/assets/img/pictures/default.png', '2026-08-17 21:00:00', '2026-08-17 21:00:00'),
(6, 'Hamzalecture', 'Hamzalecture@email.com', '$2y$10$kDOjO9d8BJPTd3z.MO4Juu.DmfUsDcIqJukfIhqU.8y4seq5dKYjG', 'Camille', 'Durand', '06 67 89 01 23', 'Passionnée de design, d’art et de photographie. Je cherche régulièrement de nouveaux ouvrages à découvrir.', '/assets/img/pictures/default.png', '2026-08-18 21:00:00', '2026-08-18 21:00:00'),
(7, 'Lou&Ben50', 'Lou&Ben50@email.com', '$2y$10$kDOjO9d8BJPTd3z.MO4Juu.DmfUsDcIqJukfIhqU.8y4seq5dKYjG', 'Hugo', 'Moreau', '06 78 90 12 34', 'Amateur de science, d’histoire et d’ouvrages qui permettent de mieux comprendre le monde.', '/assets/img/pictures/default.png', '2026-08-19 21:00:00', '2026-08-19 21:00:00'),
(8, 'Lolobzh', 'Lolobzh@email.com', '$2y$10$kDOjO9d8BJPTd3z.MO4Juu.DmfUsDcIqJukfIhqU.8y4seq5dKYjG', 'Léa', 'Simon', '06 89 01 23 45', 'J’aime les romans, les beaux livres et les ouvrages qui permettent de s’évader quelques heures.', '/assets/img/pictures/default.png', '2026-08-20 21:00:00', '2026-08-20 21:00:00'),
(9, 'Sas634', 'Sas634@email.com', '$2y$10$kDOjO9d8BJPTd3z.MO4Juu.DmfUsDcIqJukfIhqU.8y4seq5dKYjG', 'Maxime', 'Laurent', '07 10 23 45 67', 'Curieux de nature, je lis un peu de tout et j’aime découvrir des livres que je n’aurais pas forcément choisis moi-même.', '/assets/img/pictures/sas634.svg', '2026-08-21 21:00:00', '2026-08-21 21:00:00'),
(10, 'ML95', 'ML95@email.com', '$2y$10$kDOjO9d8BJPTd3z.MO4Juu.DmfUsDcIqJukfIhqU.8y4seq5dKYjG', 'Alice', 'Lefèvre', '07 21 34 56 78', 'Grande lectrice avec une préférence pour la poésie, les romans et les histoires intimistes.', '/assets/img/pictures/default.png', '2026-08-22 21:00:00', '2026-08-22 21:00:00'),
(11, 'Verogo33', 'Verogo33@email.com', '$2y$10$kDOjO9d8BJPTd3z.MO4Juu.DmfUsDcIqJukfIhqU.8y4seq5dKYjG', 'Gabriel', 'Michel', '07 32 45 67 89', 'Passionné par les nouvelles technologies, l’entrepreneuriat et les livres qui permettent d’apprendre de nouvelles choses.', '/assets/img/pictures/default.png', '2026-08-23 21:00:00', '2026-08-23 21:00:00'),
(12, 'AnnikaBrahms', 'AnnikaBrahms@email.com', '$2y$10$kDOjO9d8BJPTd3z.MO4Juu.DmfUsDcIqJukfIhqU.8y4seq5dKYjG', 'Sarah', 'Garcia', '07 43 56 78 90', 'J’aime particulièrement les romans fantastiques et les grandes sagas qui permettent de voyager dans d’autres univers.', '/assets/img/pictures/default.png', '2026-08-24 21:00:00', '2026-08-24 21:00:00'),
(13, 'Victoirefabr912', 'Victoirefabr912@email.com', '$2y$10$kDOjO9d8BJPTd3z.MO4Juu.DmfUsDcIqJukfIhqU.8y4seq5dKYjG', 'Antoine', 'Roux', '07 54 67 89 01', 'Lecteur occasionnel mais toujours heureux de découvrir un bon livre grâce aux échanges.', '/assets/img/pictures/default.png', '2026-08-25 21:00:00', '2026-08-25 21:00:00'),
(14, 'Lotrfanclub67', 'Lotrfanclub67@email.com', '$2y$10$kDOjO9d8BJPTd3z.MO4Juu.DmfUsDcIqJukfIhqU.8y4seq5dKYjG', 'Julie', 'Fontaine', '07 65 78 90 12', 'Passionnée de lecture et de décoration, je recherche principalement des livres qui peuvent être lus et partagés.', '/assets/img/pictures/default.png', '2026-08-26 21:00:00', '2026-08-26 21:00:00');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
