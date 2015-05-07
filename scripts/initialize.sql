
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

INSERT INTO `RTM`.`rtm_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("汕头专卖店","广东","汕头","南区");
INSERT INTO `RTM`.`rtm_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("友谊（淘金店）","广东","广州","南区");
INSERT INTO `RTM`.`rtm_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("俊涛企业(黄石店)","广东","广州","南区");
INSERT INTO `RTM`.`rtm_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("山姆会员店-广州-番禺店","广东","广州","南区");
INSERT INTO `RTM`.`rtm_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("麦德龙-广州-天河店","广东","广州","南区");
INSERT INTO `RTM`.`rtm_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("麦德龙-广州-新市店","广东","广州","南区");
INSERT INTO `RTM`.`rtm_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("东岳（宏基）商场","广东","云浮","南区");
INSERT INTO `RTM`.`rtm_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("铭轩商行","广东","惠州","南区");
INSERT INTO `RTM`.`rtm_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("麦德龙","广东","东莞","南区");
INSERT INTO `RTM`.`rtm_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("南北行","广东","东莞","南区");
INSERT INTO `RTM`.`rtm_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("深圳山姆会员店龙岗分店","广东","深圳","南区");
INSERT INTO `RTM`.`rtm_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("深圳麦德龙南山店","广东","深圳","南区");
INSERT INTO `RTM`.`rtm_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("天虹常兴店","广东","深圳","南区");
INSERT INTO `RTM`.`rtm_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("华润万家春风店","广东","深圳","南区");
INSERT INTO `RTM`.`rtm_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("Ole万象城店","广东","深圳","南区");
INSERT INTO `RTM`.`rtm_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("酒易购商行","广东","深圳","南区");
INSERT INTO `RTM`.`rtm_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("特免格兰云天店","广东","深圳","南区");
INSERT INTO `RTM`.`rtm_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("华润万家龙岗店","广东","深圳","南区");
INSERT INTO `RTM`.`rtm_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("东启品味创业店","广东","深圳","南区");
INSERT INTO `RTM`.`rtm_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("漳州龙海志盛商行","福建","漳州","东区");
INSERT INTO `RTM`.`rtm_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("漳州云霄县乐天酒类贸易有限公司","福建","漳州","东区");
INSERT INTO `RTM`.`rtm_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("漳州素惠食杂","福建","漳州","东区");
INSERT INTO `RTM`.`rtm_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("漳州诏安县小平酒铺","福建","漳州","东区");
INSERT INTO `RTM`.`rtm_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("三明京丰贸易","福建","三明/南平","东区");
INSERT INTO `RTM`.`rtm_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("莆田市德盛烟酒商行","福建","莆田","东区");
INSERT INTO `RTM`.`rtm_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("山姆会员店-福州-福州店","福建","福州","东区");
INSERT INTO `RTM`.`rtm_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("麦德龙-厦门-湖里店","福建","厦门","东区");
INSERT INTO `RTM`.`rtm_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("厦门杏林妙云食杂店","福建","厦门","东区");
INSERT INTO `RTM`.`rtm_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("泉州市石狮市历记名酒贸易有限公司","福建","泉州","东区");
INSERT INTO `RTM`.`rtm_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("泉州市佳鸿名酒行","福建","泉州","东区");
INSERT INTO `RTM`.`rtm_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("泉州市丰泽裕源食品商行","福建","泉州","东区");
INSERT INTO `RTM`.`rtm_global_store` (`store_name`,`province`,`city`,`region`) VALUES ("山姆会员店-福州-福州店","福建","福州","东区");

/*初始化促销员*/

INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (1,"谢玉婷","","13790848765","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (2,"林晓芬","","13631375429","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (3,"吴惠贤","","15012407923","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (4,"蒋银燕","","18620805330","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (4,"陈燕嫦","","13682270631","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (4,"陈锦飞","","13427565824","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (5,"陈燕薇","","18666003803","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (6,"陈桂玲","","15813342324","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (7,"梁春燕","","13826853122","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (8,"陈丽玲","","13809664833","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (9,"谭丽丹","","13712085227","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (10,"张秋艳","","13729911558","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (11,"冯芳","","13480981336","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (11,"王洪林","","13823299341","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (11,"程小玲","","13510612459","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (11,"熊丽","","13510209458","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (11,"高小美","","15889326626","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (11,"邢姿妹","","15817369028","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (12,"吴静","","13670040168","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (13,"陈虹利","","13590323775","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (14,"赵秀碧","","15999553961","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (15,"杨雪珠","","15099915191","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (16,"张寒","","18675525837","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (17,"周娜娜","","13927463927","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (18,"亢红丽","","18002585466","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (19,"蒲婷","","15999585598","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (20,"李巍嘉","","18759619188","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (21,"陈阿芳","","13860862587","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (22,"翁丽颖","","18760331182","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (23,"蔡品佳","","14760234376","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (24,"庄婷","","15159140615","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (25,"林晶晶","","13950702101","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (26,"张阿芳","","13559110982","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (27,"邓飞","","13799280627","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (28,"郭素玉","","13950181318","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (29,"汤春梅","","15980090858","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (30,"连桂珍","","15980001818","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (31,"郑碧聪","","18750598001","","",0,"2015-05-01 08:42:00");

# 测试账号

INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (32,"Justin ","","15821886942","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (32,"Karen ","","13816921465","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (32,"Kenny ","","18675872150","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (32,"王聘","","18616834042","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (32,"吴励","","18616240926","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (32,"张小英","","13501604672","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (32,"柏松","","13761422736","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (32,"东方","","13818786382","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (32,"李洁琴","","13012821330","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (32,"严若愚","","13127505232","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (32,"aaron","","18612358655","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (32,"孙埜","","18600372156","","",0,"2015-05-01 08:42:00");
INSERT INTO `RTM`.`rtm_promotion_info` (`store_id`,`name`,`password`,`phone`,`email`,`wechat_id`,`status`,`last_login`) 
VALUES (32,"franksunye","","13910005030","","",0,"2015-05-01 08:42:00");


/*初始化商品*/

/*线下商品*/
INSERT INTO `RTM`.`rtm_product_info`(`name`,`title`,`description`,`source`)
VALUES("人头马禧钻特优香槟干邑","禧钻","描述：人头马禧钻香槟干邑","法国");
INSERT INTO `RTM`.`rtm_product_info`(`name`,`title`,`description`,`source`)
VALUES("人头马1898特优香槟干邑","1898","描述：人头马1898香槟干邑","法国");
INSERT INTO `RTM`.`rtm_product_info`(`name`,`title`,`description`,`source`)
VALUES("人头马天醇X.O特优香槟干邑","天醇X.O","描述：人头马天醇X.O香槟干邑","法国");
INSERT INTO `RTM`.`rtm_product_info`(`name`,`title`,`description`,`source`)
VALUES("人头马诚印特优香槟干邑","诚印","描述：人头马诚印香槟干邑","法国");
INSERT INTO `RTM`.`rtm_product_info`(`name`,`title`,`description`,`source`)
VALUES("人头马CLUB特优香槟干邑","CLUB","描述：人头马CLUB香槟干邑","法国");
INSERT INTO `RTM`.`rtm_product_info`(`name`,`title`,`description`,`source`)
VALUES("人头马V.S.O.P特优香槟干邑","V.S.O.P","描述：人头马V.S.O.P香槟干邑","法国");

/*积分商城商品*/
INSERT INTO `RTM`.`rtm_product_info`(`name`,`title`,`description`,`source`)
VALUES("人头马 君度橙酒 (两瓶)","人头马 君度橙酒 (两瓶)","1849年，君度酿酒厂在法国昂热诞生。我们的酿酒大师精心选用最上乘的甜味橙皮和苦味橙皮，运用传统的酿造技艺，创造出源自天然，晶莹剔透的高档橙味力娇酒——君度。从为君度量身定制的经典鸡尾酒——边车、玛格丽特和君度大都会，到极简主义的君度菲丝，君度一直是精致鸡尾酒的灵魂。君度搭配柠檬或者青柠汁可调制出多种经典鸡尾酒，同样，君度菲丝（君度+青柠+苏打水）是可以在家中轻松调配简易鸡尾酒的完美选择。君度菲丝是调制简易鸡尾酒的完美原料。在你的创意妙想下，君度菲丝将成为你独一无二的特制鸡尾酒，变换出无限可能。","法国");
INSERT INTO `RTM`.`rtm_product_info`(`name`,`title`,`description`,`source`)
VALUES("鹰勇48苏格兰威士忌","鹰勇48苏格兰威士忌","为迎合国际上威士忌越来越淡化年份的趋势，而推出的鹰勇48苏格兰威士忌，其酿制技艺堪称调配型威士忌中的精英。酒体醇厚饱满，口感深邃馥郁，未经冷凝过滤处理的酒液最大限度保留了苏格兰威士忌的纯正口味，迷人的烟熏之外还带有摩卡的悦人口感。
 ","法国");
INSERT INTO `RTM`.`rtm_product_info`(`name`,`title`,`description`,`source`)
VALUES("人头马V.S.O.P蔡依林全球限量版","人头马V.S.O.P蔡依林全球限量版","全球最受好评的V.S.O.P之一。突出的香草气息，并伴随着淡雅花香。入口醇香丰盛，伴有成熟的水果香味及甘草的清淡芬芳，酒体轻盈和谐，层次感丰富。人头马V.S.O.P特优香槟干邑因其高贵气质和独一无二的醇柔口感而备受称赞。净饮或加冰饮用，也可作为基酒调制成各款鸡尾酒。","法国");
INSERT INTO `RTM`.`rtm_product_info`(`name`,`title`,`description`,`source`)
VALUES("人头马天醇X.O特优香槟干邑(礼盒)","人头马天醇X.O特优香槟干邑礼盒","采用源自于干邑区最中心的大小香槟区的优质葡萄，成就了人头马天醇X.O特优香槟干邑独一无二的馥郁芳香，醇香丰盛，顺喉圆浑带来如丝般感觉。茉莉、鸢尾花、肉桂等花果香气如清风袭面，天鹅绒般饱满的醇香丰盈、顺喉、圆浑，带来飘飘欲仙的回甘。","法国");
INSERT INTO `RTM`.`rtm_product_info`(`name`,`title`,`description`,`source`)
VALUES("人头马天醇X.O特优香槟干邑","人头马天醇X.O特优香槟干邑","人头马首席酿酒大师皮埃雷特·特里谢女士，甄选四百多钟珍贵生命之水，悉心调配，酿制无与伦比的顶级佳酿。馥郁幽香在岁月长河中升华，缔造出犹如钻石般稀有的人间瑰宝。","法国");
INSERT INTO `RTM`.`rtm_product_info`(`name`,`title`,`description`,`source`)
VALUES("人头马禧钻特优香槟干邑","人头马禧钻特优香槟干邑","人头马首席酿酒大师皮埃雷特·特里谢女士，甄选四百多钟珍贵生命之水，悉心调配，酿制无与伦比的顶级佳酿。馥郁幽香在岁月长河中升华，缔造出犹如钻石般稀有的人间瑰宝。","法国");

/*线下商品*/
INSERT INTO `RTM`.`rtm_product_specification`(`product_id`,`spec_id`,`score`,`stock_num`,`exchange_num`,`is_for_exchange`,`status`)
VALUES(1,"70",500,1000,50,0,0);
INSERT INTO `RTM`.`rtm_product_specification`(`product_id`,`spec_id`,`score`,`stock_num`,`exchange_num`,`is_for_exchange`,`status`)
VALUES(2,"70",250,1000,50,0,0);
INSERT INTO `RTM`.`rtm_product_specification`(`product_id`,`spec_id`,`score`,`stock_num`,`exchange_num`,`is_for_exchange`,`status`)
VALUES(3,"70",100,1000,50,0,0);
INSERT INTO `RTM`.`rtm_product_specification`(`product_id`,`spec_id`,`score`,`stock_num`,`exchange_num`,`is_for_exchange`,`status`)
VALUES(3,"150",200,1000,50,0,0);
INSERT INTO `RTM`.`rtm_product_specification`(`product_id`,`spec_id`,`score`,`stock_num`,`exchange_num`,`is_for_exchange`,`status`)
VALUES(3,"300",400,1000,50,0,0);
INSERT INTO `RTM`.`rtm_product_specification`(`product_id`,`spec_id`,`score`,`stock_num`,`exchange_num`,`is_for_exchange`,`status`)
VALUES(4,"70",120,1000,50,0,0);
INSERT INTO `RTM`.`rtm_product_specification`(`product_id`,`spec_id`,`score`,`stock_num`,`exchange_num`,`is_for_exchange`,`status`)
VALUES(4,"100",170,1000,50,0,0);
INSERT INTO `RTM`.`rtm_product_specification`(`product_id`,`spec_id`,`score`,`stock_num`,`exchange_num`,`is_for_exchange`,`status`)
VALUES(4,"150",240,1000,50,0,0);
INSERT INTO `RTM`.`rtm_product_specification`(`product_id`,`spec_id`,`score`,`stock_num`,`exchange_num`,`is_for_exchange`,`status`)
VALUES(4,"300",480,1000,50,0,0);
INSERT INTO `RTM`.`rtm_product_specification`(`product_id`,`spec_id`,`score`,`stock_num`,`exchange_num`,`is_for_exchange`,`status`)
VALUES(5,"70",60,1000,50,0,0);
INSERT INTO `RTM`.`rtm_product_specification`(`product_id`,`spec_id`,`score`,`stock_num`,`exchange_num`,`is_for_exchange`,`status`)
VALUES(5,"100",80,1000,50,0,0);
INSERT INTO `RTM`.`rtm_product_specification`(`product_id`,`spec_id`,`score`,`stock_num`,`exchange_num`,`is_for_exchange`,`status`)
VALUES(5,"150",120,1000,50,0,0);
INSERT INTO `RTM`.`rtm_product_specification`(`product_id`,`spec_id`,`score`,`stock_num`,`exchange_num`,`is_for_exchange`,`status`)
VALUES(6,"70",30,1000,50,0,0);
INSERT INTO `RTM`.`rtm_product_specification`(`product_id`,`spec_id`,`score`,`stock_num`,`exchange_num`,`is_for_exchange`,`status`)
VALUES(6,"100",40,1000,50,0,0);
INSERT INTO `RTM`.`rtm_product_specification`(`product_id`,`spec_id`,`score`,`stock_num`,`exchange_num`,`is_for_exchange`,`status`)
VALUES(6,"150",60,1000,50,0,0);

/*积分商城商品*/
INSERT INTO `RTM`.`rtm_product_specification`(`product_id`,`spec_id`,`score`,`stock_num`,`exchange_num`,`is_for_exchange`,`status`)
VALUES(7,"35",100,1000,1000,1,0);
INSERT INTO `RTM`.`rtm_product_specification`(`product_id`,`spec_id`,`score`,`stock_num`,`exchange_num`,`is_for_exchange`,`status`)
VALUES(8,"70",200,1000,1000,1,0);
INSERT INTO `RTM`.`rtm_product_specification`(`product_id`,`spec_id`,`score`,`stock_num`,`exchange_num`,`is_for_exchange`,`status`)
VALUES(9,"150",500,1000,1000,1,0);
INSERT INTO `RTM`.`rtm_product_specification`(`product_id`,`spec_id`,`score`,`stock_num`,`exchange_num`,`is_for_exchange`,`status`)
VALUES(10,"70",1000,1000,1000,1,0);
INSERT INTO `RTM`.`rtm_product_specification`(`product_id`,`spec_id`,`score`,`stock_num`,`exchange_num`,`is_for_exchange`,`status`)
VALUES(11,"150",2000,1000,1000,1,0);
INSERT INTO `RTM`.`rtm_product_specification`(`product_id`,`spec_id`,`score`,`stock_num`,`exchange_num`,`is_for_exchange`,`status`)
VALUES(12,"70",4000,1000,1000,1,0);

/*产品图片*/

INSERT INTO `RTM`.`rtm_product_images`(`product_id`,`thumbnail_url`,`image_url`)VALUES(1,"thumbnailurl1","bigimageurl1");
INSERT INTO `RTM`.`rtm_product_images`(`product_id`,`thumbnail_url`,`image_url`)VALUES(2,"thumbnailurl2","bigimageurl2");
INSERT INTO `RTM`.`rtm_product_images`(`product_id`,`thumbnail_url`,`image_url`)VALUES(3,"thumbnailurl3","bigimageurl3");
INSERT INTO `RTM`.`rtm_product_images`(`product_id`,`thumbnail_url`,`image_url`)VALUES(4,"thumbnailurl4","bigimageurl4");
INSERT INTO `RTM`.`rtm_product_images`(`product_id`,`thumbnail_url`,`image_url`)VALUES(5,"thumbnailurl5","bigimageurl5");
INSERT INTO `RTM`.`rtm_product_images`(`product_id`,`thumbnail_url`,`image_url`)VALUES(6,"thumbnailurl6","bigimageurl6");
INSERT INTO `RTM`.`rtm_product_images`(`product_id`,`thumbnail_url`,`image_url`)VALUES(7,"item1.png","item_l_1.png");
INSERT INTO `RTM`.`rtm_product_images`(`product_id`,`thumbnail_url`,`image_url`)VALUES(8,"item2.png","img2.png");
INSERT INTO `RTM`.`rtm_product_images`(`product_id`,`thumbnail_url`,`image_url`)VALUES(9,"item3.png","img3.png");
INSERT INTO `RTM`.`rtm_product_images`(`product_id`,`thumbnail_url`,`image_url`)VALUES(10,"item4.png","img4.png");
INSERT INTO `RTM`.`rtm_product_images`(`product_id`,`thumbnail_url`,`image_url`)VALUES(11,"item5.png","img5.png");
INSERT INTO `RTM`.`rtm_product_images`(`product_id`,`thumbnail_url`,`image_url`)VALUES(12,"item6.png","img6.png");


