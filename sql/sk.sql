-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: localhost    Database: sk
-- ------------------------------------------------------
-- Server version	8.0.39

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `barangay`
--

DROP TABLE IF EXISTS `barangay`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `barangay` (
  `id` int NOT NULL AUTO_INCREMENT,
  `barangay_name` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `coordinates` LONGTEXT NOT NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  `deleted_at` timestamp,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `post_title` longtext,
  `post_description` longtext,
  `post_image` varchar(255) DEFAULT NULL,
  `post_category` varchar(255) DEFAULT NULL,
  `post_priority` varchar(255) DEFAULT NULL,
  `created_at` timestamp,
  `updated_at` timestamp,
  `deleted_at` timestamp,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (2,'csdcsd','cdscsdcds','uploads/posts/67b3609e4b247.jpg','Events','High','2025-02-17 16:15:26',NULL,NULL);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `residents`
--

DROP TABLE IF EXISTS `residents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `residents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) DEFAULT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `suffix` varchar(255) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `bdate` date DEFAULT NULL,
  `age` int DEFAULT NULL,
  `bplace` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `alternate_phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `national_id` varchar(255) DEFAULT NULL,
  `ssn_tax_id` varchar(255) DEFAULT NULL,
  `drivers_license` varchar(255) DEFAULT NULL,
  `voters_id` varchar(255) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `work_address` varchar(255) DEFAULT NULL,
  `education_level` varchar(255) DEFAULT NULL,
  `school_name` varchar(255) DEFAULT NULL,
  `field_of_study` varchar(255) DEFAULT NULL,
  `emergency_contact_name` varchar(255) DEFAULT NULL,
  `emergency_contact_relation` varchar(255) DEFAULT NULL,
  `emergency_contact_phone` varchar(255) DEFAULT NULL,
  `marital_status` varchar(255) DEFAULT NULL,
  `spouse_name` varchar(255) DEFAULT NULL,
  `children_count` varchar(255) DEFAULT NULL,
  `blood_type` varchar(255) DEFAULT NULL,
  `medical_conditions` varchar(255) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `hobbies_interests` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `residents`
--

LOCK TABLES `residents` WRITE;
/*!40000 ALTER TABLE `residents` DISABLE KEYS */;
INSERT INTO `residents` VALUES (1,'a','Jasper Griffin','s','s','asxasx','Male','1999-12-26',25,'Exercitationem volup','asx','denzlord13@gmail.com','23343','344334','2807 West Magnolia Boulevard Burbank','Burbank','CA','United States','91505','Malachi','Madeline','Hammett','Nero','Id rem eos officiis','Cote and Valentine LLC','2807 West Magnolia Boulevard Burbank','Cameron','scd','Labore voluptates es','vdfvdf','Corrupti ut saepe c','3434','Single','sdc','2','O+','dsd','d','d','2025-02-13 20:29:13','2025-02-13 20:29:13'),(2,'Ayanna','Gary','Addison','Palmer','Astra','Other','2023-10-10',190,'Micah','Serena','qukud@mailinator.com','Rigel','Declan','Id modi illum delen','Cooper','Quamar','Deirdre','Audra','Violet','Jessica','Ezra','Rina','Taylor','Simone','Amet qui ab labore ','Xyla','Melinda','Xenos','Stephen','Cain','Jillian','Married','Aimee','142','B-','Doloribus amet corp','Xandra','Sapiente nihil lorem','2025-02-13 20:35:31','2025-02-13 20:35:31'),(3,'Shelby','Carolyn','Jeremy','Ciaran','Samuel','Female','1980-10-29',505,'Jescie','Kiayada','botam@mailinator.com','Zeus','Kenyon','Aut dignissimos culp','Amelia','Fiona','Harlan','Moses','Joel','Vielka','Moana','Camille','Angelica','Pamela','Recusandae Aut aliq','Joelle','Owen','Bernard','Grant','Lyle','Wing','Single','Armando','57','B+','Dolore consequuntur ','Marny','Rem proident aut no','2025-02-17 16:15:42','2025-02-17 16:15:42');
/*!40000 ALTER TABLE `residents` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-02-18  0:17:16
