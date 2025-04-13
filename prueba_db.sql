-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: prueba_db
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `aprendices`
--

DROP TABLE IF EXISTS `aprendices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aprendices` (
  `id` int NOT NULL AUTO_INCREMENT,
  `persona_id` int NOT NULL,
  `numero_ficha` varchar(20) NOT NULL,
  `programa_formacion_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `persona_id` (`persona_id`),
  KEY `fk_programa_formacion` (`programa_formacion_id`),
  CONSTRAINT `aprendices_ibfk_1` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`),
  CONSTRAINT `fk_programa_formacion` FOREIGN KEY (`programa_formacion_id`) REFERENCES `programa_formacion` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aprendices`
--

LOCK TABLES `aprendices` WRITE;
/*!40000 ALTER TABLE `aprendices` DISABLE KEYS */;
INSERT INTO `aprendices` VALUES (1,1,'2568340',1),(2,2,'2568341',2),(3,3,'2923560',1),(4,4,'122020211',1);
/*!40000 ALTER TABLE `aprendices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo_sanguineo`
--

DROP TABLE IF EXISTS `grupo_sanguineo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `grupo_sanguineo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `grupo` varchar(3) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_grupo_sanguineo` (`grupo`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo_sanguineo`
--

LOCK TABLES `grupo_sanguineo` WRITE;
/*!40000 ALTER TABLE `grupo_sanguineo` DISABLE KEYS */;
INSERT INTO `grupo_sanguineo` VALUES (7,'A-'),(3,'A+'),(9,'AB-'),(5,'AB+'),(8,'B-'),(4,'B+'),(6,'O-'),(1,'O+');
/*!40000 ALTER TABLE `grupo_sanguineo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personas`
--

DROP TABLE IF EXISTS `personas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `primer_nombre` varchar(50) NOT NULL,
  `segundo_nombre` varchar(50) DEFAULT NULL,
  `primer_apellido` varchar(50) NOT NULL,
  `segundo_apellido` varchar(50) DEFAULT NULL,
  `tipo_documento_id` int NOT NULL,
  `numero_documento` varchar(20) NOT NULL,
  `sexo_id` int NOT NULL,
  `grupo_sanguineo_id` int DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `numero_documento` (`numero_documento`),
  KEY `tipo_documento_id` (`tipo_documento_id`),
  KEY `sexo_id` (`sexo_id`),
  KEY `grupo_sanguineo_id` (`grupo_sanguineo_id`),
  CONSTRAINT `personas_ibfk_1` FOREIGN KEY (`tipo_documento_id`) REFERENCES `tipo_documento` (`id`),
  CONSTRAINT `personas_ibfk_2` FOREIGN KEY (`sexo_id`) REFERENCES `sexo` (`id`),
  CONSTRAINT `personas_ibfk_3` FOREIGN KEY (`grupo_sanguineo_id`) REFERENCES `grupo_sanguineo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personas`
--

LOCK TABLES `personas` WRITE;
/*!40000 ALTER TABLE `personas` DISABLE KEYS */;
INSERT INTO `personas` VALUES (1,'Carlos','Andrés','Pérez','Gómez',2,'123456789',1,1,'2000-05-15'),(2,'María',NULL,'Rodríguez','López',2,'987654321',1,1,'1999-10-22'),(3,'Hernan','David','Cifuentes','Arenas',2,'1120578120',1,1,'1998-07-13'),(4,'Samuel','','Cifuentes','Arenas',2,'1129433399',1,3,'1993-12-13');
/*!40000 ALTER TABLE `personas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `programa_formacion`
--

DROP TABLE IF EXISTS `programa_formacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `programa_formacion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programa_formacion`
--

LOCK TABLES `programa_formacion` WRITE;
/*!40000 ALTER TABLE `programa_formacion` DISABLE KEYS */;
INSERT INTO `programa_formacion` VALUES (1,'Desarrollo de Software'),(2,'Análisis y Desarrollo de Sistemas de Información');
/*!40000 ALTER TABLE `programa_formacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sexo`
--

DROP TABLE IF EXISTS `sexo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sexo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sexo`
--

LOCK TABLES `sexo` WRITE;
/*!40000 ALTER TABLE `sexo` DISABLE KEYS */;
INSERT INTO `sexo` VALUES (1,'Masculino'),(3,'Femenino');
/*!40000 ALTER TABLE `sexo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_documento`
--

DROP TABLE IF EXISTS `tipo_documento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_documento` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_documento`
--

LOCK TABLES `tipo_documento` WRITE;
/*!40000 ALTER TABLE `tipo_documento` DISABLE KEYS */;
INSERT INTO `tipo_documento` VALUES (2,'CC','Cédula de Ciudadanía'),(3,'TI','Tarjeta de Identidad');
/*!40000 ALTER TABLE `tipo_documento` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-13 16:31:43
