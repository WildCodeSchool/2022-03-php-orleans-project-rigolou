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
  `category` VARCHAR(100) NOT NULL,
  `constant_category` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

--
-- Contenu de la table `rate_category`
--

INSERT INTO 
  `rate_category` (`category`, `constant_category`)
VALUES
  ('Classique', 'standard'),
  ('Anniversaire', 'anniversary');

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

INSERT INTO
  `rate` (`description`, `price`, `rate_category_id`)
VALUES
  ('Mercredi, Samedi et Dimanche', '9€/pers', 1),
  ('Vendredi', '5,50€/pers', 1),
  ('Vacances scolaires', '9€/pers', 1),
  ('Jours fèriées', '9€/pers', 1),
  ('Parents', 'GRATUIT', 1),
  ('Comité d''entreprise: Carnet de tickets à revendre aux employés', 'Nous contacter', 1),
  ('Tarifs de groupes', 'Nous contacter', 1),
  ('Triceratops', '16,50 euros / Enfants ( 8 Enfants minimum + Présence d’un adulte Obligatoire )', 2),
  ('Diplodocys', '12 euros / Enfants ( 5 Enfants minimum + Présence d’un adulte Obligatoire )', 2);


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

INSERT INTO
  `amusement` (`name`, `description`, `image`)
VALUES
  ('Châteaux gonflable',
  'Attraction phare qui permet aux enfants de jouer en toute sécurité',
  ''),
  ('Toboggans',
  'Attraction phare qui permet aux enfants de jouer en toute sécurité',
  ''),
  ('Flipper et baby foot',
  'Attraction phare qui permet aux enfants de jouer en toute sécurité',
  ''),
  ('Auto-tamponneuses',
  'Attraction phare qui permet aux enfants de jouer en toute sécurité',
  ''),
  ('Salle d''arcade',
  'Attraction phare qui permet aux enfants de jouer en toute sécurité',
  ''),
  ('Motos',
  'Attraction phare qui permet aux enfants de jouer en toute sécurité',
  '');


--
-- Structure de la table `anniversary_details`
--
CREATE TABLE IF NOT EXISTS `anniversary_detail` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `detail` VARCHAR(255) NOT NULL,
  `rate_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_anniversary_detail_1_idx` (`rate_id` ASC) VISIBLE,
  CONSTRAINT `fk_anniversary_details_1`
    FOREIGN KEY (`rate_id`)
    REFERENCES `rate` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

--
-- Contenu de la table `anniversary_detail`
--
INSERT INTO
  `anniversary_detail` (`detail`, `rate_id`) 
VALUES
  ('1 Gâteau',8),
  ('Des bonbons',8),
  ('1 Cadeau',8),
  ('1 Cartons d''invitation',8),
  ('1 Animateur de 14h à 17h',9),
  ('1 Tour de moto',9),
  ('1 Gâteau',9);

CREATE TABLE IF NOT EXISTS `cafeteria` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `price` FLOAT NOT NULL,
    `category` VARCHAR(10) NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE = InnoDB;
  
INSERT INTO
  `cafeteria` (`name`, `price`, `category`)
VALUES
  ('coca', 2.5, 'drink'),
  ('biere', 3.5, 'drink'),
  ('sandwich', 5, 'snack'),
  ('crepes', 3.5, 'snack'),
  ('pop-corn', 2.5, 'snack'),
  ('fanta', 2, 'drink'),
  ('Panache', 3, 'drink'),
  ('Brownie', 1.7, 'snack');

  CREATE TABLE IF NOT EXISTS `events` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(100) NOT NULL,
    `image` VARCHAR(100) NOT NULL,
    `description` TEXT NOT NULL,
    `date` DATE NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE = InnoDB;
  
INSERT INTO
  `events` (`title`, `image`, `description`, `date`)
VALUES
  ('noel', '', 'soirée de noel', '2025-12-31'),
  ('halloween', '', 'soiréé halloween', '2024-12-31'),
  ('paques', '', 'soirée de noel', '2023-12-31'),
  ('past1', '', 'soiréé halloween', '2020-12-31'),
  ('past2', '', 'soirée de noel', '2019-12-31'),
  ('past3', '', 'soiréé halloween', '2018-12-31');

CREATE TABLE IF NOT EXISTS `anniversary_reservation` (
  `id` INT NOT NULL AUTO_INCREMENT, 
  `reservation_date` DATE NOT NULL, 
  `firstname` VARCHAR(100) NOT NULL,
  `lastname` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(100) NOT NULL,
  `message` TEXT NOT NULL, 
  `is_accepted` TINYINT NULL,
  `rate_id` INT, 
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

INSERT INTO
  `anniversary_reservation` (`reservation_date`, `firstname`, `lastname`, `email`,`phone`, `message`)
VALUES
  ('2012-12-12', 'Fabien', 'Dupont', 'fabien.dupont@wanadoo.fr', '0765352515', 'Je viens avec mon enfant de 10 ans et ses 8 copains ');

CREATE TABLE `user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`));

INSERT INTO `user` (`email`, `password`) VALUES ('admin@rigolou.fr', '$2y$10$KKYtYA3ETd1gVtdGb10tyOogZxDyMTzJClkqTVnBlreKwbheqfHne');
