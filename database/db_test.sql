-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 18 juil. 2023 à 09:47
-- Version du serveur : 5.7.36
-- Version de PHP : 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_test`
--

-- --------------------------------------------------------

--
-- Structure de la table `address`
--

DROP TABLE IF EXISTS `address`;
CREATE TABLE IF NOT EXISTS `address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(900) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `created_the` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updated_on` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `customer_package_group`
--

DROP TABLE IF EXISTS `customer_package_group`;
CREATE TABLE IF NOT EXISTS `customer_package_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tracking_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'En attente...',
  `product_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Mixte',
  `description` varchar(900) COLLATE utf8_unicode_ci DEFAULT NULL,
  `net_weight` int(11) DEFAULT NULL,
  `volumetric_weight` int(11) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_on` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
CREATE TABLE IF NOT EXISTS `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoices_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoices_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8_unicode_ci,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `package_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_package_id` (`package_id`),
  KEY `notifications_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `package`
--

DROP TABLE IF EXISTS `package`;
CREATE TABLE IF NOT EXISTS `package` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tracking_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `package_units_number` int(11) NOT NULL,
  `worth` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(900) COLLATE utf8_unicode_ci NOT NULL,
  `net_weight` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `volumetric_weight` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `images` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shipping_unit_cost` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shipping_cost` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shipping_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` varchar(900) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'En attente...',
  `is_active` int(11) NOT NULL DEFAULT '1',
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `created_the` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_on` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `product_type_id` int(11) DEFAULT NULL,
  `shipping_type_id` int(11) DEFAULT NULL,
  `customer_package_group_id` int(11) DEFAULT NULL,
  `shipping_package_group_id` int(11) DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shipping_package_group_id` (`shipping_package_group_id`),
  KEY `customer_package_group_id` (`customer_package_group_id`),
  KEY `shipping_type_id` (`shipping_type_id`),
  KEY `product_type_id` (`product_type_id`),
  KEY `user_id` (`user_id`),
  KEY `package_invoices_id` (`invoice_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `packages_images`
--

DROP TABLE IF EXISTS `packages_images`;
CREATE TABLE IF NOT EXISTS `packages_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `package_id` int(11) NOT NULL,
  `images` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `updated_on` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `package_id` (`package_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `product_type`
--

DROP TABLE IF EXISTS `product_type`;
CREATE TABLE IF NOT EXISTS `product_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(900) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_per_kg` int(11) DEFAULT NULL,
  `billing_per_cbm` int(11) DEFAULT NULL,
  `billing_per_pcs` int(11) DEFAULT NULL,
  `billing_per_kg_with_insurance` int(11) DEFAULT NULL,
  `billing_per_cbm_with_insurance` int(11) DEFAULT NULL,
  `billing_per_pcs_with_insurance` int(11) DEFAULT NULL,
  `have_insurance` int(11) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `created_the` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_on` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `product_type`
--

INSERT INTO `product_type` (`id`, `name`, `description`, `image`, `billing_per_kg`, `billing_per_cbm`, `billing_per_pcs`, `billing_per_kg_with_insurance`, `billing_per_cbm_with_insurance`, `billing_per_pcs_with_insurance`, `have_insurance`, `is_active`, `is_deleted`, `created_the`, `updated_on`) VALUES
(27, 'Vêtements', NULL, NULL, 8500, 0, 0, 0, 0, 0, 0, 1, 0, '2023-06-21 14:21:16', NULL),
(28, 'Sacs', NULL, NULL, 8500, 0, 0, 0, 0, 0, 0, 1, 0, '2023-06-21 14:21:16', NULL),
(29, 'Chaussures', NULL, NULL, 8500, 0, 0, 0, 0, 0, 0, 1, 0, '2023-06-21 14:21:16', NULL),
(30, 'Aliments', NULL, NULL, 9000, 0, 0, 0, 0, 0, 0, 1, 0, '2023-06-21 14:22:57', NULL),
(31, 'Perruques', NULL, NULL, 9000, 0, 0, 0, 0, 0, 0, 1, 0, '2023-06-21 14:22:57', NULL),
(32, 'Mèches', NULL, NULL, 9000, 0, 0, 0, 0, 0, 0, 1, 0, '2023-06-21 14:22:57', NULL),
(33, 'Faux cils', NULL, NULL, 9000, 0, 0, 0, 0, 0, 0, 1, 0, '2023-06-21 14:22:57', NULL),
(34, 'Produits liquides', NULL, NULL, 9000, 0, 0, 0, 0, 0, 0, 1, 0, '2023-06-21 14:22:57', NULL),
(35, 'Produits à poudres', NULL, NULL, 9000, 0, 0, 0, 0, 0, 0, 1, 0, '2023-06-21 14:22:57', NULL),
(36, 'Cosmétiques', NULL, NULL, 9000, 0, 0, 0, 0, 0, 0, 1, 0, '2023-06-21 14:22:57', NULL),
(37, 'Produits fragiles', NULL, NULL, 9000, 0, 0, 0, 0, 0, 0, 1, 0, '2023-06-21 14:22:57', NULL),
(38, 'Equipements médicaux', NULL, NULL, 9500, 0, 0, 0, 0, 0, 0, 1, 0, '2023-06-21 14:24:16', NULL),
(39, 'Equipements électroniques', NULL, NULL, 9500, 0, 0, 0, 0, 0, 0, 1, 0, '2023-06-21 14:24:16', NULL),
(40, 'Produits à batteries', NULL, NULL, 9500, 0, 0, 0, 0, 0, 0, 1, 0, '2023-06-21 14:24:16', NULL),
(41, 'Produits pour adultes', NULL, NULL, 9500, 0, 0, 0, 0, 0, 0, 1, 0, '2023-06-21 14:24:16', NULL),
(42, 'Téléphones portables', NULL, NULL, 0, 0, 15000, 0, 0, 25000, 1, 1, 0, '2023-06-21 14:25:04', NULL),
(43, 'Tablettes', NULL, NULL, 0, 0, 15000, 0, 0, 25000, 1, 1, 0, '2023-06-21 14:25:04', NULL),
(44, 'Ordinateurs portables', NULL, NULL, 16000, 0, 0, 40000, 0, 0, 1, 1, 0, '2023-06-21 14:25:43', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `shipping_package_group`
--

DROP TABLE IF EXISTS `shipping_package_group`;
CREATE TABLE IF NOT EXISTS `shipping_package_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tracking_number` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(900) COLLATE utf8_unicode_ci NOT NULL,
  `net_weight` int(11) NOT NULL,
  `volumetric_weight` int(11) NOT NULL,
  `departure_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `estimate_time` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shipping_cost` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `created_the` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updated_on` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `shipping_type`
--

DROP TABLE IF EXISTS `shipping_type`;
CREATE TABLE IF NOT EXISTS `shipping_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(900) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `delivery_time` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `weight_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_on` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `shipping_type`
--

INSERT INTO `shipping_type` (`id`, `name`, `description`, `image`, `delivery_time`, `weight_type`, `is_active`, `is_deleted`, `created_at`, `updated_on`) VALUES
(3, 'Aérien', NULL, NULL, '2 à 3 semaines après la réception du colis à notre entrepôt en Chine.', NULL, 1, 0, '2023-06-22 19:31:29', NULL),
(4, 'Maritime', NULL, NULL, '2 à 3 mois après la réception du colis à notre entrepôt en Chine.', NULL, 0, 0, '2023-06-22 19:32:13', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(900) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `created_the` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updated_on` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `token`
--

DROP TABLE IF EXISTS `token`;
CREATE TABLE IF NOT EXISTS `token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_on` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'null',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_names` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `birth_date` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'null',
  `phone_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sex` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'null',
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'null',
  `company_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'null',
  `profile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_valid_mail` int(11) NOT NULL DEFAULT '0',
  `is_valid_phone_number` int(11) NOT NULL DEFAULT '0',
  `is_valid_account` int(11) NOT NULL DEFAULT '0',
  `is_active` int(11) NOT NULL DEFAULT '0',
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_on` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'null',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `customer_package_group`
--
ALTER TABLE `customer_package_group`
  ADD CONSTRAINT `customer_package_group_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_package_id` FOREIGN KEY (`package_id`) REFERENCES `package` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notifications_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `package`
--
ALTER TABLE `package`
  ADD CONSTRAINT `package_customer_package_group_id` FOREIGN KEY (`customer_package_group_id`) REFERENCES `customer_package_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `package_invoices_id` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `package_product_type_id` FOREIGN KEY (`product_type_id`) REFERENCES `product_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `package_shipping_package_group_id` FOREIGN KEY (`shipping_package_group_id`) REFERENCES `shipping_package_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `package_shipping_type` FOREIGN KEY (`shipping_type_id`) REFERENCES `shipping_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `package_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `packages_images`
--
ALTER TABLE `packages_images`
  ADD CONSTRAINT `packages_images_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `package` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `packages_images_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `token_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
