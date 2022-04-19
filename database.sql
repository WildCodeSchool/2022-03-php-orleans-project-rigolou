-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 26 Octobre 2017 à 13:53
-- Version du serveur :  5.7.19-0ubuntu0.16.04.1
-- Version de PHP :  7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `simple-mvc`
--

-- --------------------------------------------------------

--
-- Structure de la table `amusement`
--

CREATE TABLE IF NOT EXISTS `amusement` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `description` TEXT NOT NULL,
  `image` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

--
-- Contenu de la table `amusement`
--

INSERT INTO `amusement` (`name`, `description`, `image`) VALUES
('Châteaux gonflable',
'Attraction phare qui permet aux enfant de jouer en toute sécurité',
'airedejeux_chateau_gonflable.jpg'),
('Toboggans',
'Attraction phare qui permet aux enfant de jouer en toute sécurité',
'airedejeux_toboggan.jpg'),
('Flipper et baby foot',
'Attraction phare qui permet aux enfant de jouer en toute sécurité',
'airedejeux_baby_foot_flipper.jpg'),
('Auto-tamponneuses',
'Attraction phare qui permet aux enfant de jouer en toute sécurité',
'airedejeux_auto_tamponneuse.jpg'),
('Salle d''arcade',
'Attraction phare qui permet aux enfant de jouer en toute sécurité',
'airedejeux_arcade.jpg'),
('Motos',
'Attraction phare qui permet aux enfant de jouer en toute sécurité',
'airedejeux_moto.jpg');