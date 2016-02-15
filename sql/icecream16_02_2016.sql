/*
SQLyog Ultimate v11.33 (64 bit)
MySQL - 5.6.14 : Database - icecream
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

/*Table structure for table `accounts` */

DROP TABLE IF EXISTS `accounts`;

CREATE TABLE `accounts` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `coa_code` varchar(10) DEFAULT NULL,
  `debit_amount` int(11) DEFAULT '0',
  `credit_amount` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `accounts` */

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `categories` */

insert  into `categories`(`id`,`category_name`,`date_created`) values (1,'Capital & Reserve','2016-02-13 12:21:12'),(2,'Current Liabilities','2016-02-13 12:21:12'),(3,'Payable','2016-02-13 12:21:12'),(4,'Salary Payable','2016-02-13 12:21:12');

/*Table structure for table `coa` */

DROP TABLE IF EXISTS `coa`;

CREATE TABLE `coa` (
  `coa_id` int(11) NOT NULL AUTO_INCREMENT,
  `coa_account` varbinary(255) DEFAULT NULL,
  `coa_code` varchar(10) DEFAULT NULL,
  `parent_id` int(11) DEFAULT '0',
  `created_ate` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`coa_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Data for the table `coa` */

insert  into `coa`(`coa_id`,`coa_account`,`coa_code`,`parent_id`,`created_ate`,`updated_at`) values (1,'Capital & Reserve','100000',0,NULL,'2016-02-14 22:12:59'),(2,'Current Liabilities','200000',0,NULL,NULL),(3,'Payable','300000',0,NULL,NULL),(4,'Salary Payable','400000',0,NULL,NULL),(5,'Adnan Abbas','110000',5,NULL,'2016-02-14 22:13:35'),(6,'Kashif Hussain','120000',1,NULL,NULL),(7,'Reserve','130000',1,NULL,NULL),(8,'Loan From Adnan','210000',2,NULL,NULL),(9,'Loan From Kashif','220000',2,NULL,NULL),(11,'Current Assets','500000',0,NULL,NULL),(12,'Advances','510000',0,NULL,NULL),(13,'Cash & Bank Balance','600000',0,NULL,NULL),(14,'Bank','610000',13,NULL,NULL),(15,'Cash In Hand','620000',13,NULL,NULL),(16,'Stock in Hand','630000',13,NULL,NULL);

/*Table structure for table `logins` */

DROP TABLE IF EXISTS `logins`;

CREATE TABLE `logins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `logins` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `migrations` */

/*Table structure for table `nerds` */

DROP TABLE IF EXISTS `nerds`;

CREATE TABLE `nerds` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nerd_level` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `nerds` */

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `products` */

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_price` int(11) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `products` */

insert  into `products`(`id`,`product_name`,`product_code`,`product_price`,`is_active`,`remember_token`,`created_at`,`updated_at`) values (3,'Test1','123',150,1,NULL,'2016-02-08 23:54:41','0000-00-00 00:00:00'),(4,'Test2','123',150,1,NULL,'2016-02-08 23:54:41','0000-00-00 00:00:00'),(5,'Test4','123',180,1,NULL,'2016-02-08 23:54:41','0000-00-00 00:00:00'),(6,'Ice cream1','123',150,1,NULL,'2016-02-09 12:31:17','2016-02-09 12:31:17'),(7,'Cappellos','1466',180,1,NULL,'2016-02-09 16:28:50','2016-02-09 16:28:50'),(8,'Strawberry','452',500,0,NULL,'2016-02-09 16:31:48','2016-02-09 16:45:52'),(9,'Gajar','456',150,1,NULL,'2016-02-09 17:04:54','2016-02-09 17:04:54');

/*Table structure for table `sales` */

DROP TABLE IF EXISTS `sales`;

CREATE TABLE `sales` (
  `sale_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `net_amount` int(11) NOT NULL,
  `created_at` date NOT NULL DEFAULT '0000-00-00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sale_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `sales` */

insert  into `sales`(`sale_id`,`net_amount`,`created_at`,`updated_at`,`user_id`,`invoice_id`) values (1,480,'2016-02-11','0000-00-00 00:00:00',6,0),(2,330,'2016-02-11','0000-00-00 00:00:00',5,0),(3,480,'2016-02-11','0000-00-00 00:00:00',6,0),(4,480,'2016-02-11','0000-00-00 00:00:00',5,0),(5,480,'2016-02-11','0000-00-00 00:00:00',5,0),(6,960,'2016-02-12','0000-00-00 00:00:00',5,1),(7,1260,'2016-02-12','0000-00-00 00:00:00',6,2),(8,510,'2016-02-12','0000-00-00 00:00:00',6,3),(9,180,'2016-02-12','0000-00-00 00:00:00',6,4),(10,720,'2016-02-12','0000-00-00 00:00:00',6,5),(11,450,'2016-02-12','0000-00-00 00:00:00',6,6),(12,330,'2016-02-13','0000-00-00 00:00:00',5,1),(13,480,'2016-02-13','0000-00-00 00:00:00',5,2),(14,480,'2016-02-14','0000-00-00 00:00:00',5,1),(15,780,'2016-02-13','0000-00-00 00:00:00',6,3),(16,180,'2016-02-13','0000-00-00 00:00:00',6,4),(17,1260,'2016-02-13','0000-00-00 00:00:00',6,5),(18,1260,'2016-02-13','0000-00-00 00:00:00',6,6);

/*Table structure for table `sales_details` */

DROP TABLE IF EXISTS `sales_details`;

CREATE TABLE `sales_details` (
  `sales_details_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_price` int(11) NOT NULL,
  `product_qty` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `sale_id` int(11) NOT NULL,
  PRIMARY KEY (`sales_details_id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `sales_details` */

insert  into `sales_details`(`sales_details_id`,`product_price`,`product_qty`,`product_id`,`created_at`,`updated_at`,`sale_id`) values (1,180,1,5,'2016-02-11 18:39:18','0000-00-00 00:00:00',1),(2,150,1,4,'2016-02-11 18:39:18','0000-00-00 00:00:00',1),(3,150,1,3,'2016-02-11 18:39:18','0000-00-00 00:00:00',1),(4,150,1,4,'2016-02-11 18:39:45','0000-00-00 00:00:00',2),(5,180,1,5,'2016-02-11 18:39:45','0000-00-00 00:00:00',2),(6,180,1,5,'2016-02-11 18:46:38','0000-00-00 00:00:00',3),(7,150,1,4,'2016-02-11 18:46:38','0000-00-00 00:00:00',3),(8,150,1,3,'2016-02-11 18:46:38','0000-00-00 00:00:00',3),(9,150,1,3,'2016-02-11 19:04:29','0000-00-00 00:00:00',4),(10,150,1,4,'2016-02-11 19:04:29','0000-00-00 00:00:00',4),(11,180,1,5,'2016-02-11 19:04:29','0000-00-00 00:00:00',4),(12,150,1,6,'2016-02-11 19:06:33','0000-00-00 00:00:00',5),(13,150,1,3,'2016-02-11 19:06:33','0000-00-00 00:00:00',5),(14,180,1,5,'2016-02-11 19:06:33','0000-00-00 00:00:00',5),(15,300,2,6,'2016-02-12 00:13:40','0000-00-00 00:00:00',6),(16,300,2,9,'2016-02-12 00:13:40','0000-00-00 00:00:00',6),(17,360,2,7,'2016-02-12 00:13:40','0000-00-00 00:00:00',6),(18,360,2,5,'2016-02-12 00:14:10','0000-00-00 00:00:00',7),(19,300,2,4,'2016-02-12 00:14:10','0000-00-00 00:00:00',7),(20,300,2,3,'2016-02-12 00:14:10','0000-00-00 00:00:00',7),(21,300,2,6,'2016-02-12 00:14:10','0000-00-00 00:00:00',7),(22,150,1,4,'2016-02-12 00:58:28','0000-00-00 00:00:00',8),(23,360,2,5,'2016-02-12 00:58:28','0000-00-00 00:00:00',8),(24,180,1,5,'2016-02-12 00:59:04','0000-00-00 00:00:00',9),(25,720,4,5,'2016-02-12 01:16:58','0000-00-00 00:00:00',10),(26,300,2,4,'2016-02-12 01:19:09','0000-00-00 00:00:00',11),(27,150,1,6,'2016-02-12 01:19:09','0000-00-00 00:00:00',11),(28,150,1,4,'2016-02-13 01:21:10','0000-00-00 00:00:00',12),(29,180,1,5,'2016-02-13 01:21:10','0000-00-00 00:00:00',12),(30,180,1,5,'2016-02-13 01:21:31','0000-00-00 00:00:00',13),(31,150,1,4,'2016-02-13 01:21:31','0000-00-00 00:00:00',13),(32,150,1,3,'2016-02-13 01:21:31','0000-00-00 00:00:00',13),(33,150,1,3,'2016-02-14 01:22:17','0000-00-00 00:00:00',14),(34,150,1,4,'2016-02-14 01:22:17','0000-00-00 00:00:00',14),(35,180,1,5,'2016-02-14 01:22:17','0000-00-00 00:00:00',14),(36,150,1,9,'2016-02-13 00:05:22','0000-00-00 00:00:00',15),(37,150,1,6,'2016-02-13 00:05:22','0000-00-00 00:00:00',15),(38,150,1,3,'2016-02-13 00:05:22','0000-00-00 00:00:00',15),(39,150,1,4,'2016-02-13 00:05:22','0000-00-00 00:00:00',15),(40,180,1,5,'2016-02-13 00:05:22','0000-00-00 00:00:00',15),(41,180,1,5,'2016-02-13 00:12:41','0000-00-00 00:00:00',16),(42,300,2,4,'2016-02-13 20:42:37','0000-00-00 00:00:00',17),(43,300,2,6,'2016-02-13 20:42:37','0000-00-00 00:00:00',17),(44,300,2,9,'2016-02-13 20:42:37','0000-00-00 00:00:00',17),(45,360,2,7,'2016-02-13 20:42:37','0000-00-00 00:00:00',17),(46,300,2,4,'2016-02-13 20:42:37','0000-00-00 00:00:00',18),(47,300,2,6,'2016-02-13 20:42:37','0000-00-00 00:00:00',18),(48,300,2,9,'2016-02-13 20:42:37','0000-00-00 00:00:00',18),(49,360,2,7,'2016-02-13 20:42:37','0000-00-00 00:00:00',18);

/*Table structure for table `shops` */

DROP TABLE IF EXISTS `shops`;

CREATE TABLE `shops` (
  `shop_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shop_code` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `shop_address` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_active` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`shop_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `shops` */

insert  into `shops`(`shop_id`,`shop_name`,`shop_code`,`shop_address`,`created_at`,`updated_at`,`is_active`) values (1,'Test','444','456','2016-02-09 12:31:04','2016-02-09 12:31:04',1);

/*Table structure for table `sub_categories` */

DROP TABLE IF EXISTS `sub_categories`;

CREATE TABLE `sub_categories` (
  `sub_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `sub_category_name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`sub_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `sub_categories` */

insert  into `sub_categories`(`sub_category_id`,`sub_category_name`,`category_id`,`date_created`) values (1,'Adnan Abbas',1,'2016-02-13 12:23:56'),(2,'Kashif Hussain',1,'2016-02-13 12:23:56'),(3,'Reserve',1,'2016-02-13 12:23:56'),(4,'Loan From Adnan',2,'2016-02-13 12:23:56'),(5,'Loan From Kashif',2,'2016-02-13 12:23:56'),(6,'Imran Corporatin',2,'2016-02-13 12:23:56');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `login_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` int(11) NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `shop_id` int(11) NOT NULL,
  `user_type` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_login_name_unique` (`login_name`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`first_name`,`last_name`,`login_name`,`gender`,`city`,`address`,`email`,`password`,`remember_token`,`created_at`,`updated_at`,`shop_id`,`user_type`) values (1,'sohail','sarwar','20thfloorcom',1,'lahore','pak gate','admin@admin.com','admin','kHNmk2fHC5eyic9mrXpAenNggQKJkTNJkM52RLv0ke60FdoXr1BMQLAYPsPY','2016-01-28 23:32:10','2016-01-28 23:52:55',0,0),(2,'ahmad','nawaz','Admin',1,'multan','timber market','khawar26@gmail.com','$2y$10$Z1qUgXCwG4O645uxZ9yd6.aO2ObrcEzWrzL9QUnmfzvqKxD9LJl3G','d3JGP22GaDHk3rEOF1nGY8D8vHXClIP4JKvcFzDM1b04Mf5PJU38bjGlTJK4','2016-01-28 23:42:53','2016-02-08 13:40:31',0,0),(3,'shan','sarwar','20thfloorcom12',1,'karachi','khoni burj','admin@3rdharmonics.com','$2y$10$a1urC6YvF319la9VjV3BJOqI2UQzyULp5d5yHFisOivrx8dtq/wOO',NULL,'2016-01-29 00:27:46','2016-01-29 00:27:46',1,0),(5,'Jawad','Hassan','jawad',1,'Multan','Multan','jawad@gmail.com','$2y$10$AE7.a2rlXgf4vT6.uoGv2.xKox2IlTPxvsJzh6kx2w47csrD2DQS6','jcVmR02sFUQ23yeIZ5mM1vTB3lZm69TWb0IzqSbHrYJus0kP9TCcrBgn4YNc','2016-02-11 18:29:37','2016-02-13 00:05:03',1,2),(6,'Test','Jee','test',1,'Multan','Multan','test@gmail.com','$2y$10$ob1tGpU4PwK7OMCOSofAv.oQSekpzRHf4jB.NA1BkLwxOW1kt6r.S','WAeMB9YTnOQPgWC895ilEk88ULTxWyWzy6rjWeuLiknHA4mIwoxHbZrQbIn4','2016-02-11 18:38:50','2016-02-13 22:52:16',1,1);

/*Table structure for table `voucherdetail` */

DROP TABLE IF EXISTS `voucherdetail`;

CREATE TABLE `voucherdetail` (
  `vd_id` int(11) NOT NULL AUTO_INCREMENT,
  `vd_vm_id` int(11) DEFAULT NULL,
  `vd_coa_code` int(11) DEFAULT NULL,
  `vd_desc` text,
  `vd_debit` decimal(19,4) DEFAULT NULL,
  `vd_credit` decimal(19,4) DEFAULT NULL,
  PRIMARY KEY (`vd_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `voucherdetail` */

/*Table structure for table `vouchermaster` */

DROP TABLE IF EXISTS `vouchermaster`;

CREATE TABLE `vouchermaster` (
  `vm_id` int(11) NOT NULL AUTO_INCREMENT,
  `vm_date` date DEFAULT NULL,
  `vm_type` varchar(5) DEFAULT NULL,
  `vm_desc` text,
  `vm_amount` varchar(50) DEFAULT NULL,
  `vm_ven_id` int(11) DEFAULT NULL,
  `vm_user_id` int(11) DEFAULT NULL,
  `vm_datetime` date DEFAULT NULL,
  PRIMARY KEY (`vm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `vouchermaster` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
