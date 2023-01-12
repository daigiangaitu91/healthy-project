/*
SQLyog Professional
MySQL - 8.0.30-0ubuntu0.20.04.2 : Database - healthy-project
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`healthy-project` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `healthy-project`;

/*Table structure for table `healthy_member_body_record` */

DROP TABLE IF EXISTS `healthy_member_body_record`;

CREATE TABLE `healthy_member_body_record` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `date_record` int DEFAULT NULL,
  `target_date` double DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `body_fat` double DEFAULT NULL,
  `status` int NOT NULL DEFAULT '10',
  `created_by` int DEFAULT NULL,
  `created_at` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_member_body_record` (`user_id`),
  CONSTRAINT `fk_member_body_record` FOREIGN KEY (`user_id`) REFERENCES `healthy_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `healthy_member_body_record` */

insert  into `healthy_member_body_record`(`id`,`user_id`,`date_record`,`target_date`,`weight`,`body_fat`,`status`,`created_by`,`created_at`,`updated_by`,`updated_at`) values 
(1,2,1673455996,150,90,86,10,2,1673456346,2,1673458755),
(4,2,1673458577,150,70,86,10,2,1673458585,2,1673458585);

/*Table structure for table `healthy_member_exercise_record` */

DROP TABLE IF EXISTS `healthy_member_exercise_record`;

CREATE TABLE `healthy_member_exercise_record` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `exercise_date` int DEFAULT NULL,
  `description` text COLLATE utf8mb3_unicode_ci,
  `kcal` double DEFAULT NULL,
  `duration` double DEFAULT NULL,
  `status` int NOT NULL DEFAULT '10',
  `created_by` int DEFAULT NULL,
  `created_at` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_member_exercise_record` (`user_id`),
  CONSTRAINT `fk_member_exercise_record` FOREIGN KEY (`user_id`) REFERENCES `healthy_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `healthy_member_exercise_record` */

insert  into `healthy_member_exercise_record`(`id`,`user_id`,`exercise_date`,`description`,`kcal`,`duration`,`status`,`created_by`,`created_at`,`updated_by`,`updated_at`) values 
(1,2,1673459577,'Test exercise 1',70,20,10,2,1673494436,2,1673494436),
(2,2,1673458577,'Test exercise 2',70,20,10,2,1673494453,2,1673494453),
(3,2,1673468577,'Test exercise 3',70,20,10,2,1673494462,2,1673494462),
(4,2,1673468177,'Test exercise 4',70,20,10,2,1673494472,2,1673494472);

/*Table structure for table `healthy_member_meal_history` */

DROP TABLE IF EXISTS `healthy_member_meal_history`;

CREATE TABLE `healthy_member_meal_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `meal_name` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `date_meal` int DEFAULT NULL,
  `category` int DEFAULT NULL,
  `kcal` double DEFAULT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '10',
  `created_by` int DEFAULT NULL,
  `created_at` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_member_meal_history` (`user_id`),
  CONSTRAINT `fk_member_meal_history` FOREIGN KEY (`user_id`) REFERENCES `healthy_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `healthy_member_meal_history` */

insert  into `healthy_member_meal_history`(`id`,`user_id`,`meal_name`,`date_meal`,`category`,`kcal`,`thumbnail`,`status`,`created_by`,`created_at`,`updated_by`,`updated_at`) values 
(1,2,'Test Morning',1673458577,1,70,'',10,2,1673493421,2,1673493421),
(2,2,'Test Lunch',1673459577,2,70,'',10,2,1673493450,2,1673493450),
(3,2,'Test Dinner',1673459577,3,70,'',10,2,1673493459,2,1673493459),
(4,2,'Test Snack',1673459577,4,70,'',10,2,1673493525,2,1673493525),
(5,2,'Test Snack 1',1673459577,4,70,'',10,2,1673493709,2,1673493709);

/*Table structure for table `healthy_migration` */

DROP TABLE IF EXISTS `healthy_migration`;

CREATE TABLE `healthy_migration` (
  `version` varchar(180) COLLATE utf8mb4_general_ci NOT NULL,
  `apply_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `healthy_migration` */

insert  into `healthy_migration`(`version`,`apply_time`) values 
('m000000_000000_base',1673341181),
('m120000_000000_init',1673341183),
('m120000_000010_update_user',1673341183),
('m130000_000000_create_table_user_group',1673341183),
('m130000_100000_create_table_user_permission',1673341183),
('m130000_110000_create_table_user_group_permission',1673341183),
('m130000_120000_create_table_user_user_group',1673341184),
('m130000_130000_create_admin_account',1673341185),
('m130000_130010_create_table_setting',1673448109),
('m130000_200000_create_table_recommended_category',1673341185),
('m130000_200010_create_table_recommended',1673341185),
('m130000_300000_create_table_member_body_record',1673448456),
('m130000_300010_create_table_member_exercise_record',1673494398),
('m130000_300020_create_table_member_meal_history',1673493379);

/*Table structure for table `healthy_recommended` */

DROP TABLE IF EXISTS `healthy_recommended`;

CREATE TABLE `healthy_recommended` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb3_unicode_ci,
  `thumbnail` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `recommended_category_id` int DEFAULT NULL,
  `tags` text COLLATE utf8mb3_unicode_ci,
  `status` int NOT NULL DEFAULT '10',
  `created_by` int NOT NULL,
  `created_at` int NOT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_recommended_category` (`recommended_category_id`),
  CONSTRAINT `fk_recommended_category` FOREIGN KEY (`recommended_category_id`) REFERENCES `healthy_recommended_category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `healthy_recommended` */

insert  into `healthy_recommended`(`id`,`title`,`content`,`thumbnail`,`recommended_category_id`,`tags`,`status`,`created_by`,`created_at`,`updated_by`,`updated_at`) values 
(1,'Meal Fish','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged dem','/contents/recommended/2023/01/group-628-63be85b64d422.png',1,'tag1;tag2',10,1,1673427392,1,1673430463),
(2,'Test Diet','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged',NULL,3,'',10,1,1673430909,1,1673431018),
(3,'Test Beauty','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged',NULL,4,'',10,1,1673430995,1,1673430995),
(4,'Test Healthy','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged',NULL,5,'tag2;tag 3',10,1,1673431043,1,1673431137),
(5,'Meal Fish','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged dem','/contents/recommended/2023/01/group-628-63be85b64d422.png',1,'tag1;tag2',10,1,1673427392,1,1673430463),
(6,'Meal Fish','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged dem','/contents/recommended/2023/01/group-628-63be85b64d422.png',1,'tag1;tag2',10,1,1673427392,1,1673430463),
(7,'Meal Fish','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged dem','/contents/recommended/2023/01/group-628-63be85b64d422.png',1,'tag1;tag2',10,1,1673427392,1,1673430463),
(8,'Test Diet','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged',NULL,3,'',10,1,1673430909,1,1673431018),
(9,'Test Diet','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged',NULL,3,'',10,1,1673430909,1,1673431018),
(10,'Test Diet','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged',NULL,3,'',10,1,1673430909,1,1673431018),
(11,'Test Diet','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged',NULL,3,'',10,1,1673430909,1,1673431018),
(12,'Test Beauty','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged',NULL,4,'',10,1,1673430995,1,1673430995),
(13,'Test Beauty','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged',NULL,4,'',10,1,1673430995,1,1673430995),
(14,'Test Beauty','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged',NULL,4,'',10,1,1673430995,1,1673430995),
(15,'Test Healthy','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged',NULL,5,'tag2;tag 3',10,1,1673431043,1,1673431137);

/*Table structure for table `healthy_recommended_category` */

DROP TABLE IF EXISTS `healthy_recommended_category`;

CREATE TABLE `healthy_recommended_category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb3_unicode_ci,
  `status` int NOT NULL DEFAULT '10',
  `created_by` int NOT NULL,
  `created_at` int NOT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `healthy_recommended_category` */

insert  into `healthy_recommended_category`(`id`,`title`,`description`,`status`,`created_by`,`created_at`,`updated_by`,`updated_at`) values 
(1,'Recommended Column','Recommended Column',10,1,1673425583,1,1673426395),
(3,'Recommended Diet','Recommended Diet',10,1,1673426382,1,1673426382),
(4,'Recommended Beauty','Recommended Beauty',10,1,1673426468,1,1673426468),
(5,'Recommended Healthy','Recommended Healthy',10,1,1673426495,1,1673426495);

/*Table structure for table `healthy_setting` */

DROP TABLE IF EXISTS `healthy_setting`;

CREATE TABLE `healthy_setting` (
  `key` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb3_unicode_ci,
  PRIMARY KEY (`key`),
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `healthy_setting` */

insert  into `healthy_setting`(`key`,`value`) values 
('ADMIN_EMAIL','admin@gmail.com'),
('DOMAIN','https://dev.healthy-project.com'),
('SITE_NAME','Healthy');

/*Table structure for table `healthy_user` */

DROP TABLE IF EXISTS `healthy_user`;

CREATE TABLE `healthy_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `verification_token` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` smallint NOT NULL DEFAULT '10',
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  `first_name` varchar(1000) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `last_name` varchar(1000) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `phone_number` varchar(20) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `type` varchar(20) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `healthy_user` */

insert  into `healthy_user`(`id`,`username`,`auth_key`,`password_hash`,`password_reset_token`,`verification_token`,`email`,`status`,`created_at`,`updated_at`,`first_name`,`last_name`,`phone_number`,`type`) values 
(1,'root','v3VNhfq8dtgvuIqe7pbMvl-nqPX53gUl','$2y$13$IrUzmF2hR9pZv5sNWgULKeLRvxilAqLdLRrBLuphN3OUqhsgjf0Iu',NULL,NULL,'root@example.com',10,1673341185,1673341185,'admin','admin',NULL,'staff'),
(2,'nguyennam','q6VLd0J13xIzDIhdyYxzWziDZEbNLk-1','$2y$13$8TDCd5AyUjPZXyWcz5jX0.I9dhfBCUkSgc9zyENjKj7CrwuENYw4q',NULL,NULL,'nguyennam@yopmail.com',10,1673423851,1673455201,'Nguyen','Nam','99','member');

/*Table structure for table `healthy_user_group` */

DROP TABLE IF EXISTS `healthy_user_group`;

CREATE TABLE `healthy_user_group` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '10',
  `is_primary` tinyint NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb3_unicode_ci,
  `created_by` int NOT NULL,
  `created_at` int NOT NULL,
  `updated_by` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `healthy_user_group` */

insert  into `healthy_user_group`(`id`,`name`,`status`,`is_primary`,`description`,`created_by`,`created_at`,`updated_by`,`updated_at`) values 
(1,'Administrator',10,1,NULL,1,1673341185,NULL,NULL);

/*Table structure for table `healthy_user_group_permission` */

DROP TABLE IF EXISTS `healthy_user_group_permission`;

CREATE TABLE `healthy_user_group_permission` (
  `user_group_id` int NOT NULL,
  `user_permission_id` int NOT NULL,
  KEY `fk_group_permission` (`user_permission_id`),
  KEY `fk_user_group` (`user_group_id`),
  CONSTRAINT `fk_group_permission` FOREIGN KEY (`user_permission_id`) REFERENCES `healthy_user_permission` (`id`),
  CONSTRAINT `fk_user_group` FOREIGN KEY (`user_group_id`) REFERENCES `healthy_user_group` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `healthy_user_group_permission` */

/*Table structure for table `healthy_user_permission` */

DROP TABLE IF EXISTS `healthy_user_permission`;

CREATE TABLE `healthy_user_permission` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` int NOT NULL,
  `updated_at` int DEFAULT NULL,
  `synced` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `healthy_user_permission` */

insert  into `healthy_user_permission`(`id`,`name`,`description`,`created_at`,`updated_at`,`synced`) values 
(1,'user','System Users',1673447172,NULL,0),
(2,'user upsert','Create/Update Users',1673447172,NULL,0),
(3,'user delete','Delete Users',1673447172,NULL,0),
(4,'setting','Setting',1673447172,NULL,0),
(5,'setting email','Email Setting',1673447172,NULL,0),
(6,'setting general','General Setting',1673447172,NULL,0),
(7,'recommended','Recommended',1673447172,NULL,0),
(8,'recommended upsert','Create/Update Recommended',1673447172,NULL,0),
(9,'recommended delete','Delete Recommended',1673447172,NULL,0),
(10,'recommended-category','Recommended Category',1673447172,NULL,0),
(11,'recommended-category upsert','Create/Update Recommended Category',1673447172,NULL,0),
(12,'recommended-category delete','Delete Recommended Category',1673447172,NULL,0);

/*Table structure for table `healthy_user_user_group` */

DROP TABLE IF EXISTS `healthy_user_user_group`;

CREATE TABLE `healthy_user_user_group` (
  `user_id` int NOT NULL,
  `user_group_id` int NOT NULL,
  PRIMARY KEY (`user_id`,`user_group_id`),
  KEY `fk_user_map_group_id` (`user_group_id`),
  CONSTRAINT `fk_user_map_group_id` FOREIGN KEY (`user_group_id`) REFERENCES `healthy_user_group` (`id`),
  CONSTRAINT `fk_user_map_user_id` FOREIGN KEY (`user_id`) REFERENCES `healthy_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

/*Data for the table `healthy_user_user_group` */

insert  into `healthy_user_user_group`(`user_id`,`user_group_id`) values 
(1,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
