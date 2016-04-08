/*
SQLyog Ultimate v11.33 (64 bit)
MySQL - 5.6.17 : Database - icecream
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`icecream` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `icecream`;

/*Table structure for table `sale_summery` */

DROP TABLE IF EXISTS `sale_summery`;

CREATE TABLE `sale_summery` (
  `sale_summery_id` int(11) NOT NULL AUTO_INCREMENT,
  `current_date` date DEFAULT NULL,
  `ice_20` int(11) NOT NULL DEFAULT '0',
  `ice_100` int(11) NOT NULL DEFAULT '0',
  `ice_150` int(11) NOT NULL DEFAULT '0',
  `ice_180` int(11) NOT NULL DEFAULT '0',
  `ice_200` int(11) NOT NULL DEFAULT '0',
  `ice_220` int(11) NOT NULL DEFAULT '0',
  `wt_40` int(11) NOT NULL DEFAULT '0',
  `wt_70` int(11) NOT NULL DEFAULT '0',
  `total_sale` int(11) NOT NULL DEFAULT '0',
  `discount_amount` int(11) NOT NULL DEFAULT '0',
  `net_sale` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sale_summery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `sale_summery` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
