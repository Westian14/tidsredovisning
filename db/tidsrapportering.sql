/*
SQLyog Community
MySQL - 8.0.31 : Database - tidrapportering
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `aktiviteter` */

DROP TABLE IF EXISTS `aktiviteter`;

CREATE TABLE `aktiviteter` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Namn` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_swedish_ci NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `UIX_Namn` (`Namn`)
) ENGINE=InnoDB AUTO_INCREMENT=2506 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_swedish_ci;

/*Data for the table `aktiviteter` */

insert  into `aktiviteter`(`ID`,`Namn`) values 
(3,'JS KOD :wwwww'),
(5,'Sleeping'),
(1,'Spelat Minecraft'),
(987,'YIPPIEEEE');

/*Table structure for table `uppgifter` */

DROP TABLE IF EXISTS `uppgifter`;

CREATE TABLE `uppgifter` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Datum` date NOT NULL,
  `Tid` time NOT NULL,
  `AktivitetID` int NOT NULL,
  `Beskrivning` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `uppgifter` (`AktivitetID`),
  CONSTRAINT `uppgifter` FOREIGN KEY (`AktivitetID`) REFERENCES `aktiviteter` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=635 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_swedish_ci;

/*Data for the table `uppgifter` */

insert  into `uppgifter`(`ID`,`Datum`,`Tid`,`AktivitetID`,`Beskrivning`) values 
(4,'2023-09-13','02:10:00',5,'undefined'),
(531,'2024-01-01','06:27:00',1,'undefined'),
(536,'2024-01-01','01:27:00',3,'dwadwadwdwdwwww'),
(537,'2024-01-01','05:40:00',3,''),
(538,'2024-01-01','05:42:00',3,'');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
