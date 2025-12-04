-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for osx10.10 (x86_64)
--
-- Host: localhost    Database: db_ausbildung
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

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
-- Table structure for table `tbl_countries`
--

DROP TABLE IF EXISTS `tbl_countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_countries` (
  `id_country` int(11) NOT NULL AUTO_INCREMENT,
  `country` varchar(100) NOT NULL,
  PRIMARY KEY (`id_country`),
  UNIQUE KEY `country` (`country`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_countries`
--

LOCK TABLES `tbl_countries` WRITE;
/*!40000 ALTER TABLE `tbl_countries` DISABLE KEYS */;
INSERT INTO `tbl_countries` VALUES (8,'Austria'),(7,'Germany'),(6,'Switzerland');
/*!40000 ALTER TABLE `tbl_countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_dozenten`
--

DROP TABLE IF EXISTS `tbl_dozenten`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_dozenten` (
  `id_dozent` int(11) NOT NULL AUTO_INCREMENT,
  `vorname` varchar(100) NOT NULL,
  `nachname` varchar(100) NOT NULL,
  `strasse` varchar(255) DEFAULT NULL,
  `plz` varchar(10) DEFAULT NULL,
  `ort` varchar(100) DEFAULT NULL,
  `nr_land` int(11) DEFAULT NULL,
  `geschlecht` enum('m','w','d') DEFAULT NULL,
  `telefon` varchar(30) DEFAULT NULL,
  `handy` varchar(30) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `birthdate` date DEFAULT NULL,
  PRIMARY KEY (`id_dozent`),
  UNIQUE KEY `email` (`email`),
  KEY `nr_land` (`nr_land`),
  CONSTRAINT `tbl_dozenten_ibfk_1` FOREIGN KEY (`nr_land`) REFERENCES `tbl_countries` (`id_country`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_dozenten`
--

LOCK TABLES `tbl_dozenten` WRITE;
/*!40000 ALTER TABLE `tbl_dozenten` DISABLE KEYS */;
INSERT INTO `tbl_dozenten` VALUES (6,'Hans','Mueller','Hauptstrasse 1','8000','Zurich',6,'m','044 123 4567','079 123 4567','hans.mueller@example.com','1970-05-15'),(7,'Marie','Schmidt','Bahnhofstrasse 2','8001','Zurich',6,'w','044 234 5678','079 234 5678','marie.schmidt@example.com','1975-08-22'),(8,'Klaus','Weber','Kirchenstrasse 3','8002','Zurich',7,'m','044 345 6789','079 345 6789','klaus.weber@example.com','1968-03-10');
/*!40000 ALTER TABLE `tbl_dozenten` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_kurse`
--

DROP TABLE IF EXISTS `tbl_kurse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_kurse` (
  `id_kurs` int(11) NOT NULL AUTO_INCREMENT,
  `kursnummer` varchar(50) NOT NULL,
  `kursthema` varchar(255) NOT NULL,
  `inhalt` text DEFAULT NULL,
  `nr_dozent` int(11) DEFAULT NULL,
  `startdatum` date DEFAULT NULL,
  `enddatum` date DEFAULT NULL,
  `dauer` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_kurs`),
  UNIQUE KEY `kursnummer` (`kursnummer`),
  KEY `nr_dozent` (`nr_dozent`),
  CONSTRAINT `tbl_kurse_ibfk_1` FOREIGN KEY (`nr_dozent`) REFERENCES `tbl_dozenten` (`id_dozent`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_kurse`
--

LOCK TABLES `tbl_kurse` WRITE;
/*!40000 ALTER TABLE `tbl_kurse` DISABLE KEYS */;
INSERT INTO `tbl_kurse` VALUES (5,'K001','PHP Web Development','Learn PHP programming basics and advanced techniques',6,'2024-01-15','2024-03-15','8 weeks'),(6,'K002','Database Design','Introduction to database design and SQL',7,'2024-02-01','2024-03-30','8 weeks'),(7,'K003','JavaScript Advanced','Advanced JavaScript concepts and frameworks',8,'2024-02-15','2024-04-15','8 weeks');
/*!40000 ALTER TABLE `tbl_kurse` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_kurse_lernende`
--

DROP TABLE IF EXISTS `tbl_kurse_lernende`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_kurse_lernende` (
  `id_kurse_lernende` int(11) NOT NULL AUTO_INCREMENT,
  `nr_lernende` int(11) NOT NULL,
  `nr_kurs` int(11) NOT NULL,
  `note` decimal(3,1) DEFAULT NULL,
  PRIMARY KEY (`id_kurse_lernende`),
  UNIQUE KEY `uq_kurs_lernender` (`nr_lernende`,`nr_kurs`),
  KEY `nr_kurs` (`nr_kurs`),
  CONSTRAINT `tbl_kurse_lernende_ibfk_1` FOREIGN KEY (`nr_lernende`) REFERENCES `tbl_lernende` (`id_lernende`) ON DELETE CASCADE,
  CONSTRAINT `tbl_kurse_lernende_ibfk_2` FOREIGN KEY (`nr_kurs`) REFERENCES `tbl_kurse` (`id_kurs`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_kurse_lernende`
--

LOCK TABLES `tbl_kurse_lernende` WRITE;
/*!40000 ALTER TABLE `tbl_kurse_lernende` DISABLE KEYS */;
INSERT INTO `tbl_kurse_lernende` VALUES (5,13,5,4.5),(6,14,5,5.0),(7,15,6,4.0);
/*!40000 ALTER TABLE `tbl_kurse_lernende` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_lehrbetrieb_lernende`
--

DROP TABLE IF EXISTS `tbl_lehrbetrieb_lernende`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_lehrbetrieb_lernende` (
  `id_lehrbetrieb_lernende` int(11) NOT NULL AUTO_INCREMENT,
  `nr_lehrbetrieb` int(11) NOT NULL,
  `nr_lernende` int(11) NOT NULL,
  `start` date DEFAULT NULL,
  `ende` date DEFAULT NULL,
  `beruf` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_lehrbetrieb_lernende`),
  UNIQUE KEY `uq_betrieb_lernender` (`nr_lehrbetrieb`,`nr_lernende`),
  KEY `nr_lernende` (`nr_lernende`),
  CONSTRAINT `tbl_lehrbetrieb_lernende_ibfk_1` FOREIGN KEY (`nr_lehrbetrieb`) REFERENCES `tbl_lehrbetriebe` (`id_lehrbetrieb`) ON DELETE CASCADE,
  CONSTRAINT `tbl_lehrbetrieb_lernende_ibfk_2` FOREIGN KEY (`nr_lernende`) REFERENCES `tbl_lernende` (`id_lernende`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_lehrbetrieb_lernende`
--

LOCK TABLES `tbl_lehrbetrieb_lernende` WRITE;
/*!40000 ALTER TABLE `tbl_lehrbetrieb_lernende` DISABLE KEYS */;
INSERT INTO `tbl_lehrbetrieb_lernende` VALUES (7,4,13,'2024-01-01','2024-12-31','IT Specialist'),(8,5,14,'2024-02-01','2025-01-31','Web Developer'),(9,6,15,'2024-03-01','2025-02-28','Software Engineer');
/*!40000 ALTER TABLE `tbl_lehrbetrieb_lernende` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_lehrbetriebe`
--

DROP TABLE IF EXISTS `tbl_lehrbetriebe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_lehrbetriebe` (
  `id_lehrbetrieb` int(11) NOT NULL AUTO_INCREMENT,
  `firma` varchar(255) NOT NULL,
  `strasse` varchar(255) DEFAULT NULL,
  `plz` varchar(10) DEFAULT NULL,
  `ort` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_lehrbetrieb`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_lehrbetriebe`
--

LOCK TABLES `tbl_lehrbetriebe` WRITE;
/*!40000 ALTER TABLE `tbl_lehrbetriebe` DISABLE KEYS */;
INSERT INTO `tbl_lehrbetriebe` VALUES (4,'Tech Solutions AG','Innovation Strasse 10','8050','Zurich'),(5,'Digital Services GmbH','Industriestrasse 5','8090','Zurich'),(6,'Software Experts Ltd','Technoparkstrasse 1','8005','Zurich');
/*!40000 ALTER TABLE `tbl_lehrbetriebe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_lernende`
--

DROP TABLE IF EXISTS `tbl_lernende`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_lernende` (
  `id_lernende` int(11) NOT NULL AUTO_INCREMENT,
  `vorname` varchar(100) NOT NULL,
  `nachname` varchar(100) NOT NULL,
  `strasse` varchar(255) DEFAULT NULL,
  `plz` varchar(10) DEFAULT NULL,
  `ort` varchar(100) DEFAULT NULL,
  `nr_land` int(11) DEFAULT NULL,
  `geschlecht` enum('m','w','d') DEFAULT NULL,
  `telefon` varchar(30) DEFAULT NULL,
  `handy` varchar(30) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_privat` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  PRIMARY KEY (`id_lernende`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `email_privat` (`email_privat`),
  KEY `nr_land` (`nr_land`),
  CONSTRAINT `tbl_lernende_ibfk_1` FOREIGN KEY (`nr_land`) REFERENCES `tbl_countries` (`id_country`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_lernende`
--

LOCK TABLES `tbl_lernende` WRITE;
/*!40000 ALTER TABLE `tbl_lernende` DISABLE KEYS */;
INSERT INTO `tbl_lernende` VALUES (13,'Anna','Meier','Seestrasse 1','8000','Zurich',6,'w','044 111 2222','079 111 2222','anna.meier@school.ch','anna.meier@gmail.com','2005-03-20'),(14,'Benjamin','Keller','Waldstrasse 5','8010','Zurich',6,'m','044 222 3333','079 222 3333','benjamin.keller@school.ch','ben.keller@gmail.com','2004-07-15'),(15,'Carla','Schneider','Bergstrasse 12','8020','Zurich',6,'w','044 333 4444','079 333 4444','carla.schneider@school.ch','carla.s@gmail.com','2006-01-10');
/*!40000 ALTER TABLE `tbl_lernende` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-04 14:17:20
