
/*初始化规格*/
INSERT INTO `LP`.`lp_global_specification`
(`spec_id`,
`spec_name`)
VALUES
("35",
"35CL");

INSERT INTO `LP`.`lp_global_specification`
(`spec_id`,
`spec_name`)
VALUES
("70",
"70CL");

INSERT INTO `LP`.`lp_global_specification`
(`spec_id`,
`spec_name`)
VALUES
("100",
"1L");

INSERT INTO `LP`.`lp_global_specification`
(`spec_id`,
`spec_name`)
VALUES
("150",
"1.5L");

INSERT INTO `LP`.`lp_global_specification`
(`spec_id`,
`spec_name`)
VALUES
("300",
"3L");


/*初始化门店*/

INSERT INTO `LP`.`lp_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("汕头专卖店","广东","汕头","南区");
INSERT INTO `LP`.`lp_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("友谊（淘金店）","广东","广州","南区");
INSERT INTO `LP`.`lp_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("俊涛企业(黄石店)","广东","广州","南区");
INSERT INTO `LP`.`lp_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("山姆会员店-广州-番禺店","广东","广州","南区");
INSERT INTO `LP`.`lp_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("麦德龙-广州-天河店","广东","广州","南区");
INSERT INTO `LP`.`lp_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("麦德龙-广州-新市店","广东","广州","南区");
INSERT INTO `LP`.`lp_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("东岳（宏基）商场","广东","云浮","南区");
INSERT INTO `LP`.`lp_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("铭轩商行","广东","惠州","南区");
INSERT INTO `LP`.`lp_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("麦德龙","广东","东莞","南区");
INSERT INTO `LP`.`lp_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("南北行","广东","东莞","南区");
INSERT INTO `LP`.`lp_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("深圳山姆会员店龙岗分店","广东","深圳","南区");
INSERT INTO `LP`.`lp_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("深圳麦德龙南山店","广东","深圳","南区");
INSERT INTO `LP`.`lp_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("天虹常兴店","广东","深圳","南区");
INSERT INTO `LP`.`lp_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("华润万家春风店","广东","深圳","南区");
INSERT INTO `LP`.`lp_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("Ole万象城店","广东","深圳","南区");
INSERT INTO `LP`.`lp_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("酒易购商行","广东","深圳","南区");
INSERT INTO `LP`.`lp_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("特免格兰云天店","广东","深圳","南区");
INSERT INTO `LP`.`lp_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("华润万家龙岗店","广东","深圳","南区");
INSERT INTO `LP`.`lp_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("东启品味创业店","广东","深圳","南区");
INSERT INTO `LP`.`lp_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("漳州龙海志盛商行","福建","漳州","东区");
INSERT INTO `LP`.`lp_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("漳州云霄县乐天酒类贸易有限公司","福建","漳州","东区");
INSERT INTO `LP`.`lp_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("漳州素惠食杂","福建","漳州","东区");
INSERT INTO `LP`.`lp_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("漳州诏安县小平酒铺","福建","漳州","东区");
INSERT INTO `LP`.`lp_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("三明京丰贸易","福建","三明/南平","东区");
INSERT INTO `LP`.`lp_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("莆田市德盛烟酒商行","福建","莆田","东区");
INSERT INTO `LP`.`lp_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("山姆会员店-福州-福州店","福建","福州","东区");
INSERT INTO `LP`.`lp_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("麦德龙-厦门-湖里店","福建","厦门","东区");
INSERT INTO `LP`.`lp_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("厦门杏林妙云食杂店","福建","厦门","东区");
INSERT INTO `LP`.`lp_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("泉州市石狮市历记名酒贸易有限公司","福建","泉州","东区");
INSERT INTO `LP`.`lp_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("泉州市佳鸿名酒行","福建","泉州","东区");
INSERT INTO `LP`.`lp_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("泉州市丰泽裕源食品商行","福建","泉州","东区");
INSERT INTO `LP`.`lp_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("山姆会员店-福州-福州店","福建","福州","东区");

/*物流公司*/
INSERT INTO `LP`.`lp_delivery_company`
(`company_name`)
VALUES
('顺丰速递');

/*权限信息*/
LOCK TABLES `lp_permission_info` WRITE;
/*!40000 ALTER TABLE `lp_permission_info` DISABLE KEYS */;
INSERT INTO `lp_permission_info` VALUES ('1001','/admin/user_manage/new_user','新增用户'),('1002','/admin/user_manage/edit_user','编辑用户'),('1003','/admin/user_manage/list_user','管理用户'),('1004','/admin/user_manage/save_user','保存用户'),('1005','/admin/permission_manage/list_role','角色管理'),('1006','/admin/permission_manage/edit_role','编辑角色'),('1007','/admin/permission_manage/new_role','添加角色'),('1008','/admin/permission_manage/save_role','保存角色'),('2001','/admin/product_manage/new_product','添加商品页'),('2002','/admin/product_manage/list_products','商品列表'),('2003','/admin/product_manage/update_product','修改商品'),('2004','/admin/product_manage/delete_product','删除商品'),('2005','/admin/product_manage/get_product_by_id','商品的详情展示'),('2006','/admin/product_manage/update_exchange_status','更改商品状态'),('2007','/admin/product_manage/upload_product_image','上传商品图片'),('2008','/admin/product_manage/get_category_list','商品类别列表'),('2009','/admin/product_manage/add_product','添加商品'),('3001','/admin/order_manage/get_online_order_list','线上订单列表'),('3002','/admin/order_manage/get_delivery_detail','订单发货详情'),('3003','/admin/order_manage/export_online_order','导出线上订单'),('3004','/admin/order_manage/delivery','发货'),('3005','/admin/order_manage/get_offline_order_list','线下订单列表'),('4001','/admin/customer_manage/user_info','用户信息'),('4002','/admin/customer_manage/user_detail_info','用户详细信息'),('4003','/admin/customer_manage/post_info','邮寄信息'),('4004','/admin/customer_manage/exchange_info','对换信息'),('4005','/admin/customer_manage/score_info','积分信息'),('4006','/admin/customer_manage/shopping_order_info','门店购买订单信息'),('4007','/admin/order_manage/export_offline_order','导出线下订单');
/*!40000 ALTER TABLE `lp_permission_info` ENABLE KEYS */;
UNLOCK TABLES;

/*菜单信息*/
LOCK TABLES `lp_permission_menu` WRITE;
/*!40000 ALTER TABLE `lp_permission_menu` DISABLE KEYS */;
INSERT INTO `lp_permission_menu` VALUES (1,'用户管理','',1,'0','icon-user','1'),(2,'添加用户','1001',11,'1',NULL,'1'),(3,'商品管理','',2,'0','icon-shopping-cart','1'),(4,'添加商品','2001',21,'3',NULL,'1'),(5,'订单管理','',3,'0','icon-tasks','1'),(6,'线上订单列表','3001',31,'5',NULL,'1'),(7,'商品列表','2002',22,'3',NULL,'1'),(8,'线下订单列表','3005',32,'5',NULL,'1'),(9,'会员管理','',4,'0','icon-group','1'),(10,'用户信息详情','4002',42,'9',NULL,'0'),(11,'邮寄信息\n','4003',43,'9',NULL,'0'),(12,'兑换信息\n','4004',44,'9',NULL,'0'),(13,'积分信息\n','4005',45,'9',NULL,'0'),(14,'门店购买订单信息\n','4006',46,'9',NULL,'0'),(15,'用户信息','4001',41,'9',NULL,'1'),(16,'管理用户','1003',13,'1','','1'),(17,'角色管理','1005',15,'1',NULL,'1'),(18,'编辑用户','1002',12,'1',NULL,'0'),(19,'保存用户','1004',14,'1',NULL,'0'),(20,'编辑角色','1006',16,'1',NULL,'0'),(21,'添加角色','1007',17,'1',NULL,'1'),(22,'保存角色','1008',18,'1',NULL,'0');
/*!40000 ALTER TABLE `lp_permission_menu` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `lp_role_info` WRITE;
/*!40000 ALTER TABLE `lp_role_info` DISABLE KEYS */;
/*角色信息*/
INSERT INTO `lp_role_info` VALUES (1,'administrator','超级管理员，拥有所有权限'),(2,'促销管理员',''),(3,'促销员',NULL);

UNLOCK TABLES;

/*权限信息*/
LOCK TABLES `lp_role_permission` WRITE;
/*!40000 ALTER TABLE `lp_role_permission` DISABLE KEYS */;
INSERT INTO `lp_role_permission` VALUES (1,2,'1001'),(2,2,'1003'),(3,2,'1005'),(4,2,'2001'),(5,2,'2002'),(6,2,'3001'),(7,2,'3005'),(8,2,'4001'),(9,2,'4002'),(10,2,'4003'),(11,2,'4004'),(12,2,'4005'),(13,2,'4006'),(14,1,'1001'),(15,1,'1003'),(16,1,'1005'),(17,1,'2001'),(18,1,'2002'),(19,1,'3001'),(20,1,'3005'),(21,1,'4001'),(22,1,'4002'),(23,1,'4003'),(24,1,'4004'),(25,1,'4005'),(26,1,'4006'),(27,1,'1002'),(28,1,'1006'),(29,1,'1007'),(30,1,'1008');
/*!40000 ALTER TABLE `lp_role_permission` ENABLE KEYS */;
UNLOCK TABLES;


LOCK TABLES `lp_promotion_info` WRITE;
/*!40000 ALTER TABLE `lp_promotion_info` DISABLE KEYS */;
INSERT INTO `lp_promotion_info` VALUES (1,1,'admin','fhVV64KowOgfU','18311251527','admin@parllay.cn','11',0,'2015-01-01 00:00:00','2015-01-01');
/*!40000 ALTER TABLE `lp_promotion_info` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `lp_user_roles` WRITE;
/*!40000 ALTER TABLE `lp_user_roles` DISABLE KEYS */;
INSERT INTO `lp_user_roles` VALUES (1,1,1);
/*!40000 ALTER TABLE `lp_user_roles` ENABLE KEYS */;
UNLOCK TABLES;