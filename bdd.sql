-- Base de données :  `xelima_jus`
--
DROP DATABASE IF EXISTS `xelima_jus`;
CREATE DATABASE IF NOT EXISTS `xelima_jus` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `xelima_jus`;

-- -------------------Structure de la table `User-------------------

CREATE TABLE `User`(
 `id` int PRIMARY KEY AUTO_INCREMENT,
 `nom` VARCHAR(100),
 `prenom` VARCHAR(100),
 `adresse` VARCHAR(100),
 `tel` VARCHAR(20) UNIQUE,
 `email`VARCHAR(40),
 `pwd` VARCHAR(100),
 `profile` ENUM("ADMIN", "CLIENT")
);

 -- Structure de la table `categories`
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nom` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `corbeille` int
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE `produits` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `nom` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `prix` decimal(10,0) NOT NULL,
  `image` varchar(255) NOT NULL,
  `category_id` int NOT NULL,
  `id_admin` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `corbeille` int,
  CONSTRAINT FOREIGN KEY (`id_admin`) REFERENCES `User`(`id`),
  CONSTRAINT FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;