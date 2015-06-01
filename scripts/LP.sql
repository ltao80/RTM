-- MySQL dump 10.13  Distrib 5.6.24, for debian-linux-gnu (x86_64)
--
-- Host: master    Database: LP
-- ------------------------------------------------------
-- Server version	5.6.24-0ubuntu2

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

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `LP` /*!40100 DEFAULT CHARACTER SET latin1 */;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lp_delivery_company`
--

LOCK TABLES `lp_delivery_company` WRITE;
/*!40000 ALTER TABLE `lp_delivery_company` DISABLE KEYS */;
INSERT INTO `lp_delivery_company` VALUES (1,'顺丰速递');
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
INSERT INTO `lp_global_specification` VALUES ('100','1L'),('150','1.5L'),('300','3L'),('35','35CL'),('70','70CL');
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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lp_global_store`
--

LOCK TABLES `lp_global_store` WRITE;
/*!40000 ALTER TABLE `lp_global_store` DISABLE KEYS */;
INSERT INTO `lp_global_store` VALUES (1,'汕头专卖店','广东','汕头','南区'),(2,'友谊（淘金店）','广东','广州','南区'),(3,'俊涛企业(黄石店)','广东','广州','南区'),(4,'山姆会员店-广州-番禺店','广东','广州','南区'),(5,'麦德龙-广州-天河店','广东','广州','南区'),(6,'麦德龙-广州-新市店','广东','广州','南区'),(7,'东岳（宏基）商场','广东','云浮','南区'),(8,'铭轩商行','广东','惠州','南区'),(9,'麦德龙','广东','东莞','南区'),(10,'南北行','广东','东莞','南区'),(11,'深圳山姆会员店龙岗分店','广东','深圳','南区'),(12,'深圳麦德龙南山店','广东','深圳','南区'),(13,'天虹常兴店','广东','深圳','南区'),(14,'华润万家春风店','广东','深圳','南区'),(15,'Ole万象城店','广东','深圳','南区'),(16,'酒易购商行','广东','深圳','南区'),(17,'特免格兰云天店','广东','深圳','南区'),(18,'华润万家龙岗店','广东','深圳','南区'),(19,'东启品味创业店','广东','深圳','南区'),(20,'漳州龙海志盛商行','福建','漳州','东区'),(21,'漳州云霄县乐天酒类贸易有限公司','福建','漳州','东区'),(22,'漳州素惠食杂','福建','漳州','东区'),(23,'漳州诏安县小平酒铺','福建','漳州','东区'),(24,'三明京丰贸易','福建','三明/南平','东区'),(25,'莆田市德盛烟酒商行','福建','莆田','东区'),(26,'山姆会员店-福州-福州店','福建','福州','东区'),(27,'麦德龙-厦门-湖里店','福建','厦门','东区'),(28,'厦门杏林妙云食杂店','福建','厦门','东区'),(29,'泉州市石狮市历记名酒贸易有限公司','福建','泉州','东区'),(30,'泉州市佳鸿名酒行','福建','泉州','东区'),(31,'泉州市丰泽裕源食品商行','福建','泉州','东区'),(32,'山姆会员店-福州-福州店','福建','福州','东区');
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
INSERT INTO `lp_permission_info` VALUES ('1001','/admin/user_manage/new_user','新增用户'),('1002','/admin/user_manage/edit_user','编辑用户'),('1003','/admin/user_manage/list_user','管理用户'),('1004','/admin/user_manage/save_user','保存用户'),('1005','/admin/permission_manage/list_role','角色管理'),('1006','/admin/permission_manage/edit_role','编辑角色'),('1007','/admin/permission_manage/new_role','添加角色'),('1008','/admin/permission_manage/save_role','保存角色'),('2001','/admin/product_manage/new_product','添加商品页'),('2002','/admin/product_manage/list_products','商品列表'),('2003','/admin/product_manage/update_product','修改商品'),('2004','/admin/product_manage/delete_product','删除商品'),('2005','/admin/product_manage/get_product_by_id','商品的详情展示'),('2006','/admin/product_manage/update_exchange_status','更改商品状态'),('2007','/admin/product_manage/upload_product_image','上传商品图片'),('2008','/admin/product_manage/get_category_list','商品类别列表'),('2009','/admin/product_manage/add_product','添加商品'),('3001','/admin/order_manage/get_online_order_list','线上订单列表'),('3002','/admin/order_manage/get_delivery_detail','订单发货详情'),('3003','/admin/order_manage/export_online_order','导出线上订单'),('3004','/admin/order_manage/delivery','发货'),('3005','/admin/order_manage/get_offline_order_list','线下订单列表'),('4001','/admin/customer_manage/user_info','用户信息'),('4002','/admin/customer_manage/user_detail_info','用户详细信息'),('4003','/admin/customer_manage/post_info','邮寄信息'),('4004','/admin/customer_manage/exchange_info','对换信息'),('4005','/admin/customer_manage/score_info','积分信息'),('4006','/admin/customer_manage/shopping_order_info','门店购买订单信息'),('4007','/admin/order_manage/export_offline_order','导出线下订单'),('4008', '/admin/product_manage/list_category', '分类管理'),('4009', '/admin/product_manage/new_category', '添加/编辑分类页'),('4010', '/admin/product_manage/add_category', '添加分类'),('4011', '/admin/product_manage/edit_category', '修改分类'),('4012', '/admin/product_manage/delete_category', '删除分类');
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
  `menu_icon` varchar(45) DEFAULT NULL,
  `is_nav` varchar(45) DEFAULT '1' COMMENT '是否显示在左侧的功能导航上，比如“删除” 基本上是不会显示在导航上的，但是在创建角色时需要设置删除权限。换句话说，创建和修改角色的权限菜单会显示所有的',
  PRIMARY KEY (`id`),
  KEY `fk_lp_permission_menu_1_idx` (`permission_code`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lp_permission_menu`
--

LOCK TABLES `lp_permission_menu` WRITE;
/*!40000 ALTER TABLE `lp_permission_menu` DISABLE KEYS */;
INSERT INTO `lp_permission_menu` VALUES (1,'用户管理','',1,'0','icon-user','1'),(2,'添加用户','1001',11,'1',NULL,'1'),(3,'商品管理','',2,'0','icon-shopping-cart','1'),(4,'添加商品','2001',21,'3',NULL,'1'),(5,'订单管理','',3,'0','icon-tasks','1'),(6,'线上订单列表','3001',31,'5',NULL,'1'),(7,'商品列表','2002',22,'3',NULL,'1'),(8,'线下订单列表','3005',32,'5',NULL,'1'),(9,'会员管理','',4,'0','icon-group','1'),(10,'用户信息详情','4002',42,'9',NULL,'0'),(11,'邮寄信息\n','4003',43,'9',NULL,'0'),(12,'兑换信息\n','4004',44,'9',NULL,'0'),(13,'积分信息\n','4005',45,'9',NULL,'0'),(14,'门店购买订单信息\n','4006',46,'9',NULL,'0'),(15,'用户信息','4001',41,'9',NULL,'1'),(16,'管理用户','1003',13,'1','','1'),(17,'角色管理','1005',15,'1',NULL,'1'),(18,'编辑用户','1002',12,'1',NULL,'0'),(19,'保存用户','1004',14,'1',NULL,'0'),(20,'编辑角色','1006',16,'1',NULL,'0'),(21,'添加角色','1007',17,'1',NULL,'1'),(22,'保存角色','1008',18,'1',NULL,'0'),('23', '管理分类', '4008', '24', '3', null, '1'),('24', '添加分类', '4009', '23', '3', null, '1');
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
  `store_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` text COMMENT '产品描述',
  `source` varchar(45) DEFAULT NULL COMMENT '产品来源',
  `created_by` int(11) DEFAULT NULL COMMENT '由谁创建，与lp_user_info的id进行关联',
  `created_at` datetime NOT NULL COMMENT '第一次创建时间，创建完成后时间不变',
  `last_update` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `fk_lp_product_info_1_idx` (`category_id`),
  KEY `fk_lp_product_info_2_idx` (`store_id`),
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lp_promotion_info`
--

LOCK TABLES `lp_promotion_info` WRITE;
/*!40000 ALTER TABLE `lp_promotion_info` DISABLE KEYS */;
INSERT INTO `lp_promotion_info` VALUES (1,1,'admin','fhVV64KowOgfU','18311251527','admin@parllay.cn','11',0,'2015-01-01 00:00:00','2015-01-01'),(6,4,'Test','fh8M6ER3XH5WQ','18311251527','ltao80@126.com','0',0,NULL,'2015-05-31 19:58:24'),(7,1,'test1','fh8M6ER3XH5WQ','18311251527','ltao81@126.com','0',0,NULL,'2015-05-31 19:59:41'),(8,1,'test3','fh8M6ER3XH5WQ','18311251527','ltao83@126.com','0',1,NULL,'2015-05-31 20:00:05');
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
  `role_name` varchar(250) DEFAULT NULL COMMENT '角色名称，唯一，administrator 是特殊角色拥有所有权限',
  `description` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_name_UNIQUE` (`role_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lp_role_info`
--

LOCK TABLES `lp_role_info` WRITE;
/*!40000 ALTER TABLE `lp_role_info` DISABLE KEYS */;
INSERT INTO `lp_role_info` VALUES (1,'administrator','超级管理员，拥有所有权限'),(2,'促销管理员',''),(3,'促销员',NULL),(4,'Test','test');
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
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lp_role_permission`
--

LOCK TABLES `lp_role_permission` WRITE;
/*!40000 ALTER TABLE `lp_role_permission` DISABLE KEYS */;
INSERT INTO `lp_role_permission` VALUES (14,1,'1001'),(15,1,'1003'),(16,1,'1005'),(17,1,'2001'),(18,1,'2002'),(19,1,'3001'),(20,1,'3005'),(21,1,'4001'),(22,1,'4002'),(23,1,'4003'),(24,1,'4004'),(25,1,'4005'),(26,1,'4006'),(27,1,'1002'),(28,1,'1006'),(29,1,'1007'),(30,1,'1008'),(31,4,'1001'),(32,4,'1002'),(33,4,'1003'),(34,4,'1005'),(35,4,'1006'),(36,4,'1007'),(37,4,'1008'),(38,4,'2001'),(39,4,'2002'),(40,4,'3001'),(41,4,'3005'),(42,4,'4001'),(43,4,'4002'),(44,4,'4003'),(45,4,'4004'),(46,4,'4005'),(47,4,'4006'),(48,2,'1001'),(49,2,'1005'),(50,2,'2001'),(51,2,'2002'),(52,2,'3001'),(53,2,'3005'),(54,2,'4001'),(55,2,'4002'),(56,2,'4003'),(57,2,'4004'),(58,2,'4005'),(59,2,'4006'),(60, 1, '4007'),(61, 1, '4008'),(62, 1, '4009');
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lp_user_roles`
--

LOCK TABLES `lp_user_roles` WRITE;
/*!40000 ALTER TABLE `lp_user_roles` DISABLE KEYS */;
INSERT INTO `lp_user_roles` VALUES (1,1,1),(8,7,2),(9,8,2),(10,6,2);
/*!40000 ALTER TABLE `lp_user_roles` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-06-01 10:12:28
