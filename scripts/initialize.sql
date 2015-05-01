
/*初始化规格*/
INSERT INTO `RTM`.`rtm_global_specification`
(`spec_id`,
`spec_name`)
VALUES
("35",
"35CL");

INSERT INTO `RTM`.`rtm_global_specification`
(`spec_id`,
`spec_name`)
VALUES
("70",
"70CL");

INSERT INTO `RTM`.`rtm_global_specification`
(`spec_id`,
`spec_name`)
VALUES
("100",
"1L");

INSERT INTO `RTM`.`rtm_global_specification`
(`spec_id`,
`spec_name`)
VALUES
("150",
"1.5L");

INSERT INTO `RTM`.`rtm_global_specification`
(`spec_id`,
`spec_name`)
VALUES
("300",
"3L");


/*初始化门店*/

INSERT INTO `RTM`.`rtm_global_store`
(`store_name`,
`province`,
`city`,
`region`)
VALUES(
"汕头专卖店",
"广东省",
"汕头市",
"南区");

/*初始化促销员*/
INSERT INTO `RTM`.`rtm_promotion_info`
(
`store_id`,
`name`,
`password`,
`phone`,
`email`,
`wechat_id`,
`status`,
`last_login`)
VALUES(
1,
"谢玉婷",
"password",
"13790848765",
"",
"",
0,
"2015-05-01 08:42:00");

/*初始化商品*/

INSERT INTO `RTM`.`rtm_product_info`(
`name`,
`title`,
`description`,
`source`)
VALUES(
"天醇X.O",
"天醇X.O",
"好贵的酒啊",
"法国");

INSERT INTO `RTM`.`rtm_product_specification`
(`product_id`,
`sepc_id`,
`score`,
`stock_num`,
`exchange_num`,
`is_for_exchange`,
`status`)
VALUES
(1,
"70",
100,
1000,
50,
1,
0);

INSERT INTO `RTM`.`rtm_product_images`
(`product_id`,
`thumbnail_url`,
'image_url')
VALUES(
1,
"thumbnailurl",
"bigimageurl");


