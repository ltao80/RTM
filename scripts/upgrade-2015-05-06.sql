DROP TABLE IF EXISTS `rmt_delivery_company`;
CREATE TABLE `rmt_delivery_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(45) NOT NULL COMMENT '物流公司名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*物流公司*/
INSERT INTO `RTM`.`rmt_delivery_company`
(`id`,
`company_name`)
VALUES
('顺丰快递');