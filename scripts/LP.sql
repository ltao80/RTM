-- MySQL dump 10.13  Distrib 5.6.24, for debian-linux-gnu (x86_64)
--
-- Host: master    Database: LP
-- ------------------------------------------------------
-- Server version	5.5.41-0ubuntu0.14.04.1

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
-- Current Database: `LP`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `LP` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `LP`;

--
-- Table structure for table `lp_customer_delivery_info`
--

DROP TABLE IF EXISTS `lp_customer_delivery_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lp_customer_delivery_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL COMMENT '客户编号，每个客户可以有多个收货信息',
  `receiver_name` varchar(45) NOT NULL COMMENT '收货人姓名',
  `receiver_phone` varchar(45) NOT NULL COMMENT '收货人电话',
  `receiver_province` varchar(45) NOT NULL COMMENT '收货人 省份',
  `receiver_city` varchar(45) NOT NULL COMMENT '收货人 城市',
  `receiver_region` varchar(45) NOT NULL COMMENT '收货人 区域',
  `receiver_address` varchar(250) NOT NULL COMMENT '收货人 地址信息',
  `is_default` tinyint(1) NOT NULL COMMENT '是否为默认收货信息',
  PRIMARY KEY (`id`),
  KEY `fk_rtm_customer_delivery_info_1_idx` (`customer_id`),
  CONSTRAINT `fk_rtm_customer_delivery_info_1` FOREIGN KEY (`customer_id`) REFERENCES `lp_customer_info` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lp_customer_delivery_info`
--

LOCK TABLES `lp_customer_delivery_info` WRITE;
/*!40000 ALTER TABLE `lp_customer_delivery_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `lp_customer_delivery_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lp_customer_info`
--

DROP TABLE IF EXISTS `lp_customer_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lp_customer_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `province` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `region` varchar(45) DEFAULT NULL,
  `birthday` datetime NOT NULL,
  `total_score` decimal(10,0) DEFAULT '0',
  `wechat_id` varchar(45) NOT NULL COMMENT '微信ID，用户使用微信登录成功后更新该字段进行绑定,该字段非空，并且唯一',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wechat_id_UNIQUE` (`wechat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lp_customer_info`
--

LOCK TABLES `lp_customer_info` WRITE;
/*!40000 ALTER TABLE `lp_customer_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `lp_customer_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lp_customer_score_list`
--

DROP TABLE IF EXISTS `lp_customer_score_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lp_customer_score_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `order_code` varchar(20) NOT NULL,
  `order_type` tinyint(1) NOT NULL COMMENT '1 为消费积分(online_score)，2 为产生积分(offline_score)',
  `total_score` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `order_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `index1` (`order_code`,`order_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lp_customer_score_list`
--

LOCK TABLES `lp_customer_score_list` WRITE;
/*!40000 ALTER TABLE `lp_customer_score_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `lp_customer_score_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lp_delivery_company`
--

DROP TABLE IF EXISTS `lp_delivery_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lp_delivery_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(45) NOT NULL COMMENT '物流公司名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lp_delivery_company`
--

LOCK TABLES `lp_delivery_company` WRITE;
/*!40000 ALTER TABLE `lp_delivery_company` DISABLE KEYS */;
/*!40000 ALTER TABLE `lp_delivery_company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lp_global_specification`
--

DROP TABLE IF EXISTS `lp_global_specification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lp_global_specification` (
  `spec_id` varchar(4) NOT NULL,
  `spec_name` varchar(45) NOT NULL,
  PRIMARY KEY (`spec_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lp_global_specification`
--

LOCK TABLES `lp_global_specification` WRITE;
/*!40000 ALTER TABLE `lp_global_specification` DISABLE KEYS */;
/*!40000 ALTER TABLE `lp_global_specification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lp_global_store`
--

DROP TABLE IF EXISTS `lp_global_store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lp_global_store` (
  `store_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(300) NOT NULL COMMENT '店面名称',
  `province` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `region` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`store_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lp_global_store`
--

LOCK TABLES `lp_global_store` WRITE;
/*!40000 ALTER TABLE `lp_global_store` DISABLE KEYS */;
INSERT INTO `lp_global_store` VALUES (1,'默认门店','默认','默认','默认');
/*!40000 ALTER TABLE `lp_global_store` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lp_order_offline`
--

DROP TABLE IF EXISTS `lp_order_offline`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lp_order_offline` (
  `order_code` varchar(20) NOT NULL,
  `receipt_id` varchar(45) DEFAULT NULL COMMENT '小票编号，离线订单编号,该编号需要和门店ID组合进行唯一处理',
  `store_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `promotion_id` int(11) NOT NULL,
  `receipt_date` datetime DEFAULT NULL COMMENT '离线订单时间',
  `is_scan_qrcode` int(11) DEFAULT NULL COMMENT '是否生成二维码',
  `scan_datetime` datetime DEFAULT NULL COMMENT '商品购买的门店',
  `is_generate_qrcode` tinyint(1) DEFAULT NULL,
  `generate_datetime` datetime DEFAULT NULL,
  `order_datetime` datetime NOT NULL,
  `total_score` int(11) NOT NULL,
  `scene_id` varchar(32) DEFAULT NULL COMMENT '微信扫描二维码ID',
  PRIMARY KEY (`order_code`),
  KEY `fk_rtm_order_offline_1_idx` (`customer_id`),
  KEY `fk_rtm_order_offline_2_idx` (`store_id`),
  KEY `fk_rtm_order_offline_3_idx` (`promotion_id`),
  CONSTRAINT `fk_rtm_order_offline_promotion` FOREIGN KEY (`promotion_id`) REFERENCES `lp_promotion_info` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_rtm_order_offline_store` FOREIGN KEY (`store_id`) REFERENCES `lp_global_store` (`store_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lp_order_offline`
--

LOCK TABLES `lp_order_offline` WRITE;
/*!40000 ALTER TABLE `lp_order_offline` DISABLE KEYS */;
/*!40000 ALTER TABLE `lp_order_offline` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lp_order_offline_detail`
--

DROP TABLE IF EXISTS `lp_order_offline_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lp_order_offline_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_code` varchar(20) NOT NULL,
  `product_id` int(11) NOT NULL,
  `spec_id` varchar(4) NOT NULL,
  `product_num` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_rtm_order_offline_detail_1_idx` (`order_code`),
  KEY `fk_rtm_order_offline_detail_2_idx` (`product_id`),
  KEY `fk_rtm_order_offline_detail_3_idx` (`spec_id`),
  CONSTRAINT `fk_rtm_order_offline_detail_1` FOREIGN KEY (`order_code`) REFERENCES `lp_order_offline` (`order_code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_rtm_order_offline_detail_2` FOREIGN KEY (`product_id`) REFERENCES `lp_product_info` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_rtm_order_offline_detail_3` FOREIGN KEY (`spec_id`) REFERENCES `lp_global_specification` (`spec_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lp_order_offline_detail`
--

LOCK TABLES `lp_order_offline_detail` WRITE;
/*!40000 ALTER TABLE `lp_order_offline_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `lp_order_offline_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lp_order_online`
--

DROP TABLE IF EXISTS `lp_order_online`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lp_order_online` (
  `order_code` varchar(20) NOT NULL COMMENT '订单编号，必须唯一，目前使用毫秒+随机数（0~999）,生成20位编号： 20121010110555001999 在插入订单表前需要判断，如果订单编号存在，重新生成\n一毫秒内999并发的可能性很小，重复的几率应该很低',
  `customer_id` int(11) NOT NULL,
  `delivery_id` int(11) DEFAULT NULL COMMENT '收货信息ID',
  `delivery_company_id` int(11) DEFAULT NULL COMMENT '物流公司ID',
  `delivery_order_code` varchar(45) DEFAULT NULL COMMENT '运单编号，第三方物流编号，需要调用第三方api得到物流信息',
  `order_datetime` datetime NOT NULL COMMENT '订单生成时间',
  `total_score` int(11) DEFAULT '0' COMMENT '订单形成的总积分，商品单个积分×商品数量',
  `message` text,
  `status` tinyint(1) DEFAULT NULL COMMENT '订单状态，比如处理中，已发货 等等',
  PRIMARY KEY (`order_code`),
  UNIQUE KEY `order_code_UNIQUE` (`order_code`),
  KEY `fk_rtm_order_online_1_idx` (`customer_id`),
  KEY `fk_rtm_order_online_2_idx` (`delivery_id`),
  CONSTRAINT `fk_rtm_order_online_customer` FOREIGN KEY (`customer_id`) REFERENCES `lp_customer_info` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_rtm_order_online_delivery` FOREIGN KEY (`delivery_id`) REFERENCES `lp_customer_delivery_info` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lp_order_online`
--

LOCK TABLES `lp_order_online` WRITE;
/*!40000 ALTER TABLE `lp_order_online` DISABLE KEYS */;
/*!40000 ALTER TABLE `lp_order_online` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lp_order_online_detail`
--

DROP TABLE IF EXISTS `lp_order_online_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lp_order_online_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_code` varchar(20) NOT NULL,
  `product_id` int(11) NOT NULL,
  `spec_id` varchar(4) NOT NULL,
  `product_num` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_rtm_order_online_detail_1_idx` (`order_code`),
  KEY `fk_rtm_order_online_detail_2_idx` (`spec_id`),
  KEY `fk_rtm_order_online_detail_3_idx` (`product_id`),
  CONSTRAINT `fk_rtm_order_online_detail_1` FOREIGN KEY (`order_code`) REFERENCES `lp_order_online` (`order_code`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_rtm_order_online_detail_2` FOREIGN KEY (`spec_id`) REFERENCES `lp_global_specification` (`spec_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_rtm_order_online_detail_3` FOREIGN KEY (`product_id`) REFERENCES `lp_product_info` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lp_order_online_detail`
--

LOCK TABLES `lp_order_online_detail` WRITE;
/*!40000 ALTER TABLE `lp_order_online_detail` DISABLE KEYS */;
/*!40000 ALTER TABLE `lp_order_online_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lp_permission_info`
--

DROP TABLE IF EXISTS `lp_permission_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lp_permission_info` (
  `permission_code` varchar(50) NOT NULL COMMENT '权限编码，自定义，例如 1001，1002 等',
  `permission_action` varchar(45) NOT NULL COMMENT '权限的路径，目前以Controller的Route为基准，比如 /product/add  1001  增加商品',
  `description` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`permission_code`),
  UNIQUE KEY `permission_code_UNIQUE` (`permission_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lp_permission_info`
--

LOCK TABLES `lp_permission_info` WRITE;
/*!40000 ALTER TABLE `lp_permission_info` DISABLE KEYS */;
INSERT INTO `lp_permission_info` VALUES ('1001','/admin/user_manage/new_user','新增用户'),('1002','/admin/user_manage/edit_user','编辑用户'),('2001','/admin/product_manage/add_product','添加商品');
/*!40000 ALTER TABLE `lp_permission_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lp_permission_menu`
--

DROP TABLE IF EXISTS `lp_permission_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lp_permission_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(45) NOT NULL COMMENT '菜单名称',
  `permission_code` varchar(45) NOT NULL COMMENT '权限编码，与lp_permission_info表中的permission_code对应',
  `order_number` int(11) NOT NULL COMMENT '排序字段',
  `parent_id` varchar(45) DEFAULT NULL COMMENT '因为菜单有上下级，该字段表示所属的上级，如果时顶级菜单，该字段为空',
  PRIMARY KEY (`id`),
  KEY `fk_lp_permission_menu_1_idx` (`permission_code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lp_permission_menu`
--

LOCK TABLES `lp_permission_menu` WRITE;
/*!40000 ALTER TABLE `lp_permission_menu` DISABLE KEYS */;
INSERT INTO `lp_permission_menu` VALUES (1,'用户管理','',1,'0'),(2,'添加用户','1001',11,'1'),(3,'商品管理','',2,'0'),(4,'添加商品','2001',21,'3');
/*!40000 ALTER TABLE `lp_permission_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lp_product_category`
--

DROP TABLE IF EXISTS `lp_product_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lp_product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `order_code` int(11) DEFAULT NULL,
  `level_code` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lp_product_category`
--

LOCK TABLES `lp_product_category` WRITE;
/*!40000 ALTER TABLE `lp_product_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `lp_product_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lp_product_images`
--

DROP TABLE IF EXISTS `lp_product_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lp_product_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `thumbnail_url` varchar(100) NOT NULL COMMENT '小图路径',
  `image_url` varchar(100) NOT NULL COMMENT '大图路径',
  PRIMARY KEY (`id`),
  KEY `fk_rtm_product_images_1_idx` (`product_id`),
  CONSTRAINT `fk_rtm_product_images_1` FOREIGN KEY (`product_id`) REFERENCES `lp_product_info` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lp_product_images`
--

LOCK TABLES `lp_product_images` WRITE;
/*!40000 ALTER TABLE `lp_product_images` DISABLE KEYS */;
/*!40000 ALTER TABLE `lp_product_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lp_product_info`
--

DROP TABLE IF EXISTS `lp_product_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lp_product_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` text COMMENT '产品描述',
  `source` varchar(45) DEFAULT NULL COMMENT '产品来源',
  `created_by` int(11) DEFAULT NULL COMMENT '由谁创建，与lp_user_info的id进行关联',
  `created_at` datetime NOT NULL COMMENT '第一次创建时间，创建完成后时间不变',
  `last_update` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `fk_lp_product_info_1_idx` (`category_id`),
  CONSTRAINT `fk_lp_product_info_1` FOREIGN KEY (`category_id`) REFERENCES `lp_product_category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lp_product_info`
--

LOCK TABLES `lp_product_info` WRITE;
/*!40000 ALTER TABLE `lp_product_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `lp_product_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lp_product_specification`
--

DROP TABLE IF EXISTS `lp_product_specification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lp_product_specification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `spec_id` varchar(4) NOT NULL,
  `score` int(11) DEFAULT '0',
  `stock_num` int(11) DEFAULT '0' COMMENT '库存数量',
  `exchange_num` int(11) DEFAULT '0' COMMENT '可用于积分对换的数量',
  `is_for_exchange` tinyint(1) NOT NULL COMMENT '是否用于积分对换，有些商品是不能用于积分对换的\n积分商城中显示的商品应该使用该字段为true',
  `status` tinyint(1) DEFAULT NULL COMMENT '商品状态，比如上架，下架之类',
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_product_spec_id` (`product_id`,`spec_id`),
  KEY `fk_rtm_product_specification_2_idx` (`spec_id`),
  CONSTRAINT `fk_rtm_product_specification_1` FOREIGN KEY (`product_id`) REFERENCES `lp_product_info` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_rtm_product_specification_2` FOREIGN KEY (`spec_id`) REFERENCES `lp_global_specification` (`spec_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lp_product_specification`
--

LOCK TABLES `lp_product_specification` WRITE;
/*!40000 ALTER TABLE `lp_product_specification` DISABLE KEYS */;
/*!40000 ALTER TABLE `lp_product_specification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lp_promotion_info`
--

DROP TABLE IF EXISTS `lp_promotion_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lp_promotion_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL COMMENT '所属门店',
  `name` varchar(45) NOT NULL,
  `password` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `wechat_id` varchar(45) DEFAULT NULL COMMENT '微信用户ID',
  `status` tinyint(1) DEFAULT '0' COMMENT '促销员的状态，0：正常 1：冻结',
  `last_login` datetime DEFAULT NULL COMMENT '上次登录时间',
  `created_at` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `fk_rtm_promotion_info_1_idx` (`store_id`),
  CONSTRAINT `fk_rtm_promotion_info_1` FOREIGN KEY (`store_id`) REFERENCES `lp_global_store` (`store_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lp_promotion_info`
--

LOCK TABLES `lp_promotion_info` WRITE;
/*!40000 ALTER TABLE `lp_promotion_info` DISABLE KEYS */;
INSERT INTO `lp_promotion_info` VALUES (2,1,'admin','123','18311251527','ltao80@126.com','11',0,'2015-01-01 00:00:00','2015-01-01');
/*!40000 ALTER TABLE `lp_promotion_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lp_role_info`
--

DROP TABLE IF EXISTS `lp_role_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lp_role_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(250) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lp_role_info`
--

LOCK TABLES `lp_role_info` WRITE;
/*!40000 ALTER TABLE `lp_role_info` DISABLE KEYS */;
INSERT INTO `lp_role_info` VALUES (1,'促销员',''),(2,'促销管理员',NULL);
/*!40000 ALTER TABLE `lp_role_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lp_role_permission`
--

DROP TABLE IF EXISTS `lp_role_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lp_role_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `permission_code` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_lp_role_permission_1_idx` (`role_id`),
  KEY `fk_lp_role_permission_2_idx` (`permission_code`),
  CONSTRAINT `fk_lp_role_permission_1` FOREIGN KEY (`role_id`) REFERENCES `lp_role_info` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_lp_role_permission_2` FOREIGN KEY (`permission_code`) REFERENCES `lp_permission_info` (`permission_code`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lp_role_permission`
--

LOCK TABLES `lp_role_permission` WRITE;
/*!40000 ALTER TABLE `lp_role_permission` DISABLE KEYS */;
INSERT INTO `lp_role_permission` VALUES (1,1,'1001'),(2,1,'2001');
/*!40000 ALTER TABLE `lp_role_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lp_shopping_cart`
--

DROP TABLE IF EXISTS `lp_shopping_cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lp_shopping_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `spec_id` varchar(45) NOT NULL,
  `product_num` int(11) NOT NULL COMMENT '购买数量',
  `created_at` datetime NOT NULL COMMENT '规格编号',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_key` (`customer_id`,`product_id`,`spec_id`),
  KEY `fk_rtm_shopping_cart_1_idx` (`customer_id`),
  KEY `fk_rtm_shopping_cart_product_id_idx` (`product_id`),
  KEY `fk_rtm_shopping_cart_1_idx1` (`spec_id`),
  CONSTRAINT `fk_rtm_shopping_cart_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `lp_customer_info` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_rtm_shopping_cart_product_id` FOREIGN KEY (`product_id`) REFERENCES `lp_product_info` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_rtm_shopping_cart_spec` FOREIGN KEY (`spec_id`) REFERENCES `lp_global_specification` (`spec_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lp_shopping_cart`
--

LOCK TABLES `lp_shopping_cart` WRITE;
/*!40000 ALTER TABLE `lp_shopping_cart` DISABLE KEYS */;
/*!40000 ALTER TABLE `lp_shopping_cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lp_user_roles`
--

DROP TABLE IF EXISTS `lp_user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lp_user_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_lp_user_roles_1_idx` (`user_id`),
  KEY `fk_lp_user_roles_2_idx` (`role_id`),
  CONSTRAINT `fk_lp_user_roles_1` FOREIGN KEY (`user_id`) REFERENCES `lp_promotion_info` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_lp_user_roles_2` FOREIGN KEY (`role_id`) REFERENCES `lp_role_info` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lp_user_roles`
--

LOCK TABLES `lp_user_roles` WRITE;
/*!40000 ALTER TABLE `lp_user_roles` DISABLE KEYS */;
INSERT INTO `lp_user_roles` VALUES (1,2,1);
/*!40000 ALTER TABLE `lp_user_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'LP'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-05-25 10:23:45
