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
  `total_expense` int(11) NOT NULL DEFAULT '0',
  `closing_balance` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sale_summery_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

/*Data for the table `sale_summery` */

insert  into `sale_summery`(`sale_summery_id`,`current_date`,`ice_20`,`ice_100`,`ice_150`,`ice_180`,`ice_200`,`ice_220`,`wt_40`,`wt_70`,`total_sale`,`discount_amount`,`net_sale`,`total_expense`,`closing_balance`) values (1,'2016-03-01',0,0,0,0,0,0,0,0,9610,0,9610,0,9610),(2,'2016-03-02',0,0,0,0,0,0,0,0,20000,0,20000,53710,-24100),(3,'2016-03-03',4,4,106,19,1,0,0,0,19110,0,19110,54070,-59060),(4,'2016-03-04',2,0,97,24,1,0,0,0,38990,0,38990,33900,-53970),(5,'2016-03-05',19,8,183,52,5,0,0,0,42460,340,42120,34620,-46470),(6,'2016-03-06',21,11,209,52,3,0,0,0,39920,310,39610,4160,-11020),(7,'2016-03-07',12,9,189,53,6,0,0,0,21760,0,21760,59207,-48467),(8,'2016-03-08',3,1,110,25,3,0,0,0,20410,140,20270,34390,-62587),(9,'2016-03-09',24,2,79,39,5,0,0,0,21660,210,21450,20700,-61837),(10,'2016-03-10',11,12,101,24,3,2,0,0,30110,200,29910,32890,-64817),(11,'2016-03-11',4,3,163,26,4,0,0,0,33270,20,33250,24200,-55767),(12,'2016-03-12',13,2,143,61,2,0,0,0,32750,770,31980,37890,-61677),(13,'2016-03-13',4,0,151,52,4,3,0,0,44420,350,44070,27000,-44607),(14,'2016-03-14',7,6,217,60,7,1,0,0,17560,50,17510,37930,-65027),(15,'2016-03-15',15,4,81,31,1,0,0,0,24210,210,24000,24500,-65527),(16,'2016-03-16',9,1,116,28,1,2,0,0,20570,420,20150,11360,-56737),(17,'2016-03-17',11,1,90,34,3,3,0,0,23540,110,23430,17950,-51257),(18,'2016-03-18',12,4,109,32,0,0,0,0,28090,390,27700,26000,-49557),(19,'2016-03-19',13,5,125,52,5,0,0,0,24390,40,24350,14700,-39907),(20,'2016-03-20',9,5,93,40,4,2,0,0,32720,630,32090,14540,-22357),(21,'2016-03-21',13,12,117,74,4,1,0,0,27080,70,27010,71290,-66637),(22,'2016-03-22',14,4,123,39,5,0,0,0,24960,700,24260,26970,-69347),(23,'2016-03-23',6,5,112,48,3,2,0,0,34190,570,33620,20280,-56007),(24,'2016-03-24',17,6,146,54,5,3,0,0,17070,70,17000,11340,-50347),(25,'2016-03-25',3,1,77,26,0,0,0,0,26500,690,25810,0,-24537),(26,'2016-03-26',16,0,119,35,7,6,0,0,32340,220,32120,51630,-44047),(27,'2016-03-27',19,1,144,49,5,3,0,0,32960,210,32750,31350,-42647),(28,'2016-03-28',16,0,160,50,2,2,0,0,18240,240,18000,0,-24647),(29,'2016-03-29',8,0,74,26,3,5,0,0,24210,350,23860,0,-787),(30,'2016-03-30',7,4,109,29,4,9,0,0,13440,250,13190,0,12403),(31,'2016-03-31',8,2,66,20,2,3,0,0,22550,110,22440,0,34843),(32,'2016-04-01',11,2,91,37,0,1,0,0,28980,80,28900,0,63743),(33,'2016-04-02',13,1,125,47,5,8,0,0,37010,140,36870,0,100613),(34,'2016-04-03',25,5,134,54,11,13,0,0,33110,110,33000,0,133613),(35,'2016-04-04',27,5,156,39,2,7,0,0,16470,40,16430,0,150043),(36,'2016-04-05',8,0,79,19,1,4,0,0,15720,80,15640,0,165683),(37,'2016-04-06',6,2,66,22,3,6,0,0,19330,70,19260,0,184943),(38,'2016-04-07',13,2,78,33,7,2,0,0,26110,120,25990,0,210933);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;