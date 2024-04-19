-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 19 avr. 2024 à 12:09
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ticketsys`
--

-- --------------------------------------------------------

--
-- Structure de la table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `username`, `message`, `created_at`) VALUES
(1, 'admin', 'we we les gars', '2024-04-19 09:25:16'),
(2, 'user1', 'we ça dit quoi ?', '2024-04-19 09:25:31'),
(3, 'admin', 'alors bnp ?', '2024-04-19 09:25:53'),
(4, 'user1', 'quoi bnp?', '2024-04-19 09:26:05'),
(5, 'admin', 'salut !', '2024-04-19 09:28:48'),
(6, 'user1', 'alors ?', '2024-04-19 09:28:56');

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Admin'),
(2, 'Support'),
(3, 'User');

-- --------------------------------------------------------

--
-- Structure de la table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('Open','Closed') DEFAULT 'Open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tickets`
--

INSERT INTO `tickets` (`id`, `user_id`, `title`, `description`, `status`, `created_at`) VALUES
(1, 1, 'test', 'test', 'Open', '2024-04-19 08:25:50'),
(2, 10, 'test123', 'test123', 'Open', '2024-04-19 08:36:36'),
(3, 10, 'test123', 'test123', 'Open', '2024-04-19 08:36:49'),
(5, 10, 'problème avec le client', 'problème avec le client BNP', 'Open', '2024-04-19 08:40:45'),
(6, 10, 'Jai un problème', 'Jai un problème', 'Open', '2024-04-19 08:43:45'),
(7, 2, 'test', 'test44', 'Open', '2024-04-19 08:49:28'),
(8, 2, 'test', 'test44', 'Open', '2024-04-19 08:49:54'),
(9, 2, 'test', 'test44', 'Open', '2024-04-19 08:49:56'),
(10, 10, 'testmodif', 'test', 'Open', '2024-04-19 08:50:55'),
(11, 10, 'test', 'test', 'Open', '2024-04-19 08:51:01'),
(13, 10, 'test', 'test', 'Open', '2024-04-19 08:52:58'),
(16, 10, 'test', 'test', 'Open', '2024-04-19 09:29:36'),
(17, 1, 'test', 'test', 'Open', '2024-04-19 09:33:41'),
(18, 10, 'test', 'test', 'Open', '2024-04-19 09:33:48');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role_id`) VALUES
(1, 'admin', 'admin', 1),
(2, 'support1', 'support123', 2),
(3, 'support2', 'support456', 2),
(4, 'support3', 'support789', 2),
(5, 'support4', 'support012', 2),
(6, 'admin1', 'admin123', 1),
(7, 'admin2', 'admin456', 1),
(8, 'admin3', 'admin789', 1),
(9, 'admin4', 'admin012', 1),
(10, 'user1', 'user123', 3),
(11, 'user2', 'user456', 3),
(12, 'user3', 'user789', 3),
(13, 'user4', 'user012', 3);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
