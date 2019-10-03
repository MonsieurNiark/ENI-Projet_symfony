-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 03 oct. 2019 à 14:22
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projet_sortie`
--
CREATE DATABASE IF NOT EXISTS `projet_sortie` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `projet_sortie`;

-- --------------------------------------------------------

--
-- Structure de la table `etats`
--

DROP TABLE IF EXISTS `etats`;
CREATE TABLE IF NOT EXISTS `etats` (
  `no_etat` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `x_comment` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`no_etat`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `etats`
--

INSERT INTO `etats` (`no_etat`, `libelle`, `x_comment`) VALUES
(1, 'OUVERT', 'Inscriptions ouvertes'),
(2, 'FERMEE', 'Inscription \"cloturé\"'),
(3, 'NON_VISIBLE', 'Activité archivée'),
(4, 'EN_CREATION', 'En création'),
(5, 'EN_COURS', 'Activité \"En cours\"'),
(6, 'TERMINEE', 'Activité \"terminée\"'),
(7, 'ANNULEE', 'Activité \"annulée\"');

-- --------------------------------------------------------

--
-- Structure de la table `inscriptions`
--

DROP TABLE IF EXISTS `inscriptions`;
CREATE TABLE IF NOT EXISTS `inscriptions` (
  `no_inscription` int(11) NOT NULL AUTO_INCREMENT,
  `sortie_inscription_id` int(11) NOT NULL,
  `participant_inscription_id` int(11) NOT NULL,
  `date_inscription` datetime NOT NULL,
  PRIMARY KEY (`no_inscription`),
  KEY `IDX_74E0281C88BBDDA1` (`sortie_inscription_id`),
  KEY `IDX_74E0281CA4907EE4` (`participant_inscription_id`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `inscriptions`
--

INSERT INTO `inscriptions` (`no_inscription`, `sortie_inscription_id`, `participant_inscription_id`, `date_inscription`) VALUES
(38, 6, 12, '2019-10-03 09:53:00'),
(39, 6, 14, '2019-10-03 00:00:00'),
(43, 6, 12, '2019-10-03 10:01:52'),
(67, 6, 7, '2019-10-03 12:44:59'),
(71, 8, 12, '2019-10-03 12:44:59'),
(72, 8, 1, '2019-10-03 12:44:59'),
(101, 2, 12, '2019-10-03 13:37:41');

-- --------------------------------------------------------

--
-- Structure de la table `lieux`
--

DROP TABLE IF EXISTS `lieux`;
CREATE TABLE IF NOT EXISTS `lieux` (
  `no_lieu` int(11) NOT NULL AUTO_INCREMENT,
  `ville_lieu_id` int(11) NOT NULL,
  `nom_lieu` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rue` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  PRIMARY KEY (`no_lieu`),
  KEY `IDX_9E44A8AE5CA7BA70` (`ville_lieu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `lieux`
--

INSERT INTO `lieux` (`no_lieu`, `ville_lieu_id`, `nom_lieu`, `rue`, `latitude`, `longitude`) VALUES
(1, 1, 'Melocotton', '9 Rue de l\'Héronnière', NULL, -1.5617772);

-- --------------------------------------------------------

--
-- Structure de la table `participants`
--

DROP TABLE IF EXISTS `participants`;
CREATE TABLE IF NOT EXISTS `participants` (
  `no_participant` int(11) NOT NULL AUTO_INCREMENT,
  `site_participant_id` int(11) NOT NULL,
  `pseudo` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mot_de_passe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `administrateur` tinyint(1) NOT NULL,
  `actif` tinyint(1) NOT NULL,
  PRIMARY KEY (`no_participant`),
  UNIQUE KEY `UNIQ_7169709286CC499D` (`pseudo`),
  KEY `IDX_71697092DC4AE911` (`site_participant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `participants`
--

INSERT INTO `participants` (`no_participant`, `site_participant_id`, `pseudo`, `nom`, `prenom`, `telephone`, `mail`, `mot_de_passe`, `administrateur`, `actif`) VALUES
(1, 1, 'test', 'test', 'test', NULL, 'test@test.fr', '$2y$14$fafP.5IMw6fBBNY6EFPTZ.P16YrBR2B9qwwrzz9C7wG3ke.sc9K3W', 0, 1),
(7, 1, 'juju', 'Rabenarison', 'Juliette', '1234567890', 'compte_ju@compte-test.com', '$2y$14$dUm8fqq9g0nxCjn3Sa39o.nbD0wIom1dW1AtkomalZOUy.hWIxaCG', 0, 1),
(8, 2, 'romain', 'valjean', 'jean', '0123456789', 'jeanvaljean@valjean.com', '$2y$14$ZOcN/5N0jTy4.2QvkN/m9u2KMhkHdWDKjNjO/rBcImhDWHl2mECPi', 1, 1),
(12, 1, 'robyn', 'Danglos', 'Robyn', '0649126362', 'robyn.danglos@gmail.com', '$2y$14$CGuB0d/RL24kT3t6O0dZq.cL9YnEGUrhe.SqJU3XkO.TEOnPFwM0.', 0, 1),
(14, 1, 'a', 'a', 'a', 'a', 'a@a.a', '$2y$14$GZ3k/DFZ1kqanoyO5Bh8.uLa2qf1LliOki16wD88SMrs4z/mgvgxa', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `sites`
--

DROP TABLE IF EXISTS `sites`;
CREATE TABLE IF NOT EXISTS `sites` (
  `no_site` int(11) NOT NULL AUTO_INCREMENT,
  `nom_site` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`no_site`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sites`
--

INSERT INTO `sites` (`no_site`, `nom_site`) VALUES
(1, 'Nantes'),
(2, 'Bordeaux');

-- --------------------------------------------------------

--
-- Structure de la table `sorties`
--

DROP TABLE IF EXISTS `sorties`;
CREATE TABLE IF NOT EXISTS `sorties` (
  `no_sortie` int(11) NOT NULL AUTO_INCREMENT,
  `organisateur_sortie_id` int(11) NOT NULL,
  `lieu_sortie_id` int(11) NOT NULL,
  `etat_sortie_id` int(11) NOT NULL,
  `site_sortie_id` int(11) NOT NULL,
  `nom` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `datedebut` datetime NOT NULL,
  `duree` int(11) DEFAULT NULL,
  `datecloture` datetime NOT NULL,
  `nbinscriptionsmax` int(11) NOT NULL,
  `descriptioninfos` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urlPhoto` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`no_sortie`),
  KEY `IDX_488163E8F147E7E1` (`organisateur_sortie_id`),
  KEY `IDX_488163E8A31542E4` (`lieu_sortie_id`),
  KEY `IDX_488163E83CE09FBF` (`etat_sortie_id`),
  KEY `IDX_488163E8AA78AF26` (`site_sortie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sorties`
--

INSERT INTO `sorties` (`no_sortie`, `organisateur_sortie_id`, `lieu_sortie_id`, `etat_sortie_id`, `site_sortie_id`, `nom`, `datedebut`, `duree`, `datecloture`, `nbinscriptionsmax`, `descriptioninfos`, `urlPhoto`) VALUES
(2, 7, 1, 2, 2, 'Soirée plage', '2019-10-24 09:34:15', 20, '2019-10-10 11:11:29', 1, 'Soirée tranquille à la plage', NULL),
(3, 8, 1, 2, 1, 'Soirée bowling', '2019-10-10 09:34:15', 20, '2019-10-01 11:11:29', 10, 'Soirée bowling', NULL),
(4, 8, 1, 1, 1, 'Soirée bar', '2019-10-18 09:34:15', 20, '2019-10-17 11:11:29', 20, 'Soirée bar', NULL),
(5, 8, 1, 3, 1, 'Soirée bar', '2019-09-03 09:34:15', 240, '2019-08-22 11:11:29', 20, 'Soirée bar', NULL),
(6, 12, 1, 1, 1, 'Sortie au melow', '2019-10-03 00:00:00', 30, '2019-10-04 00:00:00', 10, NULL, NULL),
(7, 7, 1, 4, 2, 'Soirée bar', '2019-10-18 09:34:15', 20, '2019-10-17 11:11:29', 20, 'Soirée bar', NULL),
(8, 7, 1, 1, 1, 'Soirée Ju', '2019-10-10 09:34:15', 20, '2019-10-01 11:11:29', 10, 'Soirée ju', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `villes`
--

DROP TABLE IF EXISTS `villes`;
CREATE TABLE IF NOT EXISTS `villes` (
  `no_ville` int(11) NOT NULL AUTO_INCREMENT,
  `nom_ville` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_postal` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`no_ville`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `villes`
--

INSERT INTO `villes` (`no_ville`, `nom_ville`, `code_postal`) VALUES
(1, 'Nantes', '44000');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `inscriptions`
--
ALTER TABLE `inscriptions`
  ADD CONSTRAINT `FK_74E0281C88BBDDA1` FOREIGN KEY (`sortie_inscription_id`) REFERENCES `sorties` (`no_sortie`),
  ADD CONSTRAINT `FK_74E0281CA4907EE4` FOREIGN KEY (`participant_inscription_id`) REFERENCES `participants` (`no_participant`);

--
-- Contraintes pour la table `lieux`
--
ALTER TABLE `lieux`
  ADD CONSTRAINT `FK_9E44A8AE5CA7BA70` FOREIGN KEY (`ville_lieu_id`) REFERENCES `villes` (`no_ville`);

--
-- Contraintes pour la table `participants`
--
ALTER TABLE `participants`
  ADD CONSTRAINT `FK_71697092DC4AE911` FOREIGN KEY (`site_participant_id`) REFERENCES `sites` (`no_site`);

--
-- Contraintes pour la table `sorties`
--
ALTER TABLE `sorties`
  ADD CONSTRAINT `FK_488163E83CE09FBF` FOREIGN KEY (`etat_sortie_id`) REFERENCES `etats` (`no_etat`),
  ADD CONSTRAINT `FK_488163E8A31542E4` FOREIGN KEY (`lieu_sortie_id`) REFERENCES `lieux` (`no_lieu`),
  ADD CONSTRAINT `FK_488163E8AA78AF26` FOREIGN KEY (`site_sortie_id`) REFERENCES `sites` (`no_site`),
  ADD CONSTRAINT `FK_488163E8F147E7E1` FOREIGN KEY (`organisateur_sortie_id`) REFERENCES `participants` (`no_participant`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
