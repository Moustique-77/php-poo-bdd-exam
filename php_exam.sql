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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Armes`
--

LOCK TABLES `Armes` WRITE;
/*!40000 ALTER TABLE `Armes` DISABLE KEYS */;
INSERT INTO `Armes` VALUES
(1,'Épée de fer',1,5),
(2,'Arc elfique',2,8);
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
  `taille` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Inventaire`
--

LOCK TABLES `Inventaire` WRITE;
/*!40000 ALTER TABLE `Inventaire` DISABLE KEYS */;
/*!40000 ALTER TABLE `Inventaire` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Monstres`
--

LOCK TABLES `Monstres` WRITE;
/*!40000 ALTER TABLE `Monstres` DISABLE KEYS */;
INSERT INTO `Monstres` VALUES
(3,'Dragon Noir',200,30,25,1,3),
(4,'Gobelin',50,10,5,2,2);
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ObjetsMagiques`
--

LOCK TABLES `ObjetsMagiques` WRITE;
/*!40000 ALTER TABLE `ObjetsMagiques` DISABLE KEYS */;
INSERT INTO `ObjetsMagiques` VALUES
(1,'Amulette de Protection','Augmente la défense du personnage',0),
(2,'Potion de Guérison','Restaure 50 points de vie',0),
(3,'Anneau de Malchance','Diminue les chances de succès lors des attaques',1),
(4,'Talisman de Fragilité','Réduit temporairement la défense du porteur après utilisation',1);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Personnages`
--

LOCK TABLES `Personnages` WRITE;
/*!40000 ALTER TABLE `Personnages` DISABLE KEYS */;
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
(1,'Classique','Rien de spécial ici...'),
(2,'Bonus','Chercher le trésors.'),
(3,'Piege','Attentionà vous !'),
(4,'Marchant','Faites des échanges le marchant.');
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

-- Dump completed on 2023-11-23 14:58:20
