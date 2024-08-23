-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 02 juin 2023 à 17:32
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `m_y`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

CREATE TABLE `administrateur` (
  `ID_admin` int(11) NOT NULL,
  `Nom_admin` varchar(255) DEFAULT NULL,
  `Prenom_admin` varchar(255) DEFAULT NULL,
  `AdresseEmail_admin` varchar(255) DEFAULT NULL,
  `MotDePasse_admin` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--


-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `ID_article` int(11) NOT NULL,
  `Titre_article` varchar(255) DEFAULT NULL,
  `Contenu_article` text DEFAULT NULL,
  `DatePubli_article` date DEFAULT NULL,
  `Administrateur_ID` int(11) DEFAULT NULL,
  `Categorie_ID` int(11) DEFAULT NULL,
  `Mot_cle_ID` int(11) DEFAULT NULL,
  `image_article` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `ID_categorie` int(11) NOT NULL,
  `Nom_categorie` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
INSERT INTO `categorie` (`ID_categorie`, `Nom_categorie`) VALUES
(1, 'Technologie'),
(2, 'Sport'),
(3, 'Actualités');
--



-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT -1,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `submit_date` datetime NOT NULL DEFAULT current_timestamp(),
  `votes` int(11) NOT NULL DEFAULT 0,
  `img` varchar(255) NOT NULL DEFAULT '',
  `approved` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--


-- --------------------------------------------------------

--
-- Structure de la table `mot_cle`
--

CREATE TABLE `mot_cle` (
  `ID_mot_cle` int(11) NOT NULL,
  `Libelle` varchar(125) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
INSERT INTO `mot_cle` (`ID_mot_cle`, `Libelle`) VALUES
(1, 'Informatique'),
(2, 'Sport'),
(3, 'Politique');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD PRIMARY KEY (`ID_admin`);

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`ID_article`),
  ADD KEY `Administrateur_ID` (`Administrateur_ID`),
  ADD KEY `Categorie_ID` (`Categorie_ID`),
  ADD KEY `Mot_cle_ID` (`Mot_cle_ID`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`ID_categorie`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Article_ID` (`article_id`);



--
-- Index pour la table `mot_cle`
--
ALTER TABLE `mot_cle`
  ADD PRIMARY KEY (`ID_mot_cle`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `administrateur`
--
ALTER TABLE `administrateur`
  MODIFY `ID_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `ID_article` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `ID_categorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-
--


--
-- AUTO_INCREMENT pour la table `mot_cle`
--
ALTER TABLE `mot_cle`
  MODIFY `ID_mot_cle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`Administrateur_ID`) REFERENCES `administrateur` (`ID_admin`),
  ADD CONSTRAINT `article_ibfk_2` FOREIGN KEY (`Categorie_ID`) REFERENCES `categorie` (`ID_categorie`),
  ADD CONSTRAINT `article_ibfk_3` FOREIGN KEY (`Mot_cle_ID`) REFERENCES `mot_cle` (`ID_mot_cle`);
COMMIT;

