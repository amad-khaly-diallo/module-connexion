-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 05 août 2025 à 13:03
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `moduleconnexion`
--

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `logn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `profil` varchar(255) NOT NULL DEFAULT 'https://images.pexels.com/photos/11035390/pexels-photo-11035390.jpeg',
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`logn`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `logn`, `prenom`, `nom`, `pwd`, `profil`, `role`, `created_at`) VALUES
(1, 'admin@gmail.com', 'admin', 'admin', '$2y$10$pfkegvWjYYoKXXBbWQKQKOBEQLuKrtD5T7gRfV6ieHhPzJ7g2IThS', 'https://images.pexels.com/photos/189528/pexels-photo-189528.jpeg', 'admin', '2025-08-05 10:32:15'),
(9, 'amad@gmail.com', 'amad ', 'diallo', '$2y$10$dvO5VlcdNW8GVLm//oQNAexA4EZIFF2aaO/OcpEJMOfousBiRH3lO', 'uploads/6891e03fc79e1-hacker.jpg', 'user', '2025-08-05 10:36:15'),
(10, 'john@gmail.com', 'john', 'doe', '$2y$10$41vt6VDXgzz4.BIikJahL.5V.JNERnjOq2xW10cumriYmMqmUmm72', 'uploads/6891e16e3f723-johndoe.jpg', 'user', '2025-08-05 10:36:59'),
(13, 'jane@gmail.com', 'jane', 'doe', '$2y$10$1yxQxKDlfP3MHXhzAIY8w.Ob6ArlajdzwC5NAJaeMbXesv.vxHR46', 'uploads/6891ed750dd49-janedoe.jpg', 'user', '2025-08-05 11:28:45'),
(14, 'paul@mail.com', 'Paul', 'Martin', '$2y$10$AyvoSpT6cxbm4ZXp1RKO9ONobk2R34BEqWJ/b2uhRp.e3yls6KJF2', 'https://images.pexels.com/photos/11035390/pexels-photo-11035390.jpeg', 'user', '2025-08-05 12:01:11'),
(15, 'lisa@mail.com', 'Lisa', 'Durand', '$2y$10$X6BQHRL5g85H8aLsH8ey4uA/lPuXH0SLldCqqTZ/.sS6vSj5HkfRq', 'https://images.pexels.com/photos/11035390/pexels-photo-11035390.jpeg', 'user', '2025-08-05 12:01:11'),
(16, 'ali@mail.com', 'Ali', 'Ben', '$2y$10$Z5w6.ox9aWySQrI6L19Lte6n2r53tkbtSok0qAVMqf3YJ5/jVJYPq', 'https://images.pexels.com/photos/11035390/pexels-photo-11035390.jpeg', 'user', '2025-08-05 12:01:11'),
(17, 'emma@mail.com', 'Emma', 'Lemoine', '$2y$10$E6Tv8Ua5/9dCWu0DVzjW8ufpV1eyy4w.Ph0/f.hiUs7XCKPEcSC9.', 'https://images.pexels.com/photos/11035390/pexels-photo-11035390.jpeg', 'user', '2025-08-05 12:01:11'),
(18, 'samir@mail.com', 'Samir', 'Salah', '$2y$10$aLdimB62T0aEMeWBPLySgeeC6KMMWNAn9ST5/CZMbjNX7du3vu2De', 'https://images.pexels.com/photos/11035390/pexels-photo-11035390.jpeg', 'user', '2025-08-05 12:01:11'),
(19, 'sara@mail.com', 'Sara', 'Mehdi', '$2y$10$JSktStQvG0kVe4OzTRpNuuz6drr0g6X9GHKt0nvzjt3S5MLuOHOpW', 'https://images.pexels.com/photos/11035390/pexels-photo-11035390.jpeg', 'user', '2025-08-05 12:01:11'),
(20, 'noah@mail.com', 'Noah', 'Dubois', '$2y$10$l1y27.QCVw8vtth8geckn.xLMS9hx6kKg1M3t1P5Wxn1N/vOwe2c6', 'https://images.pexels.com/photos/11035390/pexels-photo-11035390.jpeg', 'user', '2025-08-05 12:01:11'),
(21, 'eva@mail.com', 'Eva', 'Moreau', '$2y$10$g.m/ghXFezNjzwyVhjrcoOpBLURXDB4uLLSuP12Q6XU6EhhRd5JiG', 'https://images.pexels.com/photos/11035390/pexels-photo-11035390.jpeg', 'user', '2025-08-05 12:01:11'),
(22, 'adam@mail.com', 'Adam', 'Nguyen', '$2y$10$H/f.d1OobG8vyjdX9m9tX.kaix3dFuP7XVa.jqhVnC/o0zSz6Btbu', 'https://images.pexels.com/photos/11035390/pexels-photo-11035390.jpeg', 'user', '2025-08-05 12:01:11'),
(23, 'lea@mail.com', 'Lea', 'Petit', '$2y$10$6QzoAeCONgInz7H4z5FrH.HHiaWZIgVuzAJ8iYHl1mxaWRPdel5Z2', 'https://images.pexels.com/photos/11035390/pexels-photo-11035390.jpeg', 'user', '2025-08-05 12:01:11');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
