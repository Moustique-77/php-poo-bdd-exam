-- MariaDB dump 10.19-11.1.2-MariaDB, for osx10.19 (arm64)
--
-- Host: localhost    Database: php_exam
-- ------------------------------------------------------
-- Server version	11.1.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ArmeInventaire`
--

DROP TABLE IF EXISTS `ArmeInventaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ArmeInventaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `arme_id` int(11) DEFAULT NULL,
  `inventaire_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `arme_id` (`arme_id`),
  CONSTRAINT `armeinventaire_ibfk_2` FOREIGN KEY (`arme_id`) REFERENCES `Armes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ArmeInventaire`
--

LOCK TABLES `ArmeInventaire` WRITE;
/*!40000 ALTER TABLE `ArmeInventaire` DISABLE KEYS */;
/*!40000 ALTER TABLE `ArmeInventaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Armes`
--

DROP TABLE IF EXISTS `Armes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Armes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `niveau_requis` int(11) DEFAULT NULL,
  `points_attaque_bonus` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Armes`
--

LOCK TABLES `Armes` WRITE;
/*!40000 ALTER TABLE `Armes` DISABLE KEYS */;
INSERT INTO `Armes` VALUES
(1,'Épée de fer',1,5),
(2,'Arc elfique',2,8),
(3,'Épée en bois',0,2),
(4,'Hache',3,10);
/*!40000 ALTER TABLE `Armes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Inventaire`
--

DROP TABLE IF EXISTS `Inventaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Inventaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `personnage_id` int(11) DEFAULT NULL,
  `objet_id` text DEFAULT NULL,
  `arme_id` text DEFAULT NULL,
  `taille` int(11) DEFAULT 10,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=216 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Inventaire`
--

LOCK TABLES `Inventaire` WRITE;
/*!40000 ALTER TABLE `Inventaire` DISABLE KEYS */;
INSERT INTO `Inventaire` VALUES
(4,6,NULL,NULL,10),
(5,7,NULL,NULL,10),
(6,8,NULL,NULL,10),
(7,9,NULL,NULL,10),
(8,10,NULL,NULL,10),
(9,11,NULL,NULL,10),
(10,12,NULL,NULL,10),
(11,13,NULL,NULL,10),
(12,14,NULL,NULL,10),
(13,15,NULL,NULL,10),
(14,16,NULL,NULL,10),
(15,17,NULL,NULL,10),
(16,18,NULL,NULL,10),
(17,19,NULL,NULL,10),
(18,20,NULL,NULL,10),
(19,20,NULL,NULL,10),
(20,22,NULL,NULL,10),
(21,23,NULL,NULL,10),
(22,24,NULL,NULL,10),
(23,25,NULL,NULL,10),
(24,26,NULL,NULL,10),
(25,27,NULL,NULL,10),
(26,28,NULL,NULL,10),
(27,29,NULL,NULL,10),
(28,30,NULL,NULL,10),
(29,31,NULL,NULL,10),
(30,32,NULL,NULL,10),
(31,33,NULL,NULL,10),
(32,34,NULL,NULL,10),
(33,35,NULL,NULL,10),
(34,36,NULL,NULL,10),
(35,37,NULL,NULL,10),
(36,38,NULL,NULL,10),
(37,39,NULL,NULL,10),
(38,40,NULL,NULL,10),
(39,41,NULL,'1',10),
(40,42,NULL,NULL,10),
(41,43,NULL,NULL,10),
(42,44,NULL,'1',10),
(43,45,NULL,NULL,10),
(44,46,NULL,NULL,10),
(45,47,NULL,NULL,10),
(46,48,NULL,NULL,10),
(47,49,NULL,NULL,10),
(48,50,NULL,NULL,10),
(49,51,NULL,NULL,10),
(50,52,NULL,NULL,10),
(51,53,NULL,NULL,10),
(52,54,NULL,'1',10),
(53,55,NULL,NULL,10),
(54,56,NULL,'1',10),
(55,57,NULL,'1,2',10),
(56,58,NULL,'1,2',10),
(57,55,NULL,NULL,10),
(58,60,NULL,'2,1',10),
(59,61,NULL,'2',10),
(60,62,NULL,NULL,10),
(61,63,NULL,NULL,10),
(62,64,NULL,'2',10),
(63,65,NULL,'2',10),
(64,66,NULL,'2,1',10),
(65,67,NULL,'2,#',10),
(66,68,NULL,'2,1',10),
(67,69,NULL,'2,1',10),
(68,70,NULL,'2,1',10),
(69,71,NULL,'1',10),
(70,72,NULL,'2,1',10),
(71,73,NULL,'1,2',10),
(72,55,NULL,NULL,10),
(73,75,NULL,'1',10),
(74,76,NULL,NULL,10),
(75,77,NULL,NULL,10),
(76,78,NULL,NULL,10),
(77,79,NULL,NULL,10),
(78,80,'1',NULL,10),
(79,81,NULL,NULL,10),
(80,82,NULL,NULL,10),
(81,83,'1,2',NULL,10),
(82,84,'1,2',NULL,10),
(83,85,NULL,NULL,10),
(84,86,'2','1',10),
(85,87,'1,2','2,1',10),
(86,88,NULL,NULL,10),
(87,89,NULL,NULL,10),
(88,90,NULL,NULL,10),
(89,91,'1,2','2,1',10),
(90,90,NULL,NULL,10),
(91,93,'1,2','2,1',10),
(92,94,NULL,NULL,10),
(93,95,NULL,NULL,10),
(94,96,NULL,NULL,10),
(95,97,NULL,'0',10),
(96,98,NULL,'0',10),
(97,99,'2','1,2',10),
(98,100,'2,1','2',10),
(99,101,'2,1','1,2',10),
(100,102,'1,2','2,1',10),
(101,103,NULL,'0',10),
(102,104,'1,2','2',10),
(103,105,'2,1','2',10),
(104,106,'1,2','1',10),
(105,107,'2,1','1,2',10),
(106,108,'1','2,2',10),
(107,109,NULL,NULL,10),
(108,110,NULL,NULL,10),
(109,111,'1,2','1',10),
(110,112,NULL,NULL,10),
(111,113,'1,2','2,1',10),
(112,114,'1','2,2',10),
(113,115,NULL,NULL,10),
(114,116,NULL,NULL,10),
(115,117,NULL,NULL,10),
(116,118,NULL,NULL,10),
(117,119,'1,2','2,1',10),
(118,120,NULL,NULL,10),
(119,121,NULL,NULL,10),
(120,122,NULL,NULL,10),
(121,120,NULL,NULL,10),
(122,124,NULL,NULL,10),
(124,109,NULL,NULL,10),
(125,127,'1,2','2,1',10),
(126,128,NULL,NULL,10),
(127,129,'2,1','1,2',10),
(129,131,NULL,NULL,10),
(130,132,'2,1','1,2',10),
(131,133,NULL,'',10),
(132,134,NULL,NULL,10),
(133,135,'1,2','2,1',10),
(134,136,NULL,NULL,10),
(135,137,'1,2','2,#',10),
(136,138,NULL,NULL,10),
(137,139,NULL,NULL,10),
(138,140,NULL,'',10),
(139,133,NULL,NULL,10),
(140,142,'1,2','2',10),
(141,143,'2','1',10),
(142,144,'2','1',10),
(143,145,'1,2','2',10),
(144,146,'2,1','2',10),
(145,147,'2','1',10),
(146,148,'1,2','2,1',10),
(147,149,NULL,NULL,10),
(148,150,'2','',10),
(149,151,'2','1,2',10),
(150,152,NULL,NULL,10),
(151,153,NULL,NULL,10),
(152,154,'2','1',10),
(153,155,'1','2',10),
(154,156,'1','2',10),
(155,157,'2','1',10),
(156,152,NULL,NULL,10),
(157,153,NULL,NULL,10),
(158,160,NULL,NULL,10),
(159,161,NULL,NULL,10),
(160,162,'2','1',10),
(161,163,NULL,NULL,10),
(162,164,NULL,NULL,10),
(163,165,'2','1',10),
(164,166,NULL,NULL,10),
(165,167,'1','2',10),
(166,109,NULL,NULL,10),
(167,169,'2','1',10),
(168,170,'2','1',10),
(169,171,NULL,NULL,10),
(170,172,'2','1',10),
(171,173,'2','1',10),
(172,174,'2','1',10),
(173,175,'2','1',10),
(174,176,NULL,NULL,10),
(175,177,NULL,NULL,10),
(176,178,NULL,NULL,10),
(177,179,NULL,NULL,10),
(178,180,NULL,NULL,10),
(179,181,NULL,NULL,10),
(180,182,NULL,NULL,10),
(181,183,NULL,NULL,10),
(182,184,NULL,NULL,10),
(183,185,NULL,NULL,10),
(184,186,NULL,NULL,10),
(185,187,NULL,NULL,10),
(186,188,NULL,NULL,10),
(187,189,NULL,NULL,10),
(188,190,'2','1',10),
(189,191,'1,2,4','1,2,3',10),
(190,192,'1,2,4','1,2,3',10),
(191,193,'1,2,3','1,2,3',10),
(192,194,NULL,NULL,10),
(193,195,NULL,NULL,10),
(194,196,NULL,NULL,10),
(195,197,NULL,NULL,10),
(196,198,NULL,NULL,10),
(197,199,'1,2,3','1,2,3',10),
(198,200,'1,2,3','1,2,3,3',10),
(199,201,'3,1','1,3,1',10),
(200,202,'2,3','3,2',10),
(201,203,NULL,NULL,10),
(202,204,'3',NULL,10),
(203,205,NULL,NULL,10),
(204,206,NULL,NULL,10),
(205,207,NULL,NULL,10),
(206,208,NULL,'4',10),
(207,209,'5',NULL,10),
(208,210,NULL,NULL,10),
(209,211,'4,3','3',10),
(210,212,'2',NULL,10),
(211,213,NULL,NULL,10),
(212,214,'2',NULL,10),
(213,215,NULL,NULL,10),
(214,216,NULL,NULL,10),
(215,217,NULL,NULL,10);
/*!40000 ALTER TABLE `Inventaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Marchand`
--

DROP TABLE IF EXISTS `Marchand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Marchand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `objet_id` text NOT NULL,
  `arme_id` text NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Marchand`
--

LOCK TABLES `Marchand` WRITE;
/*!40000 ALTER TABLE `Marchand` DISABLE KEYS */;
INSERT INTO `Marchand` VALUES
(1,'forgeron','NULL','1,2','je posède les meilleurs épée du marché !'),
(2,'forgemage','1,2','NULL','je fabrique mes potions depuis la nuit des temps...');
/*!40000 ALTER TABLE `Marchand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Monstres`
--

DROP TABLE IF EXISTS `Monstres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Monstres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `points_vie` int(11) DEFAULT NULL,
  `points_attaque` int(11) DEFAULT NULL,
  `points_defense` int(11) DEFAULT NULL,
  `salle_id` int(11) DEFAULT NULL,
  `arme_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `salle_id` (`salle_id`),
  CONSTRAINT `monstres_ibfk_1` FOREIGN KEY (`salle_id`) REFERENCES `Salles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Monstres`
--

LOCK TABLES `Monstres` WRITE;
/*!40000 ALTER TABLE `Monstres` DISABLE KEYS */;
INSERT INTO `Monstres` VALUES
(3,'Dragon Noir',200,30,25,1,1),
(4,'Gobelin',50,10,5,3,2),
(5,'Orc',100,20,10,1,1),
(6,'Orgre',100,20,10,1,1);
/*!40000 ALTER TABLE `Monstres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ObjetsInventaire`
--

DROP TABLE IF EXISTS `ObjetsInventaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ObjetsInventaire` (
  `inventaire_id` int(11) DEFAULT NULL,
  `objet_id` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ObjetsInventaire`
--

LOCK TABLES `ObjetsInventaire` WRITE;
/*!40000 ALTER TABLE `ObjetsInventaire` DISABLE KEYS */;
/*!40000 ALTER TABLE `ObjetsInventaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ObjetsMagiques`
--

DROP TABLE IF EXISTS `ObjetsMagiques`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ObjetsMagiques` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `effet_special` text DEFAULT NULL,
  `est_maudit` tinyint(1) DEFAULT NULL,
  `types` varchar(100) NOT NULL,
  `valeur` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ObjetsMagiques`
--

LOCK TABLES `ObjetsMagiques` WRITE;
/*!40000 ALTER TABLE `ObjetsMagiques` DISABLE KEYS */;
INSERT INTO `ObjetsMagiques` VALUES
(1,'Amulette de Protection','Augmente la défense du personnage de 10',0,'defense',10),
(2,'Potion de Guérison','Restaure 50 points de vie',0,'vie',50),
(3,'Anneau de Malchance','Vous perdez 30 points de vie',1,'vie',-30),
(4,'Talisman de Fragilité','Vous perdez 20 points de défence',1,'defense',-20);
/*!40000 ALTER TABLE `ObjetsMagiques` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Personnages`
--

DROP TABLE IF EXISTS `Personnages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Personnages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `points_vie` int(11) DEFAULT NULL,
  `points_attaque` int(11) DEFAULT NULL,
  `points_defense` int(11) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  `niveau` int(11) DEFAULT NULL,
  `arme_equiper_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=218 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Personnages`
--

LOCK TABLES `Personnages` WRITE;
/*!40000 ALTER TABLE `Personnages` DISABLE KEYS */;
INSERT INTO `Personnages` VALUES
(215,'Bob',200,20,10,0,1,3),
(216,'Enzo',200,20,10,0,1,3),
(217,'Téo',200,20,10,0,1,3);
/*!40000 ALTER TABLE `Personnages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Salles`
--

DROP TABLE IF EXISTS `Salles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Salles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Salles`
--

LOCK TABLES `Salles` WRITE;
/*!40000 ALTER TABLE `Salles` DISABLE KEYS */;
INSERT INTO `Salles` VALUES
(1,'classique','rien de spécial ici...'),
(2,'bonus','chercher le trésors.'),
(3,'piège','attention à vous !'),
(4,'marchant','faites des échanges rapidement !');
/*!40000 ALTER TABLE `Salles` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-24 16:44:40
