-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 07 Mars 2017 à 21:26
-- Version du serveur :  10.1.19-MariaDB
-- Version de PHP :  5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `exo_produits`
--
CREATE DATABASE IF NOT EXISTS `exo_produits` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `exo_produits`;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description_cat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`id`, `name`, `description_cat`) VALUES
(1, 'Informatique', 'Une liste de produits informatique, du suppport CD a la derniere carte graphique hight teck'),
(2, 'Automobiles', 'Tous pour votre Voiture'),
(3, 'Moto', 'Tous pour votre moto'),
(4, 'Electromenager', 'tous pour vous facilité la vie a la maison');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `product` text NOT NULL,
  `id_client` int(11) NOT NULL,
  `date_create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `orders`
--

INSERT INTO `orders` (`id`, `product`, `id_client`, `date_create`) VALUES
(1, '{"nomArticle":["piano yamaha","SHURE MICRO","pc de bureau dernier cri"],"quantite":[3,1,2],"prixArticle":[291.2,137.2,129.8]}', 1, '2017-03-06 15:08:07'),
(4, '{"nomArticle":["pc de bureau dernier cri","SHURE MICRO","piano yamaha"],"quantite":[1,2,3],"prixArticle":[129.8,137.2,291.2]}', 1, '2017-03-07 13:14:42');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `categorie` int(11) NOT NULL,
  `ref` varchar(255) NOT NULL,
  `tarifht` float NOT NULL,
  `tva` float NOT NULL,
  `photo_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `produits`
--

INSERT INTO `produits` (`id`, `libelle`, `description`, `categorie`, `ref`, `tarifht`, `tva`, `photo_url`) VALUES
(10, 'piano yamaha', 'clavier electrique', 1, 'PIA256XS', 276, 0.055, 'produits_58bc89e810832.jpg'),
(11, 'SHURE MICRO', 'Micro ampli', 1, 'shu85', 130, 0.055, 'produits_58bc8a6273eef.JPG'),
(13, 'pc de bureau dernier cri', 'un superb pc ultra puissant', 2, 'pc-0123', 123, 0.055, 'produits_58bc8bc981317.jpeg'),
(14, 'dfgdfg', 'dgds g g gfdg fdg g g dfg ddsg dgg dg dg dg', 3, 'cxfd', 1200, 0.2, 'produits_58bead3b5eba5.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `zipcode` varchar(6) NOT NULL,
  `city` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `password`, `email`, `phone`, `address`, `zipcode`, `city`) VALUES
(1, 'coool', 'code', '$2y$10$DB5/o/RYOs5bm1H2FKVbeOtXRQEmdJYWiw5ye53yS4P9qpoTodGIu', 'admin@free.fr', '0123456789', 'dhjfdskjhfdksjfhsdkf shfkjsdhfsdkjfhskdhsfds fshf sf', '97200', 'RSlespres');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ref` (`ref`),
  ADD KEY `produit_categorie` (`categorie`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `produit_categorie` FOREIGN KEY (`categorie`) REFERENCES `categorie` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
