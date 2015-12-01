-- Adminer 4.2.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id_category` int(11) NOT NULL AUTO_INCREMENT,
  `id_parent` int(11) DEFAULT NULL,
  `name` varchar(45) COLLATE utf8_czech_ci DEFAULT NULL,
  `label` text COLLATE utf8_czech_ci,
  `order` int(11) DEFAULT NULL,
  `child_label` text COLLATE utf8_czech_ci,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `code`;
CREATE TABLE `code` (
  `id_code` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `url` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `entity_category`;
CREATE TABLE `entity_category` (
  `id_entity_category` int(11) NOT NULL AUTO_INCREMENT,
  `id_category` int(11) NOT NULL,
  `id_website` int(11) DEFAULT NULL,
  `id_respondent` int(11) DEFAULT NULL,
  `period` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_entity_category`),
  KEY `id_category` (`id_category`),
  KEY `id_website` (`id_website`),
  KEY `id_respondent` (`id_respondent`),
  CONSTRAINT `entity_category_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `category` (`id_category`),
  CONSTRAINT `entity_category_ibfk_2` FOREIGN KEY (`id_website`) REFERENCES `website` (`id_website`),
  CONSTRAINT `entity_category_ibfk_3` FOREIGN KEY (`id_respondent`) REFERENCES `respondent` (`id_respondent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `page`;
CREATE TABLE `page` (
  `id_page` int(11) NOT NULL AUTO_INCREMENT,
  `id_website` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_czech_ci NOT NULL,
  `url` text COLLATE utf8_czech_ci NOT NULL,
  `dominant_color` varchar(45) COLLATE utf8_czech_ci NOT NULL,
  `dominant_text_color` varchar(45) COLLATE utf8_czech_ci NOT NULL,
  `priority` tinyint(1) NOT NULL DEFAULT '0',
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_page`),
  KEY `id_website_idx` (`id_website`),
  CONSTRAINT `id_website` FOREIGN KEY (`id_website`) REFERENCES `website` (`id_website`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `page_related`;
CREATE TABLE `page_related` (
  `id_page_related` int(11) NOT NULL AUTO_INCREMENT,
  `id_page_a` int(11) NOT NULL,
  `id_page_b` int(11) NOT NULL,
  `duel` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_page_related`),
  KEY `id_page_a` (`id_page_a`),
  KEY `id_page_b` (`id_page_b`),
  CONSTRAINT `page_related_ibfk_1` FOREIGN KEY (`id_page_a`) REFERENCES `page` (`id_page`),
  CONSTRAINT `page_related_ibfk_2` FOREIGN KEY (`id_page_b`) REFERENCES `page` (`id_page`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `question`;
CREATE TABLE `question` (
  `id_question` int(11) NOT NULL AUTO_INCREMENT,
  `id_respondent` int(11) DEFAULT NULL,
  `id_page` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id_question`),
  KEY `id_respondent` (`id_respondent`),
  KEY `id_page` (`id_page`),
  CONSTRAINT `question_ibfk_1` FOREIGN KEY (`id_respondent`) REFERENCES `respondent` (`id_respondent`),
  CONSTRAINT `question_ibfk_2` FOREIGN KEY (`id_page`) REFERENCES `page` (`id_page`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

DROP TABLE IF EXISTS `respondent`;
CREATE TABLE `respondent` (
  `id_respondent` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(255),
  `age` varchar(5) COLLATE utf8_czech_ci DEFAULT NULL,
  `gender` varchar(1) COLLATE utf8_czech_ci DEFAULT NULL,
  `english` tinyint(1) DEFAULT NULL,
  `it` tinyint(1) DEFAULT NULL,
  `device_computer` tinyint(1) DEFAULT NULL,
  `device_tablet` tinyint(1) DEFAULT NULL,
  `device_phone` tinyint(1) DEFAULT NULL,
  `device_most` varchar(1) COLLATE utf8_czech_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `message` text COLLATE utf8_czech_ci,
  `sites` text COLLATE utf8_czech_ci,
  `datetime` datetime DEFAULT NULL,
  `user_agent` text COLLATE utf8_czech_ci,
  `code` varchar(20) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id_respondent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `respondent_page_duel`;
CREATE TABLE `respondent_page_duel` (
  `id_respondent_page_duel` int(11) NOT NULL AUTO_INCREMENT,
  `id_respondent` int(11) NOT NULL,
  `id_page_related` int(11) NOT NULL,
  `more_often` varchar(1) COLLATE utf8_czech_ci NOT NULL,
  `id_page` int(11),
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id_respondent_page_duel`),
  KEY `id_respondent` (`id_respondent`),
  KEY `id_page_related` (`id_page_related`),
  KEY `id_page` (`id_page`),
  CONSTRAINT `respondent_page_duel_ibfk_1` FOREIGN KEY (`id_respondent`) REFERENCES `respondent` (`id_respondent`),
  CONSTRAINT `respondent_page_duel_ibfk_2` FOREIGN KEY (`id_page_related`) REFERENCES `page_related` (`id_page_related`),
  CONSTRAINT `respondent_page_duel_ibfk_3` FOREIGN KEY (`id_page`) REFERENCES `page` (`id_page`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `respondent_website`;
CREATE TABLE `respondent_website` (
  `id_respondent_website` tinyint(4) NOT NULL AUTO_INCREMENT,
  `id_respondent` int(11) NOT NULL,
  `id_website` int(11) NOT NULL,
  `period` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id_respondent_website`),
  KEY `id_respondent` (`id_respondent`),
  KEY `id_website` (`id_website`),
  CONSTRAINT `respondent_website_ibfk_1` FOREIGN KEY (`id_respondent`) REFERENCES `respondent` (`id_respondent`),
  CONSTRAINT `respondent_website_ibfk_2` FOREIGN KEY (`id_website`) REFERENCES `website` (`id_website`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `subquestion`;
CREATE TABLE `subquestion` (
  `id_subquestion` int(11) NOT NULL AUTO_INCREMENT,
  `id_question` int(11) NOT NULL,
  `id_wireframe` varchar(45) COLLATE utf8_czech_ci DEFAULT NULL,
  `question_type` int(11) NOT NULL,
  `answer` varchar(500) COLLATE utf8_czech_ci DEFAULT NULL,
  `correct` tinyint(1) DEFAULT NULL COMMENT '0 - ne 1 - ano null - neovereno',
  `reason` text COLLATE utf8_czech_ci,
  `seconds` int(11) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `id_page_related` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_subquestion`),
  KEY `id_question_idx` (`id_question`),
  KEY `id_page_related` (`id_page_related`),
  CONSTRAINT `subquestion_ibfk_1` FOREIGN KEY (`id_page_related`) REFERENCES `page_related` (`id_page_related`),
  CONSTRAINT `id_question` FOREIGN KEY (`id_question`) REFERENCES `question` (`id_question`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `website`;
CREATE TABLE `website` (
  `id_website` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8_czech_ci NOT NULL,
  `url` varchar(45) COLLATE utf8_czech_ci NOT NULL,
  `language` varchar(2) COLLATE utf8_czech_ci NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_website`),
  UNIQUE KEY `url_UNIQUE` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `wireframe`;
CREATE TABLE `wireframe` (
  `id_wireframe` int(11) NOT NULL AUTO_INCREMENT,
  `id_page` int(11) NOT NULL,
  `text_mode` varchar(45) COLLATE utf8_czech_ci NOT NULL,
  `image_mode` varchar(45) COLLATE utf8_czech_ci NOT NULL,
  `resolution_width` int(11) NOT NULL,
  `resolution_height` int(11) NOT NULL,
  `device` varchar(45) COLLATE utf8_czech_ci NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_wireframe`),
  KEY `id_page_idx` (`id_page`),
  CONSTRAINT `id_page` FOREIGN KEY (`id_page`) REFERENCES `page` (`id_page`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


-- 2015-11-14 13:15:03
