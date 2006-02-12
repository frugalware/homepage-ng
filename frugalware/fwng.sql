-- MySQL dump 10.10
--
-- Host: localhost    Database: fwng
-- ------------------------------------------------------
-- Server version	5.0.18-log

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
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `newsid` bigint(20) NOT NULL auto_increment,
  `cdate` datetime default NULL,
  `user` varchar(20) collate latin2_hungarian_ci default NULL,
  `lang` varchar(6) collate latin2_hungarian_ci default NULL,
  `lastmod` datetime default NULL,
  `news` text collate latin2_hungarian_ci,
  PRIMARY KEY  (`newsid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin2 COLLATE=latin2_hungarian_ci COMMENT='The Frugalware News';

--
-- Dumping data for table `news`
--


/*!40000 ALTER TABLE `news` DISABLE KEYS */;
LOCK TABLES `news` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `news` ENABLE KEYS */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `uname` varchar(20) collate latin2_hungarian_ci NOT NULL,
  `upass` varchar(100) collate latin2_hungarian_ci NOT NULL,
  `umail` varchar(100) collate latin2_hungarian_ci default NULL,
  `rname` varchar(150) collate latin2_hungarian_ci default NULL,
  `regdate` datetime default NULL,
  `lastlogin` datetime default NULL,
  `level` smallint(1) default NULL,
  PRIMARY KEY  (`uname`)
) ENGINE=MyISAM DEFAULT CHARSET=latin2 COLLATE=latin2_hungarian_ci COMMENT='The registered users - no public registration';

--
-- Dumping data for table `users`
--


/*!40000 ALTER TABLE `users` DISABLE KEYS */;
LOCK TABLES `users` WRITE;
INSERT INTO `users` VALUES ('ironiq','1e25741d99767bc812c5e5ca59ef6c92','iron@frugalware.org','Krisztian VASAS','2006-02-07 22:00:35',NULL,10);
UNLOCK TABLES;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

