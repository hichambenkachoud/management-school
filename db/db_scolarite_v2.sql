-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 03 Mai 2017 à 21:06
-- Version du serveur :  10.1.13-MariaDB
-- Version de PHP :  5.5.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `scolarite`
--

-- --------------------------------------------------------

--
-- Structure de la table `absence`
--

CREATE TABLE `absence` (
  `id_seance` bigint(20) NOT NULL,
  `email_etudiant` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `absence`:
--   `email_etudiant`
--       `etudiant` -> `email_etudiant`
--   `id_seance`
--       `seance_cours` -> `id_seance`
--

-- --------------------------------------------------------

--
-- Structure de la table `administration`
--

CREATE TABLE `administration` (
  `code_faculte` varchar(20) NOT NULL,
  `email_utilisateur` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `administration`:
--   `code_faculte`
--       `faculte` -> `code_faculte`
--   `email_utilisateur`
--       `utilisateur` -> `email_utilisateur`
--

--
-- Contenu de la table `administration`
--

INSERT INTO `administration` (`code_faculte`, `email_utilisateur`) VALUES
('ing', 'j.akdim@mundiapolis.ma');

-- --------------------------------------------------------

--
-- Structure de la table `annee_universitaire`
--

CREATE TABLE `annee_universitaire` (
  `annee_universitaire` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `annee_universitaire`:
--

--
-- Contenu de la table `annee_universitaire`
--

INSERT INTO `annee_universitaire` (`annee_universitaire`) VALUES
('2015'),
('2016'),
('2017');

-- --------------------------------------------------------

--
-- Structure de la table `classe_groupe`
--

CREATE TABLE `classe_groupe` (
  `code_classe_groupe` varchar(20) NOT NULL,
  `libelle_classe_groupe` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `classe_groupe`:
--

--
-- Contenu de la table `classe_groupe`
--

INSERT INTO `classe_groupe` (`code_classe_groupe`, `libelle_classe_groupe`) VALUES
('1A.CI', 'Première année du cycle d''ingénieurs'),
('1A.CP.G1', 'Première année du CP (Groupe 1)'),
('1A.CP.G2', 'Première année du CP (Groupe 2)'),
('2A.CP', 'Deuxième année du CP'),
('2A.INDUS', 'Deuxième année du CI (Spécialité: INDUSTRIEL)'),
('2A.INFO', 'Deuxième année du CI (Spécialité: INFO)');

-- --------------------------------------------------------

--
-- Structure de la table `cours`
--

CREATE TABLE `cours` (
  `code_cours` varchar(20) NOT NULL,
  `code_element_module` varchar(20) NOT NULL,
  `code_referentiel` varchar(50) NOT NULL,
  `libelle_cours` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `cours`:
--   `code_element_module`
--       `element_module` -> `code_element_module`
--   `code_referentiel`
--       `referentiel` -> `code_referentiel`
--

--
-- Contenu de la table `cours`
--

INSERT INTO `cours` (`code_cours`, `code_element_module`, `code_referentiel`, `libelle_cours`) VALUES
('ANG4101.2016', 'ANG4101', '2A.INFO.S1.2016', 'Anglais 7'),
('ANG4201.2016', 'ANG4201', '2A.INFO.S2.2016', 'Anglais 8'),
('CPT4202.2016', 'CPT4202', '2A.INFO.S2.2016', 'Design Pattern et IHM'),
('GLG4102.2016', 'GLG4102', '2A.INFO.S1.2016', 'Génie Logiciel'),
('INF4201.2016', 'INF4201', '2A.INFO.S2.2016', 'Langages et Compilation');

-- --------------------------------------------------------

--
-- Structure de la table `cours_groupe`
--

CREATE TABLE `cours_groupe` (
  `code_cours` varchar(20) NOT NULL,
  `code_classe_groupe` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `cours_groupe`:
--   `code_classe_groupe`
--       `classe_groupe` -> `code_classe_groupe`
--   `code_cours`
--       `cours` -> `code_cours`
--

--
-- Contenu de la table `cours_groupe`
--

INSERT INTO `cours_groupe` (`code_cours`, `code_classe_groupe`) VALUES
('ANG4101.2016', '2A.INDUS'),
('ANG4101.2016', '2A.INFO'),
('ANG4201.2016', '2A.INDUS'),
('ANG4201.2016', '2A.INFO'),
('CPT4202.2016', '2A.INFO'),
('GLG4102.2016', '2A.INFO'),
('INF4201.2016', '2A.INFO');

-- --------------------------------------------------------

--
-- Structure de la table `cours_professeur`
--

CREATE TABLE `cours_professeur` (
  `code_cours` varchar(20) NOT NULL,
  `code_prof` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `cours_professeur`:
--   `code_cours`
--       `cours` -> `code_cours`
--   `code_prof`
--       `professeur` -> `code_prof`
--

--
-- Contenu de la table `cours_professeur`
--

INSERT INTO `cours_professeur` (`code_cours`, `code_prof`) VALUES
('ANG4101.2016', 'AKAH'),
('ANG4201.2016', 'AAMA'),
('CPT4202.2016', 'SMOU'),
('GLG4102.2016', 'SMOU'),
('INF4201.2016', 'SMOU');

-- --------------------------------------------------------

--
-- Structure de la table `element_module`
--

CREATE TABLE `element_module` (
  `code_element_module` varchar(20) NOT NULL,
  `code_module` varchar(20) NOT NULL,
  `titre_element_module` varchar(150) DEFAULT NULL,
  `vh_element_module` int(2) DEFAULT NULL,
  `coeff_element_module` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `element_module`:
--   `code_module`
--       `modules` -> `code_module`
--

--
-- Contenu de la table `element_module`
--

INSERT INTO `element_module` (`code_element_module`, `code_module`, `titre_element_module`, `vh_element_module`, `coeff_element_module`) VALUES
('ANG4101', 'ANG4101', 'Anglais 3', 24, 2),
('ANG4201', 'ANG4201', 'Anglais 4', 24, 2),
('APU4101', 'APU4101', 'Activités Para-universitaires', 30, 1),
('APU4202', 'APU4202', 'Activités Para-universitaires', 30, 1),
('BDD4201', 'BDD4201', 'Bases de données Avancées et Applications', 48, 4),
('COM4101', 'COM4101', 'Communication 3', 24, 2),
('COM4202', 'COM4201', 'Communication 4', 24, 2),
('CPT4202', 'CPT4202', 'Design Pattern et IHM ', 48, 4),
('DEV4201', 'DEV4201', 'Programmation,paralléle,concurrente et distribuée', 48, 4),
('EMB4101', 'EMB4101', 'Systémes embarqués 1', 24, 2),
('EMB4102', 'EMB4102', 'Systémes embarqués 2', 24, 2),
('EXP4102', 'EXP4102', 'Systémes d''exploitation', 48, 4),
('GLG4102', 'GLG4102', 'Génie Logiciel', 48, 4),
('INF4101', 'INF4101', 'Programmation Temps Réel', 48, 4),
('INF4201', 'INF4201', 'Langages et Compilation', 48, 4),
('JEE4102', 'JEE4102', 'Technologies Web', 48, 4),
('MGT4101', 'MGT4101', 'Eléments du droit du travail', 24, 2),
('MGT4102', 'MGT4102', 'Comptabilité et Finance ', 24, 2),
('MGT4202', 'MGT4202', 'Marketing stratégique de l''innovation', 48, 4),
('MOB4102', 'MOB4102', 'Logiciels pour Plateformes Mobiles', 48, 4),
('PMP4205', 'PMP4205', 'Plan Marketing Personnel - Pré PFE', 12, 1),
('PRJ4201', 'PRJ4201', 'Projet Logiciel', 48, 4),
('PRJ4202', 'PRJ4202', 'Projet interdisciplinaire', 48, 4),
('STG4202', 'STG4202', 'Stage 4', 99, 6);

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE `etudiant` (
  `email_etudiant` varchar(150) NOT NULL,
  `code_etudiant` varchar(20) DEFAULT NULL,
  `cne_etudiant` varchar(20) DEFAULT NULL,
  `tel_etudiant` varchar(20) DEFAULT NULL,
  `nom_etudiant` varchar(100) DEFAULT NULL,
  `prenom_etudiant` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `etudiant`:
--

--
-- Contenu de la table `etudiant`
--

INSERT INTO `etudiant` (`email_etudiant`, `code_etudiant`, `cne_etudiant`, `tel_etudiant`, `nom_etudiant`, `prenom_etudiant`) VALUES
('a.aid@mundiapolis.ma', 'a.aid', 'BJ******', '06********', 'aid', 'ayman'),
('a.amir@mundiapolis.ma', 'a.amir', 'BJ******', '06********', 'amir', 'adil'),
('a.hannachi@mundiapolis.ma', 'a.hannachi', 'BJ******', '06********', 'hannachi', 'ahmed'),
('a.kafe@mundiapolis.ma', 'a.kafe', 'BJ******', '06********', 'kafe', 'ahlam'),
('a.lokraichi@mundiapolis.ma', 'a.lokraichi', 'BJ******', '06********', 'lokraichi', 'abdelmounaim'),
('a.raiss@mundiapolis.ma', 'a.raiss', 'BJ******', '06********', 'raiss', 'abdallah'),
('b.attalbi_alami@mundiapolis.ma', 'b.attalbi_alami', 'BJ******', '06********', 'attalbi alami', 'badr eddine'),
('h.benkachoud@mundiapolis.ma', 'h.benkachoud', 'BJ******', '06********', 'benkachoud', 'hicham'),
('m.arif@mundiapolis.ma', 'm.arif', 'BJ******', '06********', 'arif', 'mohammed'),
('m.bouazar@mundiapolis.ma', 'm.bouazar', 'BJ******', '06********', 'bouazar', 'mehdi'),
('m.nakib@mundiapolis.ma', 'm.nakib', 'BJ******', '06********', 'nakib', 'mohamed mahdi'),
('o.bayare@mundiapolis.ma', 'o.bayare', 'BJ******', '06********', 'bayare', 'oussama'),
('r.elmorchadi@mundiapolis.ma', 'r.elmorchadi', 'BJ******', '06********', 'el morchadi', 'reda'),
('r.ghachi@mundiapolis.ma', 'r.ghachi', 'BJ******', '06********', 'el ghachi', 'rachid'),
('s.tayane@mundiapolis.ma', 's.tayane', 'BJ******', '06********', 'tayane', 'soufiane'),
('s.wahid@mundiapolis.ma', 's.wahid', 'BJ******', '06********', 'wahid', 'salwa'),
('t.joudary@mundiapolis.ma', 't.joudary', 'BJ******', '06********', 'joudary', 'taha'),
('t.souaidi@mundiapolis.ma', 't.souaidi', 'BJ******', '06********', 'souaidi', 'tarik');

-- --------------------------------------------------------

--
-- Structure de la table `faculte`
--

CREATE TABLE `faculte` (
  `code_faculte` varchar(20) NOT NULL,
  `libelle_faculte` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `faculte`:
--

--
-- Contenu de la table `faculte`
--

INSERT INTO `faculte` (`code_faculte`, `libelle_faculte`) VALUES
('ing', 'Ecole d''ingénieurs'),
('mgt', 'Faculté de management'),
('snt', 'Faculté de santé');

-- --------------------------------------------------------

--
-- Structure de la table `filiere`
--

CREATE TABLE `filiere` (
  `code_filiere` varchar(20) NOT NULL,
  `code_faculte` varchar(20) NOT NULL,
  `libelle_filiere` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `filiere`:
--   `code_faculte`
--       `faculte` -> `code_faculte`
--

--
-- Contenu de la table `filiere`
--

INSERT INTO `filiere` (`code_filiere`, `code_faculte`, `libelle_filiere`) VALUES
('ci', 'ing', 'Cycle Ingénieur'),
('cp', 'ing', 'Cycle préparatoire'),
('gaero', 'ing', 'Génie des systèmes aéronautiques'),
('gind', 'ing', 'Génie industriel'),
('ginfo', 'ing', 'Génie informatique'),
('laero', 'ing', 'Licence professionnelle en Génie de la logistique aéronautique'),
('rta', 'ing', 'Réseaux et télécommunications avancées');

-- --------------------------------------------------------

--
-- Structure de la table `groupe_etudiant`
--

CREATE TABLE `groupe_etudiant` (
  `code_classe_groupe` varchar(20) NOT NULL,
  `email_etudiant` varchar(150) NOT NULL,
  `code_referentiel` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `groupe_etudiant`:
--   `code_classe_groupe`
--       `classe_groupe` -> `code_classe_groupe`
--   `code_referentiel`
--       `referentiel` -> `code_referentiel`
--   `email_etudiant`
--       `etudiant` -> `email_etudiant`
--

--
-- Contenu de la table `groupe_etudiant`
--

INSERT INTO `groupe_etudiant` (`code_classe_groupe`, `email_etudiant`, `code_referentiel`) VALUES
('2A.INFO', 'a.aid@mundiapolis.ma', '2A.INFO.S1.2016'),
('2A.INFO', 'a.aid@mundiapolis.ma', '2A.INFO.S2.2016'),
('2A.INFO', 'a.amir@mundiapolis.ma', '2A.INFO.S1.2016'),
('2A.INFO', 'a.amir@mundiapolis.ma', '2A.INFO.S2.2016'),
('2A.INFO', 'a.hannachi@mundiapolis.ma', '2A.INFO.S1.2016'),
('2A.INFO', 'a.hannachi@mundiapolis.ma', '2A.INFO.S2.2016'),
('2A.INFO', 'a.kafe@mundiapolis.ma', '2A.INFO.S1.2016'),
('2A.INFO', 'a.kafe@mundiapolis.ma', '2A.INFO.S2.2016'),
('2A.INFO', 'a.lokraichi@mundiapolis.ma', '2A.INFO.S1.2016'),
('2A.INFO', 'a.lokraichi@mundiapolis.ma', '2A.INFO.S2.2016'),
('2A.INFO', 'a.raiss@mundiapolis.ma', '2A.INFO.S1.2016'),
('2A.INFO', 'a.raiss@mundiapolis.ma', '2A.INFO.S2.2016'),
('2A.INFO', 'b.attalbi_alami@mundiapolis.ma', '2A.INFO.S1.2016'),
('2A.INFO', 'b.attalbi_alami@mundiapolis.ma', '2A.INFO.S2.2016'),
('2A.INFO', 'h.benkachoud@mundiapolis.ma', '2A.INFO.S1.2016'),
('2A.INFO', 'h.benkachoud@mundiapolis.ma', '2A.INFO.S2.2016'),
('2A.INFO', 'm.arif@mundiapolis.ma', '2A.INFO.S1.2016'),
('2A.INFO', 'm.arif@mundiapolis.ma', '2A.INFO.S2.2016'),
('2A.INFO', 'm.bouazar@mundiapolis.ma', '2A.INFO.S1.2016'),
('2A.INFO', 'm.bouazar@mundiapolis.ma', '2A.INFO.S2.2016'),
('2A.INFO', 'm.nakib@mundiapolis.ma', '2A.INFO.S1.2016'),
('2A.INFO', 'm.nakib@mundiapolis.ma', '2A.INFO.S2.2016'),
('2A.INFO', 'o.bayare@mundiapolis.ma', '2A.INFO.S1.2016'),
('2A.INFO', 'o.bayare@mundiapolis.ma', '2A.INFO.S2.2016'),
('2A.INFO', 'r.elmorchadi@mundiapolis.ma', '2A.INFO.S1.2016'),
('2A.INFO', 'r.elmorchadi@mundiapolis.ma', '2A.INFO.S2.2016'),
('2A.INFO', 'r.ghachi@mundiapolis.ma', '2A.INFO.S1.2016'),
('2A.INFO', 'r.ghachi@mundiapolis.ma', '2A.INFO.S2.2016'),
('2A.INFO', 's.tayane@mundiapolis.ma', '2A.INFO.S1.2016'),
('2A.INFO', 's.tayane@mundiapolis.ma', '2A.INFO.S2.2016'),
('2A.INFO', 's.wahid@mundiapolis.ma', '2A.INFO.S1.2016'),
('2A.INFO', 's.wahid@mundiapolis.ma', '2A.INFO.S2.2016'),
('2A.INFO', 't.joudary@mundiapolis.ma', '2A.INFO.S1.2016'),
('2A.INFO', 't.joudary@mundiapolis.ma', '2A.INFO.S2.2016'),
('2A.INFO', 't.souaidi@mundiapolis.ma', '2A.INFO.S1.2016'),
('2A.INFO', 't.souaidi@mundiapolis.ma', '2A.INFO.S2.2016');

-- --------------------------------------------------------

--
-- Structure de la table `modules`
--

CREATE TABLE `modules` (
  `code_module` varchar(20) NOT NULL,
  `titre_module` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `modules`:
--

--
-- Contenu de la table `modules`
--

INSERT INTO `modules` (`code_module`, `titre_module`) VALUES
('ANG4101', 'Anglais 3'),
('ANG4201', 'Anglais 4'),
('APU4101', 'Activités Para-universitaires'),
('APU4202', 'Activités Para-universitaires'),
('BDD4201', 'Bases de données Avancées et Applications'),
('COM4101', 'Communication 3'),
('COM4201', 'Communication 4'),
('CPT4202', 'Design Pattern et IHM '),
('DEV4201', 'Programmation, paralléle, concurrente et distribuée\r\n'),
('EMB4101', 'Systémes embarqués 1'),
('EMB4102', 'Systémes embarqués 2'),
('EXP4102', 'Systémes d''exploitation'),
('GLG4102', 'Génie Logiciel'),
('INF4101', 'Programmation Temps Réel'),
('INF4201', 'Langages et Compilation'),
('JEE4102', 'Technologies Web'),
('MGT4101', 'Eléments du droit du travail'),
('MGT4102', 'Comptabilité et Finance '),
('MGT4202', 'Marketing stratégique de l''innovation'),
('MOB4102', 'Logiciels pour Plateformes Mobiles'),
('PMP4205', 'Plan Marketing Personnel - Pré PFE'),
('PRJ4201', 'Projet Logiciel'),
('PRJ4202', 'Projet interdisciplinaire'),
('STG4202', 'Stage 4');

-- --------------------------------------------------------

--
-- Structure de la table `niveau`
--

CREATE TABLE `niveau` (
  `code_niveau` varchar(20) NOT NULL,
  `libelle_niveau` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `niveau`:
--

--
-- Contenu de la table `niveau`
--

INSERT INTO `niveau` (`code_niveau`, `libelle_niveau`) VALUES
('1A.CI', 'Première année du cycle d''ingénieurs'),
('1A.CP', 'Première année du cycle préparatoire'),
('2A.AERO', 'Deuxième année du cycle d''ingénieurs (Spécialité:AERO)'),
('2A.CP', 'Dexième année du cycle préparatoire'),
('2A.INDUS', 'Deuxième année du cycle d''ingénieurs (Spécialité:IDUSTRIEL)'),
('2A.INFO', 'Deuxième année du cycle d''ingénieurs (Spécialité:INFO)');

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

CREATE TABLE `note` (
  `code_cours` varchar(20) NOT NULL,
  `code_type_test` varchar(20) NOT NULL,
  `email_etudiant` varchar(150) NOT NULL,
  `note` decimal(4,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `note`:
--   `code_cours`
--       `cours` -> `code_cours`
--   `code_type_test`
--       `type_test` -> `code_type_test`
--   `email_etudiant`
--       `etudiant` -> `email_etudiant`
--

--
-- Contenu de la table `note`
--

INSERT INTO `note` (`code_cours`, `code_type_test`, `email_etudiant`, `note`) VALUES
('CPT4202.2016', 'CC', 'a.aid@mundiapolis.ma', '12.00'),
('CPT4202.2016', 'CC', 'a.amir@mundiapolis.ma', '12.00'),
('CPT4202.2016', 'CC', 'a.hannachi@mundiapolis.ma', '12.00'),
('CPT4202.2016', 'CC', 'a.kafe@mundiapolis.ma', '12.00'),
('CPT4202.2016', 'CC', 'a.lokraichi@mundiapolis.ma', '12.00'),
('CPT4202.2016', 'CC', 'a.raiss@mundiapolis.ma', '12.00'),
('CPT4202.2016', 'CC', 'b.attalbi_alami@mundiapolis.ma', '12.00'),
('CPT4202.2016', 'CC', 'h.benkachoud@mundiapolis.ma', '12.00'),
('CPT4202.2016', 'CC', 'm.arif@mundiapolis.ma', '12.00'),
('CPT4202.2016', 'CC', 'm.bouazar@mundiapolis.ma', '12.00'),
('CPT4202.2016', 'CC', 'm.nakib@mundiapolis.ma', '12.00'),
('CPT4202.2016', 'CC', 'o.bayare@mundiapolis.ma', '12.00'),
('CPT4202.2016', 'CC', 'r.elmorchadi@mundiapolis.ma', '12.00'),
('CPT4202.2016', 'CC', 'r.ghachi@mundiapolis.ma', '12.00'),
('CPT4202.2016', 'CC', 's.tayane@mundiapolis.ma', '12.00'),
('CPT4202.2016', 'CC', 's.wahid@mundiapolis.ma', '12.00'),
('CPT4202.2016', 'CC', 't.joudary@mundiapolis.ma', '12.00'),
('CPT4202.2016', 'CC', 't.souaidi@mundiapolis.ma', '12.00'),
('CPT4202.2016', 'EF', 'a.aid@mundiapolis.ma', '15.00'),
('CPT4202.2016', 'EF', 'a.amir@mundiapolis.ma', '15.00'),
('CPT4202.2016', 'EF', 'a.hannachi@mundiapolis.ma', '15.00'),
('CPT4202.2016', 'EF', 'a.kafe@mundiapolis.ma', '15.00'),
('CPT4202.2016', 'EF', 'a.lokraichi@mundiapolis.ma', '15.00'),
('CPT4202.2016', 'EF', 'a.raiss@mundiapolis.ma', '15.00'),
('CPT4202.2016', 'EF', 'b.attalbi_alami@mundiapolis.ma', '15.00'),
('CPT4202.2016', 'EF', 'h.benkachoud@mundiapolis.ma', '15.00'),
('CPT4202.2016', 'EF', 'm.arif@mundiapolis.ma', '15.00'),
('CPT4202.2016', 'EF', 'm.bouazar@mundiapolis.ma', '15.00'),
('CPT4202.2016', 'EF', 'm.nakib@mundiapolis.ma', '15.00'),
('CPT4202.2016', 'EF', 'o.bayare@mundiapolis.ma', '15.00'),
('CPT4202.2016', 'EF', 'r.elmorchadi@mundiapolis.ma', '15.00'),
('CPT4202.2016', 'EF', 'r.ghachi@mundiapolis.ma', '15.00'),
('CPT4202.2016', 'EF', 's.tayane@mundiapolis.ma', '15.00'),
('CPT4202.2016', 'EF', 's.wahid@mundiapolis.ma', '15.00'),
('CPT4202.2016', 'EF', 't.joudary@mundiapolis.ma', '15.00'),
('CPT4202.2016', 'EF', 't.souaidi@mundiapolis.ma', '15.00'),
('CPT4202.2016', 'PRJ', 'a.aid@mundiapolis.ma', '13.00'),
('CPT4202.2016', 'PRJ', 'a.amir@mundiapolis.ma', '13.00'),
('CPT4202.2016', 'PRJ', 'a.hannachi@mundiapolis.ma', '13.00'),
('CPT4202.2016', 'PRJ', 'a.kafe@mundiapolis.ma', '13.00'),
('CPT4202.2016', 'PRJ', 'a.lokraichi@mundiapolis.ma', '13.00'),
('CPT4202.2016', 'PRJ', 'a.raiss@mundiapolis.ma', '13.00'),
('CPT4202.2016', 'PRJ', 'b.attalbi_alami@mundiapolis.ma', '13.00'),
('CPT4202.2016', 'PRJ', 'h.benkachoud@mundiapolis.ma', '13.00'),
('CPT4202.2016', 'PRJ', 'm.arif@mundiapolis.ma', '13.00'),
('CPT4202.2016', 'PRJ', 'm.bouazar@mundiapolis.ma', '13.00'),
('CPT4202.2016', 'PRJ', 'm.nakib@mundiapolis.ma', '13.00'),
('CPT4202.2016', 'PRJ', 'o.bayare@mundiapolis.ma', '13.00'),
('CPT4202.2016', 'PRJ', 'r.elmorchadi@mundiapolis.ma', '13.00'),
('CPT4202.2016', 'PRJ', 'r.ghachi@mundiapolis.ma', '13.00'),
('CPT4202.2016', 'PRJ', 's.tayane@mundiapolis.ma', '13.00'),
('CPT4202.2016', 'PRJ', 's.wahid@mundiapolis.ma', '13.00'),
('CPT4202.2016', 'PRJ', 't.joudary@mundiapolis.ma', '13.00'),
('CPT4202.2016', 'PRJ', 't.souaidi@mundiapolis.ma', '13.00'),
('GLG4102.2016', 'CC', 'a.aid@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'CC', 'a.amir@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'CC', 'a.hannachi@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'CC', 'a.kafe@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'CC', 'a.lokraichi@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'CC', 'a.raiss@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'CC', 'b.attalbi_alami@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'CC', 'h.benkachoud@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'CC', 'm.arif@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'CC', 'm.bouazar@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'CC', 'm.nakib@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'CC', 'o.bayare@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'CC', 'r.elmorchadi@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'CC', 'r.ghachi@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'CC', 's.tayane@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'CC', 's.wahid@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'CC', 't.joudary@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'CC', 't.souaidi@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'EF', 'a.aid@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'EF', 'a.amir@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'EF', 'a.hannachi@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'EF', 'a.kafe@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'EF', 'a.lokraichi@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'EF', 'a.raiss@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'EF', 'b.attalbi_alami@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'EF', 'h.benkachoud@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'EF', 'm.arif@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'EF', 'm.bouazar@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'EF', 'm.nakib@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'EF', 'o.bayare@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'EF', 'r.elmorchadi@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'EF', 'r.ghachi@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'EF', 's.tayane@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'EF', 's.wahid@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'EF', 't.joudary@mundiapolis.ma', '0.00'),
('GLG4102.2016', 'EF', 't.souaidi@mundiapolis.ma', '0.00'),
('INF4201.2016', 'EF', 'a.aid@mundiapolis.ma', '17.00'),
('INF4201.2016', 'EF', 'a.amir@mundiapolis.ma', '17.00'),
('INF4201.2016', 'EF', 'a.hannachi@mundiapolis.ma', '17.00'),
('INF4201.2016', 'EF', 'a.kafe@mundiapolis.ma', '17.00'),
('INF4201.2016', 'EF', 'a.lokraichi@mundiapolis.ma', '17.00'),
('INF4201.2016', 'EF', 'a.raiss@mundiapolis.ma', '17.00'),
('INF4201.2016', 'EF', 'b.attalbi_alami@mundiapolis.ma', '17.00'),
('INF4201.2016', 'EF', 'h.benkachoud@mundiapolis.ma', '17.00'),
('INF4201.2016', 'EF', 'm.arif@mundiapolis.ma', '17.00'),
('INF4201.2016', 'EF', 'm.bouazar@mundiapolis.ma', '17.00'),
('INF4201.2016', 'EF', 'm.nakib@mundiapolis.ma', '17.00'),
('INF4201.2016', 'EF', 'o.bayare@mundiapolis.ma', '17.00'),
('INF4201.2016', 'EF', 'r.elmorchadi@mundiapolis.ma', '17.00'),
('INF4201.2016', 'EF', 'r.ghachi@mundiapolis.ma', '17.00'),
('INF4201.2016', 'EF', 's.tayane@mundiapolis.ma', '17.00'),
('INF4201.2016', 'EF', 's.wahid@mundiapolis.ma', '17.00'),
('INF4201.2016', 'EF', 't.joudary@mundiapolis.ma', '17.00'),
('INF4201.2016', 'EF', 't.souaidi@mundiapolis.ma', '17.00');

-- --------------------------------------------------------

--
-- Structure de la table `note_rattrapage`
--

CREATE TABLE `note_rattrapage` (
  `code_cours` varchar(20) NOT NULL,
  `email_etudiant` varchar(150) NOT NULL,
  `note_ratrapage` decimal(2,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `note_rattrapage`:
--   `code_cours`
--       `cours` -> `code_cours`
--   `email_etudiant`
--       `etudiant` -> `email_etudiant`
--

-- --------------------------------------------------------

--
-- Structure de la table `parametres_annee`
--

CREATE TABLE `parametres_annee` (
  `annee` varchar(50) NOT NULL,
  `date_debut_s1` date NOT NULL,
  `date_fin_s1` date NOT NULL,
  `date_debut_s2` date NOT NULL,
  `date_fin_s2` date NOT NULL,
  `semestre_en_cours` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `parametres_annee`:
--

--
-- Contenu de la table `parametres_annee`
--

INSERT INTO `parametres_annee` (`annee`, `date_debut_s1`, `date_fin_s1`, `date_debut_s2`, `date_fin_s2`, `semestre_en_cours`) VALUES
('2016', '2016-09-25', '2017-01-31', '2017-02-05', '2017-06-30', 'S2');

-- --------------------------------------------------------

--
-- Structure de la table `professeur`
--

CREATE TABLE `professeur` (
  `code_prof` varchar(20) NOT NULL,
  `nom_prof` varchar(150) DEFAULT NULL,
  `prenom_prof` varchar(150) DEFAULT NULL,
  `initial_prof` varchar(10) DEFAULT NULL,
  `email_prof` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `professeur`:
--

--
-- Contenu de la table `professeur`
--

INSERT INTO `professeur` (`code_prof`, `nom_prof`, `prenom_prof`, `initial_prof`, `email_prof`) VALUES
('AAMA', 'AMANA', 'Abdennasser', 'AA', 'a.amana@mundiapolis.ma'),
('AKAH', 'KAHLAOUI', 'Abdelilah', 'AK', 'a.kahlaoui@mundiapolis.ma'),
('FMAS', 'MASTOUR', 'Fatima', 'FM', 'f.mastour@mundiapolis.ma'),
('SMOU', 'MOUCHAWRAB', 'Samar', 'SM', 's.mouchawrab@mundiapolis.ma');

-- --------------------------------------------------------

--
-- Structure de la table `profil`
--

CREATE TABLE `profil` (
  `code_profil` varchar(20) NOT NULL,
  `libelle_profil` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `profil`:
--

--
-- Contenu de la table `profil`
--

INSERT INTO `profil` (`code_profil`, `libelle_profil`) VALUES
('staff', 'Agent d''administration');

-- --------------------------------------------------------

--
-- Structure de la table `referenciel_etudiant`
--

CREATE TABLE `referenciel_etudiant` (
  `email_etudiant` varchar(150) NOT NULL,
  `code_referentiel` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `referenciel_etudiant`:
--   `code_referentiel`
--       `referentiel` -> `code_referentiel`
--   `email_etudiant`
--       `etudiant` -> `email_etudiant`
--

--
-- Contenu de la table `referenciel_etudiant`
--

INSERT INTO `referenciel_etudiant` (`email_etudiant`, `code_referentiel`) VALUES
('a.aid@mundiapolis.ma', '2A.INFO.S1.2016'),
('a.amir@mundiapolis.ma', '2A.INFO.S1.2016'),
('a.hannachi@mundiapolis.ma', '2A.INFO.S1.2016'),
('a.kafe@mundiapolis.ma', '2A.INFO.S1.2016'),
('a.lokraichi@mundiapolis.ma', '2A.INFO.S1.2016'),
('a.raiss@mundiapolis.ma', '2A.INFO.S1.2016'),
('b.attalbi_alami@mundiapolis.ma', '2A.INFO.S1.2016'),
('h.benkachoud@mundiapolis.ma', '2A.INFO.S1.2016'),
('m.arif@mundiapolis.ma', '2A.INFO.S1.2016'),
('m.bouazar@mundiapolis.ma', '2A.INFO.S1.2016'),
('m.nakib@mundiapolis.ma', '2A.INFO.S1.2016'),
('o.bayare@mundiapolis.ma', '2A.INFO.S1.2016'),
('r.elmorchadi@mundiapolis.ma', '2A.INFO.S1.2016'),
('r.ghachi@mundiapolis.ma', '2A.INFO.S1.2016'),
('s.tayane@mundiapolis.ma', '2A.INFO.S1.2016'),
('s.wahid@mundiapolis.ma', '2A.INFO.S1.2016'),
('t.joudary@mundiapolis.ma', '2A.INFO.S1.2016'),
('t.souaidi@mundiapolis.ma', '2A.INFO.S1.2016'),
('a.aid@mundiapolis.ma', '2A.INFO.S2.2016'),
('a.amir@mundiapolis.ma', '2A.INFO.S2.2016'),
('a.hannachi@mundiapolis.ma', '2A.INFO.S2.2016'),
('a.kafe@mundiapolis.ma', '2A.INFO.S2.2016'),
('a.lokraichi@mundiapolis.ma', '2A.INFO.S2.2016'),
('a.raiss@mundiapolis.ma', '2A.INFO.S2.2016'),
('b.attalbi_alami@mundiapolis.ma', '2A.INFO.S2.2016'),
('h.benkachoud@mundiapolis.ma', '2A.INFO.S2.2016'),
('m.arif@mundiapolis.ma', '2A.INFO.S2.2016'),
('m.bouazar@mundiapolis.ma', '2A.INFO.S2.2016'),
('m.nakib@mundiapolis.ma', '2A.INFO.S2.2016'),
('o.bayare@mundiapolis.ma', '2A.INFO.S2.2016'),
('r.elmorchadi@mundiapolis.ma', '2A.INFO.S2.2016'),
('r.ghachi@mundiapolis.ma', '2A.INFO.S2.2016'),
('s.tayane@mundiapolis.ma', '2A.INFO.S2.2016'),
('s.wahid@mundiapolis.ma', '2A.INFO.S2.2016'),
('t.joudary@mundiapolis.ma', '2A.INFO.S2.2016'),
('t.souaidi@mundiapolis.ma', '2A.INFO.S2.2016');

-- --------------------------------------------------------

--
-- Structure de la table `referenciel_evaluation`
--

CREATE TABLE `referenciel_evaluation` (
  `code_referentiel` varchar(50) NOT NULL,
  `code_element_module` varchar(20) NOT NULL,
  `code_type_test` varchar(20) NOT NULL,
  `pourcentage_test` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `referenciel_evaluation`:
--   `code_referentiel`
--       `referentiel` -> `code_referentiel`
--   `code_type_test`
--       `type_test` -> `code_type_test`
--   `code_element_module`
--       `element_module` -> `code_element_module`
--

--
-- Contenu de la table `referenciel_evaluation`
--

INSERT INTO `referenciel_evaluation` (`code_referentiel`, `code_element_module`, `code_type_test`, `pourcentage_test`) VALUES
('2A.INFO.S1.2016', 'GLG4102', 'CC', '40.00'),
('2A.INFO.S1.2016', 'GLG4102', 'EF', '60.00'),
('2A.INFO.S2.2016', 'CPT4202', 'CC', '20.00'),
('2A.INFO.S2.2016', 'CPT4202', 'EF', '50.00'),
('2A.INFO.S2.2016', 'CPT4202', 'PRJ', '30.00'),
('2A.INFO.S2.2016', 'INF4201', 'EF', '100.00');

-- --------------------------------------------------------

--
-- Structure de la table `referentiel`
--

CREATE TABLE `referentiel` (
  `code_referentiel` varchar(50) NOT NULL,
  `code_filiere` varchar(20) NOT NULL,
  `code_niveau` varchar(20) NOT NULL,
  `code_semestre` varchar(20) NOT NULL,
  `annee_universitaire` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `referentiel`:
--   `annee_universitaire`
--       `annee_universitaire` -> `annee_universitaire`
--   `code_filiere`
--       `filiere` -> `code_filiere`
--   `code_niveau`
--       `niveau` -> `code_niveau`
--   `code_semestre`
--       `semestre` -> `code_semestre`
--

--
-- Contenu de la table `referentiel`
--

INSERT INTO `referentiel` (`code_referentiel`, `code_filiere`, `code_niveau`, `code_semestre`, `annee_universitaire`) VALUES
('1A.CI.S1.2016', 'ci', '1A.CI', 'S1', '2016'),
('1A.CI.S2.2016', 'ci', '1A.CI', 'S2', '2016'),
('1A.CP.S1.2016', 'cp', '1A.CP', 'S1', '2016'),
('1A.CP.S2.2016', 'cp', '1A.CP', 'S2', '2016'),
('2A.CP.S1.2016', 'cp', '2A.CP', 'S1', '2016'),
('2A.CP.S2.2016', 'cp', '2A.CP', 'S2', '2016'),
('2A.INFO.S1.2016', 'ginfo', '2A.INFO', 'S1', '2016'),
('2A.INFO.S2.2016', 'ginfo', '2A.INFO', 'S2', '2016');

-- --------------------------------------------------------

--
-- Structure de la table `seance_cours`
--

CREATE TABLE `seance_cours` (
  `id_seance` bigint(20) NOT NULL,
  `code_cours` varchar(20) NOT NULL,
  `date_absence` date NOT NULL,
  `hd_seance` time NOT NULL,
  `hf_seance` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `seance_cours`:
--   `code_cours`
--       `cours` -> `code_cours`
--

-- --------------------------------------------------------

--
-- Structure de la table `semestre`
--

CREATE TABLE `semestre` (
  `code_semestre` varchar(20) NOT NULL,
  `libelle_semestre` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `semestre`:
--

--
-- Contenu de la table `semestre`
--

INSERT INTO `semestre` (`code_semestre`, `libelle_semestre`) VALUES
('S1', 'Semestre 1'),
('S2', 'Semestre 2');

-- --------------------------------------------------------

--
-- Structure de la table `type_test`
--

CREATE TABLE `type_test` (
  `code_type_test` varchar(20) NOT NULL,
  `libelle_type_test` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `type_test`:
--

--
-- Contenu de la table `type_test`
--

INSERT INTO `type_test` (`code_type_test`, `libelle_type_test`) VALUES
('CC', 'Contrôle Continu'),
('EF', 'Examen Final'),
('PFE', 'Projet Fin Etude'),
('PRJ', 'Projet'),
('STG', 'Stage');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `email_utilisateur` varchar(150) NOT NULL,
  `code_profil` varchar(20) NOT NULL,
  `nom_utilisateur` varchar(100) DEFAULT NULL,
  `prenom_utilisateur` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS POUR LA TABLE `utilisateur`:
--   `code_profil`
--       `profil` -> `code_profil`
--

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`email_utilisateur`, `code_profil`, `nom_utilisateur`, `prenom_utilisateur`) VALUES
('d.benhammou@mundiapolis.ma', 'staff', 'Benhammou', 'Dounia'),
('j.akdim@mundiapolis.ma', 'staff', 'Jamila', 'Akdim');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `absence`
--
ALTER TABLE `absence`
  ADD PRIMARY KEY (`id_seance`,`email_etudiant`),
  ADD KEY `FK_ETUDIANT` (`email_etudiant`);

--
-- Index pour la table `administration`
--
ALTER TABLE `administration`
  ADD PRIMARY KEY (`code_faculte`,`email_utilisateur`),
  ADD KEY `FK_administration_email_utilisateur` (`email_utilisateur`);

--
-- Index pour la table `annee_universitaire`
--
ALTER TABLE `annee_universitaire`
  ADD PRIMARY KEY (`annee_universitaire`);

--
-- Index pour la table `classe_groupe`
--
ALTER TABLE `classe_groupe`
  ADD PRIMARY KEY (`code_classe_groupe`);

--
-- Index pour la table `cours`
--
ALTER TABLE `cours`
  ADD PRIMARY KEY (`code_cours`),
  ADD KEY `FK_faire_objet_code_cours` (`code_cours`),
  ADD KEY `FK_faire_objet_code_referentiel` (`code_referentiel`),
  ADD KEY `FK_faire_objet_code_element_module` (`code_element_module`);

--
-- Index pour la table `cours_groupe`
--
ALTER TABLE `cours_groupe`
  ADD PRIMARY KEY (`code_cours`,`code_classe_groupe`),
  ADD KEY `FK_suivre_code_classe_groupe` (`code_classe_groupe`);

--
-- Index pour la table `cours_professeur`
--
ALTER TABLE `cours_professeur`
  ADD PRIMARY KEY (`code_cours`,`code_prof`),
  ADD UNIQUE KEY `code_cours` (`code_cours`),
  ADD KEY `FK_donner_code_prof` (`code_prof`);

--
-- Index pour la table `element_module`
--
ALTER TABLE `element_module`
  ADD PRIMARY KEY (`code_element_module`),
  ADD KEY `FK_module_element_module` (`code_module`);

--
-- Index pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`email_etudiant`);

--
-- Index pour la table `faculte`
--
ALTER TABLE `faculte`
  ADD PRIMARY KEY (`code_faculte`);

--
-- Index pour la table `filiere`
--
ALTER TABLE `filiere`
  ADD PRIMARY KEY (`code_filiere`),
  ADD KEY `FK_filiere_code_faculte` (`code_faculte`);

--
-- Index pour la table `groupe_etudiant`
--
ALTER TABLE `groupe_etudiant`
  ADD PRIMARY KEY (`code_classe_groupe`,`email_etudiant`,`code_referentiel`),
  ADD KEY `FK_appartenir_email_etudiant` (`email_etudiant`),
  ADD KEY `FK_appartenir_code_referentiel` (`code_referentiel`);

--
-- Index pour la table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`code_module`);

--
-- Index pour la table `niveau`
--
ALTER TABLE `niveau`
  ADD PRIMARY KEY (`code_niveau`);

--
-- Index pour la table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`code_cours`,`code_type_test`,`email_etudiant`),
  ADD KEY `FK_note_normale_code_type_test` (`code_type_test`),
  ADD KEY `FK_note_normale_email_etudiant` (`email_etudiant`);

--
-- Index pour la table `note_rattrapage`
--
ALTER TABLE `note_rattrapage`
  ADD PRIMARY KEY (`code_cours`,`email_etudiant`),
  ADD KEY `FK_note_rattrapage_email_etudiant` (`email_etudiant`);

--
-- Index pour la table `parametres_annee`
--
ALTER TABLE `parametres_annee`
  ADD PRIMARY KEY (`annee`);

--
-- Index pour la table `professeur`
--
ALTER TABLE `professeur`
  ADD PRIMARY KEY (`code_prof`);

--
-- Index pour la table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`code_profil`);

--
-- Index pour la table `referenciel_etudiant`
--
ALTER TABLE `referenciel_etudiant`
  ADD PRIMARY KEY (`code_referentiel`,`email_etudiant`),
  ADD KEY `FK_associer_5_email_etudiant` (`email_etudiant`);

--
-- Index pour la table `referenciel_evaluation`
--
ALTER TABLE `referenciel_evaluation`
  ADD PRIMARY KEY (`code_referentiel`,`code_element_module`,`code_type_test`),
  ADD KEY `FK_faire_reference_a_id_element_module` (`code_element_module`),
  ADD KEY `FK_faire_reference_a_code_type_test` (`code_type_test`);

--
-- Index pour la table `referentiel`
--
ALTER TABLE `referentiel`
  ADD PRIMARY KEY (`code_referentiel`),
  ADD KEY `FK_referentiel_code_filiere` (`code_filiere`),
  ADD KEY `FK_referentiel_code_niveau` (`code_niveau`),
  ADD KEY `FK_referentiel_code_semestre` (`code_semestre`),
  ADD KEY `FK_referentiel_annee_universitaire` (`annee_universitaire`);

--
-- Index pour la table `seance_cours`
--
ALTER TABLE `seance_cours`
  ADD PRIMARY KEY (`code_cours`,`date_absence`,`hd_seance`),
  ADD UNIQUE KEY `IDX_ID_ABSENCE` (`id_seance`),
  ADD KEY `FK_absence_code_cours` (`code_cours`);

--
-- Index pour la table `semestre`
--
ALTER TABLE `semestre`
  ADD PRIMARY KEY (`code_semestre`);

--
-- Index pour la table `type_test`
--
ALTER TABLE `type_test`
  ADD PRIMARY KEY (`code_type_test`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`email_utilisateur`),
  ADD KEY `FK_utilisateur_code_profil` (`code_profil`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `absence`
--
ALTER TABLE `absence`
  MODIFY `id_seance` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `seance_cours`
--
ALTER TABLE `seance_cours`
  MODIFY `id_seance` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `absence`
--
ALTER TABLE `absence`
  ADD CONSTRAINT `FK_ETUDIANT` FOREIGN KEY (`email_etudiant`) REFERENCES `etudiant` (`email_etudiant`),
  ADD CONSTRAINT `FK_ID_SEANCE` FOREIGN KEY (`id_seance`) REFERENCES `seance_cours` (`id_seance`);

--
-- Contraintes pour la table `administration`
--
ALTER TABLE `administration`
  ADD CONSTRAINT `FK_administration_code_faculte` FOREIGN KEY (`code_faculte`) REFERENCES `faculte` (`code_faculte`),
  ADD CONSTRAINT `FK_administration_email_utilisateur` FOREIGN KEY (`email_utilisateur`) REFERENCES `utilisateur` (`email_utilisateur`);

--
-- Contraintes pour la table `cours`
--
ALTER TABLE `cours`
  ADD CONSTRAINT `FK_code_element_module` FOREIGN KEY (`code_element_module`) REFERENCES `element_module` (`code_element_module`),
  ADD CONSTRAINT `FK_code_referentiel` FOREIGN KEY (`code_referentiel`) REFERENCES `referentiel` (`code_referentiel`);

--
-- Contraintes pour la table `cours_groupe`
--
ALTER TABLE `cours_groupe`
  ADD CONSTRAINT `FK_suivre_code_classe_groupe` FOREIGN KEY (`code_classe_groupe`) REFERENCES `classe_groupe` (`code_classe_groupe`),
  ADD CONSTRAINT `FK_suivre_code_cours` FOREIGN KEY (`code_cours`) REFERENCES `cours` (`code_cours`);

--
-- Contraintes pour la table `cours_professeur`
--
ALTER TABLE `cours_professeur`
  ADD CONSTRAINT `FK_donner_code_cours` FOREIGN KEY (`code_cours`) REFERENCES `cours` (`code_cours`),
  ADD CONSTRAINT `FK_donner_code_prof` FOREIGN KEY (`code_prof`) REFERENCES `professeur` (`code_prof`);

--
-- Contraintes pour la table `element_module`
--
ALTER TABLE `element_module`
  ADD CONSTRAINT `FK_module_element_module` FOREIGN KEY (`code_module`) REFERENCES `modules` (`code_module`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `filiere`
--
ALTER TABLE `filiere`
  ADD CONSTRAINT `FK_filiere_code_faculte` FOREIGN KEY (`code_faculte`) REFERENCES `faculte` (`code_faculte`);

--
-- Contraintes pour la table `groupe_etudiant`
--
ALTER TABLE `groupe_etudiant`
  ADD CONSTRAINT `FK_appartenir_code_classe_groupe` FOREIGN KEY (`code_classe_groupe`) REFERENCES `classe_groupe` (`code_classe_groupe`),
  ADD CONSTRAINT `FK_appartenir_code_referentiel` FOREIGN KEY (`code_referentiel`) REFERENCES `referentiel` (`code_referentiel`),
  ADD CONSTRAINT `FK_appartenir_email_etudiant` FOREIGN KEY (`email_etudiant`) REFERENCES `etudiant` (`email_etudiant`);

--
-- Contraintes pour la table `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `FK_note_normale_code_cours` FOREIGN KEY (`code_cours`) REFERENCES `cours` (`code_cours`),
  ADD CONSTRAINT `FK_note_normale_code_type_test` FOREIGN KEY (`code_type_test`) REFERENCES `type_test` (`code_type_test`),
  ADD CONSTRAINT `FK_note_normale_email_etudiant` FOREIGN KEY (`email_etudiant`) REFERENCES `etudiant` (`email_etudiant`);

--
-- Contraintes pour la table `note_rattrapage`
--
ALTER TABLE `note_rattrapage`
  ADD CONSTRAINT `FK_note_rattrapage_code_cours` FOREIGN KEY (`code_cours`) REFERENCES `cours` (`code_cours`),
  ADD CONSTRAINT `FK_note_rattrapage_email_etudiant` FOREIGN KEY (`email_etudiant`) REFERENCES `etudiant` (`email_etudiant`);

--
-- Contraintes pour la table `referenciel_etudiant`
--
ALTER TABLE `referenciel_etudiant`
  ADD CONSTRAINT `FK_associer_5_code_referentiel` FOREIGN KEY (`code_referentiel`) REFERENCES `referentiel` (`code_referentiel`),
  ADD CONSTRAINT `FK_associer_5_email_etudiant` FOREIGN KEY (`email_etudiant`) REFERENCES `etudiant` (`email_etudiant`);

--
-- Contraintes pour la table `referenciel_evaluation`
--
ALTER TABLE `referenciel_evaluation`
  ADD CONSTRAINT `FK_faire_reference_a_code_referentiel` FOREIGN KEY (`code_referentiel`) REFERENCES `referentiel` (`code_referentiel`),
  ADD CONSTRAINT `FK_faire_reference_a_code_type_test` FOREIGN KEY (`code_type_test`) REFERENCES `type_test` (`code_type_test`),
  ADD CONSTRAINT `FK_faire_reference_a_id_element_module` FOREIGN KEY (`code_element_module`) REFERENCES `element_module` (`code_element_module`);

--
-- Contraintes pour la table `referentiel`
--
ALTER TABLE `referentiel`
  ADD CONSTRAINT `FK_referentiel_annee_universitaire` FOREIGN KEY (`annee_universitaire`) REFERENCES `annee_universitaire` (`annee_universitaire`),
  ADD CONSTRAINT `FK_referentiel_code_filiere` FOREIGN KEY (`code_filiere`) REFERENCES `filiere` (`code_filiere`),
  ADD CONSTRAINT `FK_referentiel_code_niveau` FOREIGN KEY (`code_niveau`) REFERENCES `niveau` (`code_niveau`),
  ADD CONSTRAINT `FK_referentiel_code_semestre` FOREIGN KEY (`code_semestre`) REFERENCES `semestre` (`code_semestre`);

--
-- Contraintes pour la table `seance_cours`
--
ALTER TABLE `seance_cours`
  ADD CONSTRAINT `FK_absence_code_cours` FOREIGN KEY (`code_cours`) REFERENCES `cours` (`code_cours`);

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `FK_utilisateur_code_profil` FOREIGN KEY (`code_profil`) REFERENCES `profil` (`code_profil`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
