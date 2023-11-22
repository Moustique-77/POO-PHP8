-- MariaDB dump 10.19-11.1.2-MariaDB, for osx10.19 (arm64)
--
-- Host: localhost    Database: php_tp2
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
-- Table structure for table `niveaux`
--

DROP TABLE IF EXISTS `niveaux`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `niveaux` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_niveau` varchar(50) NOT NULL,
  `difficulte` varchar(50) NOT NULL,
  `etoiles_requises` int(11) NOT NULL,
  `etoiles_disponibles` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `niveaux`
--

LOCK TABLES `niveaux` WRITE;
/*!40000 ALTER TABLE `niveaux` DISABLE KEYS */;
INSERT INTO `niveaux` VALUES
(1,'Monde 1-1','Facile',0,5),
(2,'Monde 1-2','Facile',5,8),
(3,'Monde 1-3','Facile',8,10),
(4,'Monde 1-4','Intermédiaire',10,12),
(5,'Monde 2-1','Facile',0,6),
(6,'Monde 2-2','Facile',6,9),
(7,'Monde 2-3','Facile',9,11),
(8,'Monde 2-4','Intermédiaire',11,13),
(9,'Monde 3-1','Moyen',0,7),
(10,'Monde 3-2','Moyen',7,10),
(11,'Monde 3-3','Moyen',10,13),
(12,'Monde 3-4','Difficile',13,16),
(13,'Monde 4-1','Moyen',0,8),
(14,'Monde 4-2','Moyen',8,11),
(15,'Monde 4-3','Moyen',11,14),
(16,'Monde 4-4','Difficile',14,17);
/*!40000 ALTER TABLE `niveaux` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personnages`
--

DROP TABLE IF EXISTS `personnages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personnages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `niveau_actuel` int(11) NOT NULL,
  `etoiles_collectees` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `niveau_actuel` (`niveau_actuel`),
  CONSTRAINT `personnages_ibfk_1` FOREIGN KEY (`niveau_actuel`) REFERENCES `niveaux` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personnages`
--

LOCK TABLES `personnages` WRITE;
/*!40000 ALTER TABLE `personnages` DISABLE KEYS */;
INSERT INTO `personnages` VALUES
(1,'Mario',1,0);
/*!40000 ALTER TABLE `personnages` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-22 14:10:57
