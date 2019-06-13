/*
SQLyog Ultimate v11.27 (32 bit)
MySQL - 5.7.17-log : Database - wage_sys
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`wage_sys` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `wage_sys`;

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (1,'2017_11_21_080226_create_nodes_table',1),(2,'2017_11_23_212826_create_users_table',2),(3,'2017_12_04_144453_update_column_updater_in_users_table',3),(6,'2017_12_08_145314_create_wages_table',4),(9,'2017_12_09_114459_drop_columns_wage_year_month_in_wages_table',5),(10,'2017_12_09_114614_update_columns_in_wages_table',5);

/*Table structure for table `nodes` */

DROP TABLE IF EXISTS `nodes`;

CREATE TABLE `nodes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '权限节点名',
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '权限节点编号,如001,01001',
  `pid` mediumint(9) NOT NULL COMMENT '父级节点id',
  `depth` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '菜单层级,一级菜单1,二级菜单2,页面3',
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '权限节点路径',
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '节点类型(0:menu,1:button,2:api)',
  `sort_factor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '排序因子(越小越靠前)',
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '菜单图标class名称',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '状态(0:正常,1:已删除)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `nodes` */

insert  into `nodes`(`id`,`name`,`code`,`pid`,`depth`,`path`,`type`,`sort_factor`,`icon`,`status`,`created_at`,`updated_at`) values (1,'工资管理','001',0,'1','/wage','0','101','ion-ios-list-outline','0','2017-11-23 20:52:54','2017-11-23 20:52:56'),(2,'工资列表','001001',1,'2','/wage/list','0','1','ion-ios-list-outline','0','2017-11-23 20:54:46','2017-11-23 20:54:48'),(3,'用户管理','002',0,'1','/user','0','201','ion-ios-list-outline','0','2017-11-23 20:56:00','2017-11-23 20:56:02'),(4,'用户列表','002001',3,'2','/user/list','0','1','ion-ios-list-outline','0','2017-11-23 20:57:11','2017-11-23 20:57:13');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '工号',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '姓名',
  `name_quanpin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '姓名全拼',
  `name_jianpin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '姓名简拼',
  `sex` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '性别',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '手机号',
  `salt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '密码',
  `type` tinyint(4) NOT NULL COMMENT '0:普通用户,1:管理员',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '状态(0:正常,1:已删除)',
  `creator` int(11) NOT NULL COMMENT '创建人',
  `updater` int(11) DEFAULT NULL COMMENT '更新人',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`code`,`name`,`name_quanpin`,`name_jianpin`,`sex`,`phone`,`salt`,`password`,`type`,`status`,`creator`,`updater`,`created_at`,`updated_at`) values (1,'admin','周晓飞','zhouxiaofei','zxf','男','15517308190','d3dc','119db782c2f51ebaed2a4cfcb34a4918',1,'0',0,0,'2017-11-26 08:45:02','2017-12-04 14:39:55'),(2,'201514','周旭','zhouxu','zx','男','13999740890','d3dc','119db782c2f51ebaed2a4cfcb34a4918',0,'0',1,1,'2017-12-02 20:13:46','2018-01-01 17:53:21'),(35,'201515','王巍瑾','wangweijin','wwj','男','15836733455','1018','23e666bfe078751035b77e62d45b1b5b',0,'0',1,NULL,'2018-01-01 14:40:42','2018-01-01 17:55:36');

/*Table structure for table `wages` */

DROP TABLE IF EXISTS `wages`;

CREATE TABLE `wages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '工号',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '姓名',
  `wage_year` char(4) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '工资年份',
  `wage_month` char(2) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '工资月份',
  `wage_base` double NOT NULL DEFAULT '0' COMMENT '底薪',
  `wage_allowance` double NOT NULL DEFAULT '0' COMMENT '津贴',
  `wage_bonus` double NOT NULL DEFAULT '0' COMMENT '奖金',
  `wage_should` double NOT NULL DEFAULT '0' COMMENT '应发工资',
  `water_electric` double NOT NULL DEFAULT '0' COMMENT '水电费',
  `heating_costs` double NOT NULL DEFAULT '0' COMMENT '暖气费',
  `house_rent` double NOT NULL DEFAULT '0' COMMENT '房租',
  `income_tax` double NOT NULL DEFAULT '0' COMMENT '个人所得税',
  `wage_garnishment` double NOT NULL DEFAULT '0' COMMENT '扣发工资',
  `wage_actual` double NOT NULL DEFAULT '0' COMMENT '实发工资',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '状态(0:正常,1:已删除)',
  `creator` int(11) NOT NULL COMMENT '创建人',
  `updater` int(11) DEFAULT NULL COMMENT '更新人',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `wages` */

insert  into `wages`(`id`,`code`,`name`,`wage_year`,`wage_month`,`wage_base`,`wage_allowance`,`wage_bonus`,`wage_should`,`water_electric`,`heating_costs`,`house_rent`,`income_tax`,`wage_garnishment`,`wage_actual`,`status`,`creator`,`updater`,`created_at`,`updated_at`) values (3,'201515','王巍瑾','2017','8',2000,500,500,3000,200,300,500,0,1000,2000,'0',1,NULL,'2018-01-01 15:02:42','2018-01-01 15:02:42'),(4,'201515','王巍瑾','2017','9',2500,500,500,3500,200,300,500,0,1000,2500,'0',1,NULL,'2018-01-01 15:02:42','2018-01-01 15:02:42'),(5,'201515','王巍瑾','2017','10',3000,500,1000,4500,200,300,500,0,1000,3000,'0',1,NULL,'2018-01-01 15:02:42','2018-01-01 15:02:42'),(6,'201515','王巍瑾','2017','11',4000,500,500,5000,200,300,500,0,1000,4000,'0',1,NULL,'2018-01-01 15:02:42','2018-01-01 15:02:42'),(7,'201515','王巍瑾','2017','12',4000,500,1000,5500,200,300,500,0,1000,4500,'0',1,NULL,'2018-01-01 15:02:42','2018-01-01 15:02:42'),(8,'201515','王巍瑾','2018','1',4000,1000,1000,6000,200,300,500,0,1000,5000,'0',1,NULL,'2018-01-01 14:42:34','2018-01-01 14:42:34');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
