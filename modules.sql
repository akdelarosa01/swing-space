-- MySQL dump 10.13  Distrib 5.7.22, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: swingspace
-- ------------------------------------------------------
-- Server version	5.7.22-0ubuntu18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module_code` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module_name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module_category` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_user` int(11) NOT NULL,
  `update_user` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modules`
--

LOCK TABLES `modules` WRITE;
/*!40000 ALTER TABLE `modules` DISABLE KEYS */;
INSERT INTO `modules` VALUES (1,'POS_CTRL','POS Control','POS','zmdi zmdi-menu zmdi-hc-fw',1,1,'2018-10-23 18:34:31','2018-10-23 18:34:31'),(2,'CUS_LST','Customer List','Customers','zmdi zmdi-accounts zmdi-hc-fw',1,1,'2018-10-23 18:35:13','2018-10-23 18:35:13'),(3,'CUS_MEM','Membership','Customers','zmdi zmdi-accounts zmdi-hc-fw',1,1,'2018-10-23 18:35:47','2018-10-23 18:35:47'),(4,'INV_LST','Inventory List','Inventory','zmdi zmdi-label zmdi-hc-fw',1,1,'2018-10-23 18:36:35','2018-10-23 18:36:35'),(5,'SUM_LST','Summary List','Inventory','zmdi zmdi-label zmdi-hc-fw',1,1,'2018-10-23 18:37:21','2018-10-23 18:37:21'),(6,'RCV_ITM','Receive Item','Inventory','zmdi zmdi-label zmdi-hc-fw',1,1,'2018-10-23 18:52:20','2018-10-23 18:52:20'),(7,'UPD_INV','Update Inventory','Inventory','zmdi zmdi-label zmdi-hc-fw',1,1,'2018-10-23 18:52:58','2018-10-23 18:52:58'),(8,'EMP_LST','Employee List','Employee','zmdi zmdi-accounts-list',1,1,'2018-10-23 23:49:20','2018-10-23 23:49:20'),(9,'EMP_REG','Employee Registration','Employee','zmdi zmdi-accounts-list',1,1,'2018-10-23 23:50:02','2018-10-23 23:50:02'),(10,'PRD_LST','Product List','Product','zmdi zmdi-shopping-basket',1,1,'2018-10-23 23:50:35','2018-10-23 23:50:35'),(11,'PRD_REG','Product Registration','Product','zmdi zmdi-shopping-basket',1,1,'2018-10-23 23:50:58','2018-10-23 23:50:58'),(12,'GEN_SET','General Settings','Settings','zmdi zmdi-settings zmdi-hc-fw',1,1,'2018-10-23 23:51:41','2018-10-23 23:51:41'),(13,'DRP_SET','Dropdown Settings','Settings','zmdi zmdi-settings zmdi-hc-fw',1,1,'2018-10-23 23:51:49','2018-10-23 23:51:49'),(14,'SAL_RPT','Sales Report','Reports','zmdi zmdi-file zmdi-hc-fw',1,1,'2018-10-23 23:53:27','2018-10-23 23:53:27');
/*!40000 ALTER TABLE `modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'swingspace'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-10-24 17:56:05
