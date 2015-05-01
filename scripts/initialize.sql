
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

