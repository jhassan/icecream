/*
SQLyog Ultimate v11.33 (64 bit)
MySQL - 10.1.16-MariaDB : Database - icecream
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

/*Table structure for table `coa` */

DROP TABLE IF EXISTS `coa`;

CREATE TABLE `coa` (
  `coa_id` int(11) NOT NULL AUTO_INCREMENT,
  `coa_code` int(11) NOT NULL,
  `coa_account` varchar(128) NOT NULL,
  `coa_credit` int(11) NOT NULL DEFAULT '0',
  `coa_debit` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `supplier_id` int(11) NOT NULL DEFAULT '0',
  `coa_type` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`coa_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `coa` */

/*Table structure for table `commisions` */

DROP TABLE IF EXISTS `commisions`;

CREATE TABLE `commisions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `total_count` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `commisions` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `migrations` */

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `permissions` */

/*Table structure for table `products` */

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '0',
  `product_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_price` int(11) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `products` */

/*Table structure for table `purchase_items` */

DROP TABLE IF EXISTS `purchase_items`;

CREATE TABLE `purchase_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_qty` int(11) NOT NULL DEFAULT '0',
  `item_amount` int(11) NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL DEFAULT '0',
  `vm_id` int(11) NOT NULL DEFAULT '0',
  `vendor_id` int(11) NOT NULL DEFAULT '0',
  `created_at` date DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `purchase_items` */

/*Table structure for table `sale_summery` */

DROP TABLE IF EXISTS `sale_summery`;

CREATE TABLE `sale_summery` (
  `sale_summery_id` int(11) NOT NULL AUTO_INCREMENT,
  `current_date1` date DEFAULT NULL,
  `ice_20` int(11) NOT NULL DEFAULT '0',
  `ice_100` int(11) NOT NULL DEFAULT '0',
  `ice_150` int(11) NOT NULL DEFAULT '0',
  `ice_170` int(11) NOT NULL DEFAULT '0',
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
  `shop_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sale_summery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `sale_summery` */

/*Table structure for table `sales` */

DROP TABLE IF EXISTS `sales`;

CREATE TABLE `sales` (
  `sale_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `discount_amount` int(11) NOT NULL DEFAULT '0',
  `net_amount` int(11) NOT NULL,
  `created_at` date NOT NULL DEFAULT '0000-00-00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL DEFAULT '0',
  `shop_id` int(11) NOT NULL DEFAULT '0',
  `return_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `sales` */

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `sales_details` */

/*Table structure for table `salesdetail` */

DROP TABLE IF EXISTS `salesdetail`;

CREATE TABLE `salesdetail` (
  `sd_id` int(11) NOT NULL AUTO_INCREMENT,
  `sd_sm_id` int(11) DEFAULT NULL,
  `sd_coa_code` int(11) DEFAULT NULL,
  `sd_desc` text,
  `sd_debit` decimal(19,4) DEFAULT NULL,
  `sd_credit` decimal(19,4) DEFAULT NULL,
  PRIMARY KEY (`sd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `salesdetail` */

/*Table structure for table `salesmaster` */

DROP TABLE IF EXISTS `salesmaster`;

CREATE TABLE `salesmaster` (
  `sm_id` int(11) NOT NULL AUTO_INCREMENT,
  `sm_date` date DEFAULT NULL,
  `sm_type` varchar(5) DEFAULT NULL,
  `sm_desc` text,
  `sm_amount` varchar(50) DEFAULT NULL,
  `shop_id` int(11) NOT NULL DEFAULT '0',
  `sm_ven_id` int(11) DEFAULT NULL,
  `sm_user_id` int(11) DEFAULT NULL,
  `sm_datetime` date DEFAULT NULL,
  PRIMARY KEY (`sm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `salesmaster` */

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `shops` */

/*Table structure for table `tbl_op_balance` */

DROP TABLE IF EXISTS `tbl_op_balance`;

CREATE TABLE `tbl_op_balance` (
  `balance_id` int(11) NOT NULL AUTO_INCREMENT,
  `current_date` date DEFAULT NULL,
  `coa_111001` int(11) NOT NULL DEFAULT '0',
  `coa_111002` int(11) NOT NULL DEFAULT '0',
  `coa_113001` int(11) NOT NULL DEFAULT '0',
  `coa_113002` int(11) NOT NULL DEFAULT '0',
  `coa_121001` int(11) NOT NULL DEFAULT '0',
  `coa_412001` int(11) NOT NULL DEFAULT '0',
  `coa_414001` int(11) NOT NULL DEFAULT '0',
  `coa_414002` int(11) NOT NULL DEFAULT '0',
  `coa_414003` int(11) NOT NULL DEFAULT '0',
  `coa_415001` int(11) NOT NULL DEFAULT '0',
  `coa_511001` int(11) NOT NULL DEFAULT '0',
  `coa_511002` int(11) NOT NULL DEFAULT '0',
  `coa_511003` int(11) NOT NULL DEFAULT '0',
  `coa_512001` int(11) NOT NULL DEFAULT '0',
  `coa_512002` int(11) NOT NULL DEFAULT '0',
  `coa_512003` int(11) NOT NULL DEFAULT '0',
  `coa_512004` int(11) NOT NULL DEFAULT '0',
  `coa_111003` int(11) NOT NULL DEFAULT '0',
  `coa_411001` int(11) NOT NULL DEFAULT '0',
  `coa_513001` int(11) NOT NULL DEFAULT '0',
  `coa_513002` int(11) NOT NULL DEFAULT '0',
  `coa_513003` int(11) NOT NULL DEFAULT '0',
  `coa_513004` int(11) NOT NULL DEFAULT '0',
  `coa_513005` int(11) NOT NULL DEFAULT '0',
  `coa_513006` int(11) NOT NULL DEFAULT '0',
  `coa_513007` int(11) NOT NULL DEFAULT '0',
  `coa_513008` int(11) NOT NULL DEFAULT '0',
  `coa_513009` int(11) NOT NULL DEFAULT '0',
  `coa_513010` int(11) NOT NULL DEFAULT '0',
  `coa_513011` int(11) NOT NULL DEFAULT '0',
  `coa_513012` int(11) NOT NULL DEFAULT '0',
  `coa_514001` int(11) NOT NULL DEFAULT '0',
  `coa_514002` int(11) NOT NULL DEFAULT '0',
  `coa_513013` int(11) NOT NULL DEFAULT '0',
  `coa_513014` int(11) NOT NULL DEFAULT '0',
  `coa_513015` int(11) NOT NULL DEFAULT '0',
  `coa_121002` int(11) NOT NULL DEFAULT '0',
  `coa_415002` int(11) NOT NULL DEFAULT '0',
  `coa_121003` int(11) NOT NULL DEFAULT '0',
  `coa_121004` int(11) NOT NULL DEFAULT '0',
  `coa_415003` int(11) NOT NULL DEFAULT '0',
  `coa_415004` int(11) NOT NULL DEFAULT '0',
  `coa_415005` int(11) NOT NULL DEFAULT '0',
  `coa_513016` int(11) NOT NULL DEFAULT '0',
  `coa_513017` int(11) NOT NULL DEFAULT '0',
  `coa_513018` int(11) NOT NULL DEFAULT '0',
  `coa_411002` int(11) NOT NULL DEFAULT '0',
  `coa_515001` int(11) NOT NULL DEFAULT '0',
  `coa_515002` int(11) NOT NULL DEFAULT '0',
  `coa_515003` int(11) NOT NULL DEFAULT '0',
  KEY `balance_id` (`balance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_op_balance` */

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
  `user_permission` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_login_name_unique` (`login_name`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

/*Table structure for table `vendors` */

DROP TABLE IF EXISTS `vendors`;

CREATE TABLE `vendors` (
  `vendor_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vendor_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vendor_phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `vendor_address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`vendor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `vendors` */

/*Table structure for table `voucherdetail` */

DROP TABLE IF EXISTS `voucherdetail`;

CREATE TABLE `voucherdetail` (
  `vd_id` int(11) NOT NULL AUTO_INCREMENT,
  `vd_vm_id` int(11) DEFAULT NULL,
  `vd_coa_code` int(11) DEFAULT NULL,
  `vd_desc` text,
  `vd_debit` int(11) DEFAULT '0',
  `vd_credit` int(11) DEFAULT '0',
  PRIMARY KEY (`vd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `voucherdetail` */

/*Table structure for table `vouchermaster` */

DROP TABLE IF EXISTS `vouchermaster`;

CREATE TABLE `vouchermaster` (
  `vm_id` int(11) NOT NULL AUTO_INCREMENT,
  `vm_date` date DEFAULT NULL,
  `vm_type` varchar(5) DEFAULT NULL,
  `vm_desc` text,
  `vm_amount` varchar(50) DEFAULT NULL,
  `shop_id` int(11) NOT NULL DEFAULT '0',
  `vm_memo_no` varchar(255) DEFAULT NULL,
  `vm_ven_id` int(11) DEFAULT NULL,
  `vm_user_id` int(11) DEFAULT NULL,
  `vm_datetime` date DEFAULT NULL,
  PRIMARY KEY (`vm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `vouchermaster` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
