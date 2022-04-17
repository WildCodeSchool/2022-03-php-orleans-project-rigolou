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
-- Structure de la table `rate_category`
--

CREATE TABLE `rate_category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

--
-- Contenu de la table `rate_category`
--

INSERT INTO `rate_category` (`name`) VALUES
('Classique'),
('Anniversaire'),
('Autre');

--
-- Structure de la table `rate`
--

CREATE TABLE `rate` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `description` VARCHAR(255) NOT NULL,
  `price` VARCHAR(100) NOT NULL,
  `rate_category_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_rate_rate_category`
    FOREIGN KEY (`rate_category_id`)
    REFERENCES `rate_category` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

--
-- Contenu de la table `rate`
--

INSERT INTO `rate` (`description`, `price`, `rate_category_id`) VALUES
('Mercredi, Samedi et Dimanche', '9€/pers', 1),
('Vendredi', '5,50€/pers', 1),
('Vacances scolaires', '9€/pers', 1),
('Jours fèriées', '9€/pers', 1),
('Parents', 'GRATUIT', 1),
('Comité d''entreprise: Carnet de tickets à revendre aux employés', 'Nous contacter', 1),
('Tarifs de groupes', 'Nous contacter', 1),
('Triceratops', '16,50 euros / Enfants ( 8 Enfants minimum + Présence d’un adulte Obligatoire )', 2),
('Diplodocys', '12 euros / Enfants ( 5 Enfants minimum + Présence d’un adulte Obligatoire )', 2);