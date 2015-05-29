/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50534
Source Host           : localhost:3306
Source Database       : lp

Target Server Type    : MYSQL
Target Server Version : 50534
File Encoding         : 65001

Date: 2015-05-29 10:18:18
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `lp_customer_delivery_info`
-- ----------------------------
DROP TABLE IF EXISTS `lp_customer_delivery_info`;
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

-- ----------------------------
-- Records of lp_customer_delivery_info
-- ----------------------------

-- ----------------------------
-- Table structure for `lp_customer_info`
-- ----------------------------
DROP TABLE IF EXISTS `lp_customer_info`;
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

-- ----------------------------
-- Records of lp_customer_info
-- ----------------------------

-- ----------------------------
-- Table structure for `lp_customer_score_list`
-- ----------------------------
DROP TABLE IF EXISTS `lp_customer_score_list`;
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

-- ----------------------------
-- Records of lp_customer_score_list
-- ----------------------------

-- ----------------------------
-- Table structure for `lp_delivery_company`
-- ----------------------------
DROP TABLE IF EXISTS `lp_delivery_company`;
CREATE TABLE `lp_delivery_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(45) NOT NULL COMMENT '物流公司名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lp_delivery_company
-- ----------------------------

-- ----------------------------
-- Table structure for `lp_global_specification`
-- ----------------------------
DROP TABLE IF EXISTS `lp_global_specification`;
CREATE TABLE `lp_global_specification` (
  `spec_id` varchar(4) NOT NULL,
  `spec_name` varchar(45) NOT NULL,
  PRIMARY KEY (`spec_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lp_global_specification
-- ----------------------------
INSERT INTO `lp_global_specification` VALUES ('1', '100L');
INSERT INTO `lp_global_specification` VALUES ('2', '70L');
INSERT INTO `lp_global_specification` VALUES ('3', '50L');

-- ----------------------------
-- Table structure for `lp_global_store`
-- ----------------------------
DROP TABLE IF EXISTS `lp_global_store`;
CREATE TABLE `lp_global_store` (
  `store_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(300) NOT NULL COMMENT '店面名称',
  `province` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `region` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`store_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lp_global_store
-- ----------------------------
INSERT INTO `lp_global_store` VALUES ('1', '默认门店', '默认', '默认', '默认');

-- ----------------------------
-- Table structure for `lp_order_offline`
-- ----------------------------
DROP TABLE IF EXISTS `lp_order_offline`;
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

-- ----------------------------
-- Records of lp_order_offline
-- ----------------------------

-- ----------------------------
-- Table structure for `lp_order_offline_detail`
-- ----------------------------
DROP TABLE IF EXISTS `lp_order_offline_detail`;
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

-- ----------------------------
-- Records of lp_order_offline_detail
-- ----------------------------

-- ----------------------------
-- Table structure for `lp_order_online`
-- ----------------------------
DROP TABLE IF EXISTS `lp_order_online`;
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

-- ----------------------------
-- Records of lp_order_online
-- ----------------------------

-- ----------------------------
-- Table structure for `lp_order_online_detail`
-- ----------------------------
DROP TABLE IF EXISTS `lp_order_online_detail`;
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

-- ----------------------------
-- Records of lp_order_online_detail
-- ----------------------------

-- ----------------------------
-- Table structure for `lp_permission_info`
-- ----------------------------
DROP TABLE IF EXISTS `lp_permission_info`;
CREATE TABLE `lp_permission_info` (
  `permission_code` varchar(50) NOT NULL COMMENT '权限编码，自定义，例如 1001，1002 等',
  `permission_action` varchar(45) NOT NULL COMMENT '权限的路径，目前以Controller的Route为基准，比如 /product/add  1001  增加商品',
  `description` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`permission_code`),
  UNIQUE KEY `permission_code_UNIQUE` (`permission_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lp_permission_info
-- ----------------------------
INSERT INTO `lp_permission_info` VALUES ('1001', '/admin/user_manage/new_user', '新增用户');
INSERT INTO `lp_permission_info` VALUES ('1002', '/admin/user_manage/edit_user', '编辑用户');
INSERT INTO `lp_permission_info` VALUES ('2001', '/admin/product_manage/new_product', '添加商品页');
INSERT INTO `lp_permission_info` VALUES ('2002', '/admin/product_manage/list_products', '商品列表');
INSERT INTO `lp_permission_info` VALUES ('2003', '/admin/product_manage/update_product', '修改商品');
INSERT INTO `lp_permission_info` VALUES ('2004', '/admin/product_manage/delete_product', '删除商品');
INSERT INTO `lp_permission_info` VALUES ('2005', '/admin/product_manage/get_product_by_id', '商品的详情展示');
INSERT INTO `lp_permission_info` VALUES ('2006', '/admin/product_manage/update_exchange_status', '更改商品状态');
INSERT INTO `lp_permission_info` VALUES ('2007', '/admin/product_manage/upload_product_image', '上传商品图片');
INSERT INTO `lp_permission_info` VALUES ('2008', '/admin/product_manage/get_category_list', '商品类别列表');
INSERT INTO `lp_permission_info` VALUES ('2009', '/admin/product_manage/add_product', '添加商品');
INSERT INTO `lp_permission_info` VALUES ('3001', '/admin/order_manage/get_online_order_list', '线上订单列表');
INSERT INTO `lp_permission_info` VALUES ('3002', '/admin/order_manage/get_delivery_detail', '订单发货详情');
INSERT INTO `lp_permission_info` VALUES ('3003', '/admin/order_manage/export_online_order', '导出线上订单');
INSERT INTO `lp_permission_info` VALUES ('3004', '/admin/order_manage/delivery', '发货');
INSERT INTO `lp_permission_info` VALUES ('3005', '/admin/order_manage/get_offline_order_list', '线下订单列表');

-- ----------------------------
-- Table structure for `lp_permission_menu`
-- ----------------------------
DROP TABLE IF EXISTS `lp_permission_menu`;
CREATE TABLE `lp_permission_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(45) NOT NULL COMMENT '菜单名称',
  `permission_code` varchar(45) NOT NULL COMMENT '权限编码，与lp_permission_info表中的permission_code对应',
  `order_number` int(11) NOT NULL COMMENT '排序字段',
  `parent_id` varchar(45) DEFAULT NULL COMMENT '因为菜单有上下级，该字段表示所属的上级，如果时顶级菜单，该字段为空',
  PRIMARY KEY (`id`),
  KEY `fk_lp_permission_menu_1_idx` (`permission_code`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lp_permission_menu
-- ----------------------------
INSERT INTO `lp_permission_menu` VALUES ('1', '用户管理', '', '1', '0');
INSERT INTO `lp_permission_menu` VALUES ('2', '添加用户', '1001', '11', '1');
INSERT INTO `lp_permission_menu` VALUES ('3', '商品管理', '', '2', '0');
INSERT INTO `lp_permission_menu` VALUES ('4', '添加商品', '2001', '21', '3');
INSERT INTO `lp_permission_menu` VALUES ('5', '订单管理', '', '3', '0');
INSERT INTO `lp_permission_menu` VALUES ('6', '线上订单列表', '3001', '31', '5');
INSERT INTO `lp_permission_menu` VALUES ('7', '商品列表', '2002', '22', '3');
INSERT INTO `lp_permission_menu` VALUES ('8', '线下订单列表', '3005', '32', '5');

-- ----------------------------
-- Table structure for `lp_product_category`
-- ----------------------------
DROP TABLE IF EXISTS `lp_product_category`;
CREATE TABLE `lp_product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `order_code` int(11) DEFAULT NULL,
  `level_code` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lp_product_category
-- ----------------------------
INSERT INTO `lp_product_category` VALUES ('1', '3', '酒类', '各种酒类', null, null);
INSERT INTO `lp_product_category` VALUES ('2', '3', '食品', '食品', null, null);

-- ----------------------------
-- Table structure for `lp_product_images`
-- ----------------------------
DROP TABLE IF EXISTS `lp_product_images`;
CREATE TABLE `lp_product_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `thumbnail_url` varchar(100) NOT NULL COMMENT '小图路径',
  `image_url` varchar(100) NOT NULL COMMENT '大图路径',
  PRIMARY KEY (`id`),
  KEY `fk_rtm_product_images_1_idx` (`product_id`),
  CONSTRAINT `fk_rtm_product_images_1` FOREIGN KEY (`product_id`) REFERENCES `lp_product_info` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lp_product_images
-- ----------------------------
INSERT INTO `lp_product_images` VALUES ('2', '4', '123.jpg', '1222.jpg');
INSERT INTO `lp_product_images` VALUES ('3', '5', '123.jpg', '1222.jpg');
INSERT INTO `lp_product_images` VALUES ('4', '8', '5-14296909201454-thumb.jpg', '5-14296909201454.jpg');
INSERT INTO `lp_product_images` VALUES ('5', '9', '0', '0');
INSERT INTO `lp_product_images` VALUES ('6', '10', '', '22225.jpg');
INSERT INTO `lp_product_images` VALUES ('7', '11', '', '5-14296909201455.jpg');
INSERT INTO `lp_product_images` VALUES ('8', '12', '5-14296909201456-thumb.jpg', '5-14296909201456.jpg');
INSERT INTO `lp_product_images` VALUES ('9', '13', '1236-thumb.jpg', '1236.jpg');

-- ----------------------------
-- Table structure for `lp_product_info`
-- ----------------------------
DROP TABLE IF EXISTS `lp_product_info`;
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lp_product_info
-- ----------------------------
INSERT INTO `lp_product_info` VALUES ('4', '1', '人头马XO', '大屏的人头马xo', '这是描述信息', null, '1', '2015-05-27 10:37:42', '0000-00-00 00:00:00');
INSERT INTO `lp_product_info` VALUES ('5', '1', '0', '0', '0', null, '1', '2015-05-27 11:07:16', '0000-00-00 00:00:00');
INSERT INTO `lp_product_info` VALUES ('8', '2', '食品安全', '食品的是的啊的', '123123', null, '2', '2015-05-28 16:00:51', '0000-00-00 00:00:00');
INSERT INTO `lp_product_info` VALUES ('9', '2', '修改的', '0', '你妹妹', null, '2', '2015-05-28 16:05:41', '0000-00-00 00:00:00');
INSERT INTO `lp_product_info` VALUES ('10', '2', '小食品', '小食品', '123123', null, '2', '2015-05-28 16:32:55', '0000-00-00 00:00:00');
INSERT INTO `lp_product_info` VALUES ('11', '1', '卡机的饭卡机的看法', '卡机的饭卡机的看法', '2222', null, '2', '2015-05-28 16:35:45', '0000-00-00 00:00:00');
INSERT INTO `lp_product_info` VALUES ('12', '2', '全额1', '你妈的', '12312', null, '2', '2015-05-28 16:38:41', '0000-00-00 00:00:00');
INSERT INTO `lp_product_info` VALUES ('13', '1', '什么酒呢', '什么酒呢', '123', null, '2', '2015-05-28 18:11:29', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for `lp_product_specification`
-- ----------------------------
DROP TABLE IF EXISTS `lp_product_specification`;
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lp_product_specification
-- ----------------------------
INSERT INTO `lp_product_specification` VALUES ('3', '4', '2', '200', '100', '100', '1', '1');
INSERT INTO `lp_product_specification` VALUES ('8', '9', '1', '100', '100', '100', '1', '0');
INSERT INTO `lp_product_specification` VALUES ('14', '12', '2', '111', '222', '222', '1', '0');
INSERT INTO `lp_product_specification` VALUES ('15', '12', '1', '222', '333', '333', '1', '0');
INSERT INTO `lp_product_specification` VALUES ('16', '13', '1', '1', '1', '1', '1', '1');

-- ----------------------------
-- Table structure for `lp_promotion_info`
-- ----------------------------
DROP TABLE IF EXISTS `lp_promotion_info`;
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

-- ----------------------------
-- Records of lp_promotion_info
-- ----------------------------
INSERT INTO `lp_promotion_info` VALUES ('2', '1', 'admin', '123', '18311251527', 'ltao80@126.com', '11', '0', '2015-01-01 00:00:00', '2015-01-01');

-- ----------------------------
-- Table structure for `lp_role_info`
-- ----------------------------
DROP TABLE IF EXISTS `lp_role_info`;
CREATE TABLE `lp_role_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(250) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lp_role_info
-- ----------------------------
INSERT INTO `lp_role_info` VALUES ('1', '促销员', '');
INSERT INTO `lp_role_info` VALUES ('2', '促销管理员', null);

-- ----------------------------
-- Table structure for `lp_role_permission`
-- ----------------------------
DROP TABLE IF EXISTS `lp_role_permission`;
CREATE TABLE `lp_role_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `permission_code` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_lp_role_permission_1_idx` (`role_id`),
  KEY `fk_lp_role_permission_2_idx` (`permission_code`),
  CONSTRAINT `fk_lp_role_permission_1` FOREIGN KEY (`role_id`) REFERENCES `lp_role_info` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_lp_role_permission_2` FOREIGN KEY (`permission_code`) REFERENCES `lp_permission_info` (`permission_code`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lp_role_permission
-- ----------------------------
INSERT INTO `lp_role_permission` VALUES ('1', '1', '1001');
INSERT INTO `lp_role_permission` VALUES ('2', '1', '2001');
INSERT INTO `lp_role_permission` VALUES ('3', '1', '1002');
INSERT INTO `lp_role_permission` VALUES ('4', '1', '2002');
INSERT INTO `lp_role_permission` VALUES ('5', '1', '2003');
INSERT INTO `lp_role_permission` VALUES ('6', '1', '2004');
INSERT INTO `lp_role_permission` VALUES ('7', '1', '3001');
INSERT INTO `lp_role_permission` VALUES ('8', '1', '2005');
INSERT INTO `lp_role_permission` VALUES ('9', '1', '2006');
INSERT INTO `lp_role_permission` VALUES ('10', '1', '2007');
INSERT INTO `lp_role_permission` VALUES ('11', '1', '2008');
INSERT INTO `lp_role_permission` VALUES ('12', '1', '3002');
INSERT INTO `lp_role_permission` VALUES ('13', '1', '3003');
INSERT INTO `lp_role_permission` VALUES ('14', '1', '2009');
INSERT INTO `lp_role_permission` VALUES ('15', '1', '3004');
INSERT INTO `lp_role_permission` VALUES ('16', '1', '3005');

-- ----------------------------
-- Table structure for `lp_shopping_cart`
-- ----------------------------
DROP TABLE IF EXISTS `lp_shopping_cart`;
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

-- ----------------------------
-- Records of lp_shopping_cart
-- ----------------------------

-- ----------------------------
-- Table structure for `lp_user_roles`
-- ----------------------------
DROP TABLE IF EXISTS `lp_user_roles`;
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

-- ----------------------------
-- Records of lp_user_roles
-- ----------------------------
INSERT INTO `lp_user_roles` VALUES ('1', '2', '1');
