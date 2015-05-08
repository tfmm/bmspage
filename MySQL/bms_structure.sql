-- MySQL dump 10.15  Distrib 10.0.17-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: bms
-- ------------------------------------------------------
-- Server version	10.0.17-MariaDB-wsrep

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
-- Table structure for table `alerts`
--

DROP TABLE IF EXISTS `alerts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alerts` (
  `alert_id` int(11) NOT NULL AUTO_INCREMENT,
  `alert_name` varchar(99) NOT NULL,
  `utype_id` int(11) NOT NULL,
  PRIMARY KEY (`alert_id`),
  KEY `fk_alertsunittype` (`utype_id`),
  CONSTRAINT `fk_alertsunittype` FOREIGN KEY (`utype_id`) REFERENCES `unittypes` (`utype_id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `datacenters`
--

DROP TABLE IF EXISTS `datacenters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `datacenters` (
  `dc_id` int(11) NOT NULL AUTO_INCREMENT,
  `dc_name` varchar(20) NOT NULL,
  PRIMARY KEY (`dc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `event_updates`
--

DROP TABLE IF EXISTS `event_updates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_updates` (
  `update_id` int(11) NOT NULL AUTO_INCREMENT,
  `update_desc` text,
  `update_date_time` varchar(99) DEFAULT NULL,
  `update_is_ongoing` tinyint(1) DEFAULT NULL,
  `end_date_time` varchar(99) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `update_user` varchar(99) DEFAULT NULL,
  `update_image` varchar(255) NOT NULL,
  PRIMARY KEY (`update_id`),
  KEY `fk_updatevent` (`event_id`),
  CONSTRAINT `fk_updatevent` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_id` int(11) DEFAULT NULL,
  `date_time_start` varchar(99) DEFAULT NULL,
  `description` text,
  `is_ongoing` tinyint(1) DEFAULT NULL,
  `date_time_end` varchar(99) DEFAULT NULL,
  `user` varchar(99) NOT NULL,
  `alert_id` int(11) DEFAULT NULL,
  `event_image` varchar(255) NOT NULL,
  PRIMARY KEY (`event_id`),
  KEY `user` (`user`),
  KEY `fk_eventunit` (`unit_id`),
  KEY `fk_eventalert` (`alert_id`),
  KEY `date_time_start` (`date_time_start`),
  KEY `date_time_end` (`date_time_end`),
  CONSTRAINT `fk_eventalert` FOREIGN KEY (`alert_id`) REFERENCES `alerts` (`alert_id`),
  CONSTRAINT `fk_eventunit` FOREIGN KEY (`unit_id`) REFERENCES `units` (`unit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `units` (
  `unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(99) NOT NULL,
  `utype_id` int(11) NOT NULL,
  `dc_id` int(11) NOT NULL,
  PRIMARY KEY (`unit_id`),
  UNIQUE KEY `unit_name` (`unit_name`),
  KEY `fk_unitstypes` (`utype_id`),
  KEY `fk_unitsdcs` (`dc_id`),
  CONSTRAINT `fk_unitsdcs` FOREIGN KEY (`dc_id`) REFERENCES `datacenters` (`dc_id`),
  CONSTRAINT `fk_unitstypes` FOREIGN KEY (`utype_id`) REFERENCES `unittypes` (`utype_id`)
) ENGINE=InnoDB AUTO_INCREMENT=188 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `unittypes`
--

DROP TABLE IF EXISTS `unittypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unittypes` (
  `utype_id` int(11) NOT NULL AUTO_INCREMENT,
  `utype_name` varchar(99) NOT NULL,
  PRIMARY KEY (`utype_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-05-07 23:35:03
