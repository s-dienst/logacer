# ************************************************************
# Sequel Ace SQL dump
# Version 20116
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Hôte: 127.0.0.1 (MySQL 8.4.11)
# Base de données: cevica_test
# Temps de génération: 2026-11-01 16:56:44 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Vidage de la table app_text
# ------------------------------------------------------------

DROP TABLE IF EXISTS `app_text`;

CREATE TABLE `app_text` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `project` int NOT NULL DEFAULT '0',
  `lang` varchar(3) NOT NULL,
  `format` varchar(16) NOT NULL,
  `page` varchar(32) NOT NULL,
  `content` text,
  `creator` int NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



# Vidage de la table bibliography
# ------------------------------------------------------------

DROP TABLE IF EXISTS `bibliography`;

CREATE TABLE `bibliography` (
  `id` int NOT NULL AUTO_INCREMENT,
  `abbreviation` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `reference` text COLLATE utf8mb4_general_ci,
  `reference_html` text COLLATE utf8mb4_general_ci,
  `onicer_link` text COLLATE utf8mb4_general_ci,
  `creator` int NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `abbreviation` (`abbreviation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `abbreviation` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `onicer` tinyint(1) NOT NULL DEFAULT '0',
  `creator` int NOT NULL,
  `color` varchar(6) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `abbreviation` (`abbreviation`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table config_horizon
# ------------------------------------------------------------

DROP TABLE IF EXISTS `config_horizon`;

CREATE TABLE `config_horizon` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `type` varchar(32) COLLATE utf8mb4_general_ci NOT NULL,
  `owner` int NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table config_horizon_type
# ------------------------------------------------------------

DROP TABLE IF EXISTS `config_horizon_type`;

CREATE TABLE `config_horizon_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `config_horizon` int NOT NULL,
  `creator` int NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table context
# ------------------------------------------------------------

DROP TABLE IF EXISTS `context`;

CREATE TABLE `context` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(32) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descr` text COLLATE utf8mb4_general_ci,
  `descr_html` text COLLATE utf8mb4_general_ci,
  `public` tinyint(1) NOT NULL DEFAULT '0',
  `unpublished` tinyint(1) NOT NULL DEFAULT '0',
  `biblio_review` tinyint(1) NOT NULL DEFAULT '0',
  `related_phase` int NOT NULL,
  `creator` int NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table counting
# ------------------------------------------------------------

DROP TABLE IF EXISTS `counting`;

CREATE TABLE `counting` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table country
# ------------------------------------------------------------

DROP TABLE IF EXISTS `country`;

CREATE TABLE `country` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table fabric
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fabric`;

CREATE TABLE `fabric` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descr` text COLLATE utf8mb4_general_ci,
  `descr_html` text COLLATE utf8mb4_general_ci,
  `origin` text COLLATE utf8mb4_general_ci,
  `origin_html` text COLLATE utf8mb4_general_ci,
  `superfabric` int DEFAULT NULL,
  `owner` int NOT NULL,
  `public` tinyint(1) NOT NULL DEFAULT '0',
  `related_project` int DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table facies
# ------------------------------------------------------------

DROP TABLE IF EXISTS `facies`;

CREATE TABLE `facies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(32) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descr` text COLLATE utf8mb4_general_ci,
  `descr_html` text COLLATE utf8mb4_general_ci,
  `public` tinyint(1) NOT NULL DEFAULT '0',
  `unpublished` tinyint(1) NOT NULL DEFAULT '0',
  `owner` int NOT NULL,
  `project` int DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table file
# ------------------------------------------------------------

DROP TABLE IF EXISTS `file`;

CREATE TABLE `file` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `type` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `descr` text COLLATE utf8mb4_general_ci,
  `public` tinyint(1) NOT NULL DEFAULT '0',
  `path` text COLLATE utf8mb4_general_ci NOT NULL,
  `project` int NOT NULL DEFAULT '0',
  `owner` int NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table function_table
# ------------------------------------------------------------

DROP TABLE IF EXISTS `function_table`;

CREATE TABLE `function_table` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `onicer` tinyint(1) NOT NULL DEFAULT '0',
  `creator` int NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table horizon
# ------------------------------------------------------------

DROP TABLE IF EXISTS `horizon`;

CREATE TABLE `horizon` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(32) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descr` text COLLATE utf8mb4_general_ci,
  `descr_html` text COLLATE utf8mb4_general_ci,
  `dating` text COLLATE utf8mb4_general_ci,
  `dating_html` text COLLATE utf8mb4_general_ci,
  `public` tinyint(1) DEFAULT NULL,
  `facies` int NOT NULL,
  `superhorizon` int DEFAULT NULL,
  `owner` int NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table link_bibliography_file
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link_bibliography_file`;

CREATE TABLE `link_bibliography_file` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bibliography` int NOT NULL,
  `file` int NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table link_config_horizon_contributor
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link_config_horizon_contributor`;

CREATE TABLE `link_config_horizon_contributor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `config_horizon` int NOT NULL,
  `contributor` int NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table link_config_horizon_phase_or_context
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link_config_horizon_phase_or_context`;

CREATE TABLE `link_config_horizon_phase_or_context` (
  `id` int NOT NULL AUTO_INCREMENT,
  `config_horizon` int NOT NULL,
  `phase_or_context` int NOT NULL,
  `color` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table link_config_horizon_type_type
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link_config_horizon_type_type`;

CREATE TABLE `link_config_horizon_type_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `config_horizon_type` int NOT NULL,
  `type` int NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table link_context_bibliography
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link_context_bibliography`;

CREATE TABLE `link_context_bibliography` (
  `id` int NOT NULL AUTO_INCREMENT,
  `context` int NOT NULL,
  `bibliography` int NOT NULL,
  `pagination` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table link_context_file
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link_context_file`;

CREATE TABLE `link_context_file` (
  `id` int NOT NULL AUTO_INCREMENT,
  `context` int NOT NULL,
  `file` int NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table link_counting_site
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link_counting_site`;

CREATE TABLE `link_counting_site` (
  `id` int NOT NULL AUTO_INCREMENT,
  `site` int NOT NULL,
  `counting` int NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table link_counting_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link_counting_user`;

CREATE TABLE `link_counting_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user` int NOT NULL,
  `counting` int NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table link_fabric_bibliography
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link_fabric_bibliography`;

CREATE TABLE `link_fabric_bibliography` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fabric` int NOT NULL,
  `bibliography` int NOT NULL,
  `pagination` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table link_fabric_contributor
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link_fabric_contributor`;

CREATE TABLE `link_fabric_contributor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fabric` int NOT NULL,
  `contributor` int NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table link_fabric_project
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link_fabric_project`;

CREATE TABLE `link_fabric_project` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `fabric` int NOT NULL,
  `project` int DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



# Vidage de la table link_facies_bibliography
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link_facies_bibliography`;

CREATE TABLE `link_facies_bibliography` (
  `id` int NOT NULL AUTO_INCREMENT,
  `facies` int NOT NULL,
  `bibliography` int NOT NULL,
  `pagination` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table link_facies_contributor
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link_facies_contributor`;

CREATE TABLE `link_facies_contributor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `facies` int NOT NULL,
  `contributor` int NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table link_facies_file
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link_facies_file`;

CREATE TABLE `link_facies_file` (
  `id` int NOT NULL AUTO_INCREMENT,
  `facies` int NOT NULL,
  `file` int NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table link_facies_region
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link_facies_region`;

CREATE TABLE `link_facies_region` (
  `id` int NOT NULL AUTO_INCREMENT,
  `facies` int NOT NULL,
  `region` int NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table link_horizon_file
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link_horizon_file`;

CREATE TABLE `link_horizon_file` (
  `id` int NOT NULL AUTO_INCREMENT,
  `horizon` int NOT NULL,
  `file` int NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table link_horizon_type
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link_horizon_type`;

CREATE TABLE `link_horizon_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `horizon` int NOT NULL,
  `type` int NOT NULL,
  `type_link` varchar(32) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table link_object_file
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link_object_file`;

CREATE TABLE `link_object_file` (
  `id` int NOT NULL AUTO_INCREMENT,
  `object` int NOT NULL,
  `file` int NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table link_phase_bibliography
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link_phase_bibliography`;

CREATE TABLE `link_phase_bibliography` (
  `id` int NOT NULL AUTO_INCREMENT,
  `phase` int NOT NULL,
  `bibliography` int NOT NULL,
  `pagination` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table link_phase_file
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link_phase_file`;

CREATE TABLE `link_phase_file` (
  `id` int NOT NULL AUTO_INCREMENT,
  `phase` int NOT NULL,
  `file` int NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table link_project_contributor
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link_project_contributor`;

CREATE TABLE `link_project_contributor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project` int NOT NULL,
  `contributor` int NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table link_project_file
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link_project_file`;

CREATE TABLE `link_project_file` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project` int NOT NULL,
  `file` int NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table link_site_bibliography
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link_site_bibliography`;

CREATE TABLE `link_site_bibliography` (
  `id` int NOT NULL AUTO_INCREMENT,
  `site` int NOT NULL,
  `bibliography` int NOT NULL,
  `pagination` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table link_site_contributor
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link_site_contributor`;

CREATE TABLE `link_site_contributor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `site` int NOT NULL,
  `contributor` int NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table link_site_file
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link_site_file`;

CREATE TABLE `link_site_file` (
  `id` int NOT NULL AUTO_INCREMENT,
  `site` int NOT NULL,
  `file` int NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table link_type_bibliography
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link_type_bibliography`;

CREATE TABLE `link_type_bibliography` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` int NOT NULL,
  `bibliography` int NOT NULL,
  `pagination` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table link_typology_bibliography
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link_typology_bibliography`;

CREATE TABLE `link_typology_bibliography` (
  `id` int NOT NULL AUTO_INCREMENT,
  `typology` int NOT NULL,
  `bibliography` int NOT NULL,
  `pagination` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table link_typology_category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link_typology_category`;

CREATE TABLE `link_typology_category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `typology` int NOT NULL,
  `category` int NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table link_typology_contributor
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link_typology_contributor`;

CREATE TABLE `link_typology_contributor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `typology` int NOT NULL,
  `contributor` int NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table link_typology_project
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link_typology_project`;

CREATE TABLE `link_typology_project` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `typology` int NOT NULL,
  `project` int DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



# Vidage de la table modifications
# ------------------------------------------------------------

DROP TABLE IF EXISTS `modifications`;

CREATE TABLE `modifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `model` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `previous_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `new_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `impacted` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `model` (`model`),
  KEY `previous_name` (`previous_name`),
  KEY `new_name` (`new_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table news
# ------------------------------------------------------------

DROP TABLE IF EXISTS `news`;

CREATE TABLE `news` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `content` text COLLATE utf8mb4_general_ci,
  `content_html` text COLLATE utf8mb4_general_ci,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `creator` int NOT NULL,
  `project` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table object
# ------------------------------------------------------------

DROP TABLE IF EXISTS `object`;

CREATE TABLE `object` (
  `id` int NOT NULL AUTO_INCREMENT,
  `number` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `category_abbr` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `category_link_old` int DEFAULT NULL,
  `function_name` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `function_link_old` int DEFAULT NULL,
  `type_name` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `type_link_old` int DEFAULT NULL,
  `type_var` varchar(8) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `type_doubt` varchar(16) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fabric_code` varchar(64) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fabric_link_old` int DEFAULT NULL,
  `stamp` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `diameter` varchar(16) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `related_context` int NOT NULL,
  `creator` int NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `n_rim` int DEFAULT NULL,
  `n_bottom` int DEFAULT NULL,
  `n_handle` int DEFAULT NULL,
  `n_wall` int DEFAULT NULL,
  `n_mni` int DEFAULT NULL,
  `n_sherd` int DEFAULT NULL,
  `category_litt` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `function_litt` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `type_litt` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fabric_litt` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `number` (`number`),
  KEY `category_local` (`category_abbr`),
  KEY `function_local` (`function_name`),
  KEY `type_local` (`type_name`),
  KEY `fabric_local` (`fabric_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table phase
# ------------------------------------------------------------

DROP TABLE IF EXISTS `phase`;

CREATE TABLE `phase` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(32) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descr` text COLLATE utf8mb4_general_ci,
  `descr_html` text COLLATE utf8mb4_general_ci,
  `public` tinyint(1) NOT NULL DEFAULT '0',
  `unpublished` tinyint(1) NOT NULL DEFAULT '0',
  `biblio_review` tinyint(1) NOT NULL DEFAULT '0',
  `related_site` int NOT NULL,
  `horizon` int DEFAULT NULL,
  `horizon_strength` int DEFAULT NULL,
  `creator` int NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `code` (`code`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table picture
# ------------------------------------------------------------

DROP TABLE IF EXISTS `picture`;

CREATE TABLE `picture` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `type_picture` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `height` int DEFAULT NULL,
  `width` int DEFAULT NULL,
  `comment` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `related_object` int NOT NULL,
  `biblio_reference` int DEFAULT NULL,
  `biblio_emplacement` varchar(128) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `storage` varchar(64) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `url_path` text COLLATE utf8mb4_general_ci,
  `extension` varchar(8) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `creator` int NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table project
# ------------------------------------------------------------

DROP TABLE IF EXISTS `project`;

CREATE TABLE `project` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `descr` text COLLATE utf8mb4_general_ci,
  `descr_html` text COLLATE utf8mb4_general_ci,
  `owner` int NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `public` tinyint NOT NULL DEFAULT '1',
  `setting_horizon` int DEFAULT '0',
  `setting_graphs` tinyint DEFAULT '0',
  `setting_litterature` tinyint DEFAULT '0',
  `setting_archaeometry` int DEFAULT '0',
  `setting_notes` int DEFAULT '0',
  `langs` varchar(64) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'en',
  `img_icon` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `img_band` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `img_logo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `img_footer1` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `img_footer2` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `img_footer3` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `img_footer4` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `img_footer5` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `link_footer1` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `link_footer2` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `link_footer3` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `link_footer4` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `link_footer5` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table region
# ------------------------------------------------------------

DROP TABLE IF EXISTS `region`;

CREATE TABLE `region` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(16) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `country` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `code` (`code`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table site
# ------------------------------------------------------------

DROP TABLE IF EXISTS `site`;

CREATE TABLE `site` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(32) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `coord_lat` float DEFAULT NULL,
  `coord_long` float DEFAULT NULL,
  `descr` text COLLATE utf8mb4_general_ci,
  `descr_html` text COLLATE utf8mb4_general_ci,
  `public` tinyint(1) NOT NULL DEFAULT '0',
  `unpublished` tinyint(1) NOT NULL DEFAULT '0',
  `biblio_review` tinyint(1) NOT NULL DEFAULT '0',
  `owner` int NOT NULL,
  `region` int DEFAULT NULL,
  `project` int DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `owner` (`owner`),
  CONSTRAINT `owner` FOREIGN KEY (`owner`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table type
# ------------------------------------------------------------

DROP TABLE IF EXISTS `type`;

CREATE TABLE `type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `descr` text COLLATE utf8mb4_general_ci,
  `descr_html` text COLLATE utf8mb4_general_ci,
  `dating` text COLLATE utf8mb4_general_ci,
  `dating_html` text COLLATE utf8mb4_general_ci,
  `onicer` tinyint(1) NOT NULL DEFAULT '0',
  `typology` int NOT NULL,
  `supertype` int DEFAULT NULL,
  `owner` int NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table typology
# ------------------------------------------------------------

DROP TABLE IF EXISTS `typology`;

CREATE TABLE `typology` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descr` text COLLATE utf8mb4_general_ci,
  `descr_html` text COLLATE utf8mb4_general_ci,
  `owner` int NOT NULL,
  `public` tinyint(1) NOT NULL DEFAULT '0',
  `related_project` int DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



# Vidage de la table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `mail` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `firstname` varchar(64) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lastname` varchar(64) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_staff` tinyint(1) NOT NULL DEFAULT '0',
  `is_activated` tinyint(1) NOT NULL DEFAULT '0',
  `is_contributor` tinyint(1) NOT NULL DEFAULT '0',
  `links_complex` tinyint(1) NOT NULL DEFAULT '0',
  `is_beginner` tinyint(1) NOT NULL DEFAULT '1',
  `language` varchar(3) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'FR',
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `number_attempts` int DEFAULT '0',
  `activation_key` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_username` (`username`),
  UNIQUE KEY `user_mail` (`mail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
