-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: localhost    Database: sk
-- ------------------------------------------------------
-- Server version	8.0.41

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
  `coordinates` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barangay`
--

LOCK TABLES `barangay` WRITE;
/*!40000 ALTER TABLE `barangay` DISABLE KEYS */;
INSERT INTO `barangay` VALUES (3,'test','125.34099545843','6.767034388312','[[6.767034388311976,125.34099545843094],[6.746407623604096,125.32125440008133],[6.737883910462913,125.36683049566238]]','2025-02-27 19:39:05','2025-02-27 20:08:26',NULL),(4,'axsaaxs','125.31085407904','6.7757985770294','[[6.775798577029409,125.31085407904051],[6.759433909521553,125.30690586737059],[6.774434875929199,125.32184040716551]]','2025-02-27 19:39:45',NULL,NULL),(5,'vvv','125.32819187811','6.7734120975737','[[6.773412097573734,125.32819187811278],[6.768298173275613,125.32802021673582],[6.773156402646031,125.32965099981688]]','2025-02-27 19:43:55',NULL,NULL),(6,'cscds','3433.999','43433.999','[[43433.999,3433.999],[43433.999,3434.001],[43434.001,3434.001],[43434.001,3433.999]]','2025-02-27 19:46:06',NULL,NULL),(7,'digos','125.35622','6.74872','[[6.74872,125.35622],[6.74872,125.35822],[6.75072,125.35822],[6.75072,125.35622]]','2025-02-27 19:46:44',NULL,NULL);
/*!40000 ALTER TABLE `barangay` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `person_register`
--

DROP TABLE IF EXISTS `person_register`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `person_register` (
  `id` int NOT NULL AUTO_INCREMENT,
  `resident_id` varchar(255) DEFAULT NULL,
  `posts_id` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `person_register`
--

LOCK TABLES `person_register` WRITE;
/*!40000 ALTER TABLE `person_register` DISABLE KEYS */;
INSERT INTO `person_register` VALUES (2,'2','2','Cancelled by participant','Cancelled','2025-02-28 01:52:38','2025-02-28 02:34:13',NULL),(3,'2','2','Your registration in the event is officially approved by admin','Approved','2025-02-28 02:43:54','2025-02-28 03:42:18',NULL);
/*!40000 ALTER TABLE `person_register` ENABLE KEYS */;
UNLOCK TABLES;

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (2,'csdcsd','cdscsdcds','uploads/posts/67b3609e4b247.jpg','Events','High','2025-02-17 16:15:26',NULL,NULL),(3,'dvvddf','vdvdvd','uploads/posts/67c0efb17cc60.jpg','News','Medium','2025-02-27 23:05:21',NULL,NULL),(4,'tanga','vdvfdfvfvd','uploads/posts/67c0f46443ee7.jpg','Announcements','High','2025-02-27 23:25:24',NULL,NULL);
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
  `sex` varchar(255) DEFAULT NULL,
  `bdate` date DEFAULT NULL,
  `age` int DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `city_municipality` varchar(255) DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `purok_zone` varchar(255) DEFAULT NULL,
  `marital_status` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_type` varchar(45) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `residents`
--

LOCK TABLES `residents` WRITE;
/*!40000 ALTER TABLE `residents` DISABLE KEYS */;
INSERT INTO `residents` VALUES (2,'Pamel','Dakota Olso','Down','Corporis dolorem con','Female','2008-01-19',17,'denzlord13@gmail.com','+1 (996) 223-902','Ut repellendus Modi','Molestiae provident','Eos duis elit adip','vv','Id praesentium quid','Single','67c114435a28d.png','2025-02-27 21:17:54','2025-02-28 04:07:06','user','a','12345678'),(3,'Patricia','Mason Coleman','Mendez','Repellendus Perfere','Male','2007-06-12',17,'nojo@mailinator.com','+1 (282) 246-4825','Voluptate qui sed ex','Dignissimos dolores ','Officiis assumenda d','cscds','Eveniet aliquid qua','Married','','2025-02-27 22:29:44','2025-02-28 02:37:44','admin','s','s'),(4,'Rylee','Mannix Wilkerson','Castillo','Perferendis id minim','Male','2001-04-28',23,'logysag@mailinator.com','+1 (723) 798-9397','Voluptatem in nihil ','Quis labore dolorum ','Labore quis nihil of','vvv','Cupiditate eius sunt','Married','67c0e897ad3a4.jpg','2025-02-27 22:35:03','2025-02-27 22:35:03','admin','lelysysa','$2y$10$u2HrG7tRhXrYYWsSaI1VLeuGai.XXVmOPBqYCs62TTuRnS/5lpgdy');
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

-- Dump completed on 2025-02-28 13:06:07
