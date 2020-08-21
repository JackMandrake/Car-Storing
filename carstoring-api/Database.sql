-- Adminer 4.7.6 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `car`;
CREATE TABLE `car` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nb_seat` int(11) NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `height` double NOT NULL,
  `width` double NOT NULL,
  `parking_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_773DE69DF17B2DD` (`parking_id`),
  CONSTRAINT `FK_773DE69DF17B2DD` FOREIGN KEY (`parking_id`) REFERENCES `parking` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `car` (`id`, `name`, `nb_seat`, `color`, `height`, `width`, `parking_id`) VALUES
(5,	'Batmobile',	2,	'#000000',	4,	1.5,	11),
(7,	'Dolorean',	2,	'#898484',	3,	1.5,	14),
(8,	'TurtleVan',	4,	'#198836',	4,	1.5,	13),
(9,	'Gran Torino',	4,	'#f50909',	3,	1.5,	NULL),
(10,	'K 2000',	2,	'#000000',	3,	1.5,	14),
(11,	'Ecto - 1',	3,	'#fcfcfc',	4,	1.5,	14),
(12,	'Land Spider',	2,	'#fc690a',	2,	1,	16),
(13,	'A-Team Van',	5,	'#000000',	4,	1.5,	14),
(14,	'Impala',	4,	'#000000',	3.5,	2,	13),
(15,	'Tardis',	6,	'#001cff',	1.5,	1.5,	11),
(17,	'Mattyus Mobile',	5,	'#00000',	4,	2,	12);

DROP TABLE IF EXISTS `parking`;
CREATE TABLE `parking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `localisation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `parking` (`id`, `name`, `localisation`) VALUES
(10,	'Parking Kong',	'Skull Island'),
(11,	'Jurassic Parking',	'Isla Nublar'),
(12,	'Parking Son',	'Oublié'),
(13,	'ParviKing',	'Au Nord'),
(14,	'Parking de la promenade des deux Pins',	'Hill Valley'),
(15,	'Parking Slayer',	'King\'s Landing'),
(16,	'Bat Cave',	'Sous le Manoir Wayne - aile ouest'),
(18,	'Parking Jouet',	'En face de Jouet Club');

DROP TABLE IF EXISTS `parking_space`;
CREATE TABLE `parking_space` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parking_id` int(11) NOT NULL,
  `height` double NOT NULL,
  `width` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E00675CCF17B2DD` (`parking_id`),
  CONSTRAINT `FK_E00675CCF17B2DD` FOREIGN KEY (`parking_id`) REFERENCES `parking` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `parking_space` (`id`, `parking_id`, `height`, `width`) VALUES
(18,	10,	4,	2),
(19,	10,	4,	2),
(20,	10,	4,	2),
(21,	10,	4,	2),
(22,	10,	4,	2),
(23,	10,	4,	2),
(24,	10,	4,	2),
(25,	10,	4,	2),
(26,	10,	4,	2),
(27,	10,	4,	2),
(28,	11,	3,	2),
(29,	11,	3,	2),
(30,	11,	3,	2),
(31,	11,	3,	2),
(32,	11,	3,	2),
(33,	11,	3,	2),
(34,	11,	3,	2),
(35,	11,	3,	2),
(36,	11,	3,	2),
(37,	11,	3,	2),
(38,	12,	3,	2),
(39,	12,	3,	2),
(40,	12,	3,	2),
(41,	12,	3,	2),
(42,	12,	3,	2),
(43,	12,	3,	2),
(44,	12,	3,	2),
(45,	12,	3,	2),
(46,	12,	3,	2),
(47,	12,	3,	2),
(58,	14,	3,	2),
(59,	14,	3,	2),
(60,	14,	3,	2),
(61,	14,	3,	2),
(62,	14,	3,	2),
(63,	15,	3,	2),
(64,	15,	3,	2),
(65,	15,	3,	2),
(66,	15,	3,	2),
(67,	15,	3,	2),
(68,	15,	3,	2),
(69,	15,	3,	2),
(70,	15,	3,	2),
(71,	15,	3,	2),
(72,	15,	3,	2),
(82,	16,	10,	10),
(83,	16,	10,	10),
(84,	13,	2,	3),
(85,	13,	2,	3),
(86,	13,	2,	3),
(87,	13,	2,	3),
(88,	13,	2,	3),
(89,	13,	2,	3),
(90,	13,	2,	3),
(91,	13,	2,	3),
(92,	13,	2,	3),
(93,	13,	2,	3);

-- 2020-08-21 22:20:50