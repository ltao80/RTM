
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

/*菜单信息*/
INSERT INTO `lp_permission_menu` VALUES ('1', '用户管理', '', '1', '0');
INSERT INTO `lp_permission_menu` VALUES ('2', '添加用户', '1001', '11', '1');
INSERT INTO `lp_permission_menu` VALUES ('3', '商品管理', '', '2', '0');
INSERT INTO `lp_permission_menu` VALUES ('4', '添加商品', '2001', '21', '3');
INSERT INTO `lp_permission_menu` VALUES ('5', '订单管理', '', '3', '0');
INSERT INTO `lp_permission_menu` VALUES ('6', '线上订单列表', '3001', '31', '5');
INSERT INTO `lp_permission_menu` VALUES ('7', '商品列表', '2002', '22', '3');
INSERT INTO `lp_permission_menu` VALUES ('8', '线下订单列表', '3005', '32', '5');

/*角色信息*/
INSERT INTO `lp_role_info` VALUES ('1', '促销员', '');
INSERT INTO `lp_role_info` VALUES ('2', '促销管理员', null);

/*权限信息*/
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





