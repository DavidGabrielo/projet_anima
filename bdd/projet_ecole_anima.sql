-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 22 sep. 2023 à 00:11
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projet_ecole_anima`
--

-- --------------------------------------------------------

--
-- Structure de la table `annee_scolaire`
--

DROP TABLE IF EXISTS `annee_scolaire`;
CREATE TABLE IF NOT EXISTS `annee_scolaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `debut_annee` int(4) NOT NULL,
  `fin_annee` int(4) NOT NULL,
  `activite` int(1) NOT NULL,
  `mois_debut` varchar(20) NOT NULL,
  `nb_mois` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `classe`
--

DROP TABLE IF EXISTS `classe`;
CREATE TABLE IF NOT EXISTS `classe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classe` varchar(50) NOT NULL,
  `niveau` int(11) NOT NULL,
  `nb_eleve_max` int(11) NOT NULL,
  `categorie` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `ecolages`
--

DROP TABLE IF EXISTS `ecolages`;
CREATE TABLE IF NOT EXISTS `ecolages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `etudiant` int(250) NOT NULL,
  `mois` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

DROP TABLE IF EXISTS `inscription`;
CREATE TABLE IF NOT EXISTS `inscription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(50) NOT NULL,
  `prenom` varchar(250) NOT NULL,
  `nom` varchar(250) NOT NULL,
  `dtns` varchar(20) NOT NULL,
  `lieuns` varchar(150) NOT NULL,
  `adresse` varchar(150) NOT NULL,
  `photo` varchar(250) NOT NULL,
  `pere` varchar(250) NOT NULL,
  `profession_pere` varchar(150) NOT NULL,
  `contact_pere` varchar(50) NOT NULL,
  `mere` varchar(250) NOT NULL,
  `profession_mere` varchar(150) NOT NULL,
  `contact_mere` varchar(50) NOT NULL,
  `repondant` varchar(250) NOT NULL,
  `profession_repondant` varchar(150) NOT NULL,
  `contact_repondant` varchar(50) NOT NULL,
  `categorie` int(11) NOT NULL,
  `niveau` int(11) NOT NULL,
  `classe` int(11) NOT NULL,
  `annee` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `matieres`
--

DROP TABLE IF EXISTS `matieres`;
CREATE TABLE IF NOT EXISTS `matieres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `matieres` varchar(255) NOT NULL,
  `coeff` int(2) NOT NULL,
  `niveau` int(2) NOT NULL,
  `categorie` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `niveau`
--

DROP TABLE IF EXISTS `niveau`;
CREATE TABLE IF NOT EXISTS `niveau` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `niveau` varchar(150) NOT NULL,
  `abr` varchar(50) NOT NULL,
  `categorie` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `notes`
--

DROP TABLE IF EXISTS `notes`;
CREATE TABLE IF NOT EXISTS `notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `etudiant` int(11) NOT NULL,
  `matiere` int(11) NOT NULL,
  `interro_1` int(11) NOT NULL,
  `conf_interro_1` int(1) NOT NULL,
  `exam_1` int(11) NOT NULL,
  `conf_exam_1` int(1) NOT NULL,
  `interro_2` int(11) NOT NULL,
  `conf_interro_2` int(1) NOT NULL,
  `exam_2` int(11) NOT NULL,
  `conf_exam_2` int(1) NOT NULL,
  `interro_3` int(11) NOT NULL,
  `conf_interro_3` int(1) NOT NULL,
  `exam_3` int(11) NOT NULL,
  `conf_exam_3` int(1) NOT NULL,
  `categorie` int(11) NOT NULL,
  `niveau` int(11) NOT NULL,
  `classe` int(11) NOT NULL,
  `annee` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
