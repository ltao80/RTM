DROP TABLE IF EXISTS `rtm_delivery_company`;
CREATE TABLE `rtm_delivery_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(45) NOT NULL COMMENT '物流公司名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*物流公司*/
INSERT INTO `RTM`.`rtm_delivery_company`
(`id`,
`company_name`)
VALUES
('顺丰快递');


ALTER TABLE `RTM`.`rtm_order_online`
CHANGE COLUMN `delivery_thirdparty_code` `delivery_order_code` VARCHAR(45) NULL DEFAULT NULL COMMENT '运单编号，第三方物流编号，需要调用第三方api得到物流信息' ,
ADD COLUMN `delivery_company_id` INT NULL AFTER `delivery_id`,
ADD INDEX `fk_rtm_order_online_1_idx1` (`delivery_company_id` ASC);
ALTER TABLE `RTM`.`rtm_order_online`
ADD CONSTRAINT `fk_rtm_order_online_1`
  FOREIGN KEY (`delivery_company_id`)
  REFERENCES `RTM`.`rtm_delivery_company` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


ALTER TABLE `RTM`.`rtm_order_online`
CHANGE COLUMN `order_datetime` `order_datetime` DATETIME NOT NULL COMMENT '订单生成时间' ;



ALTER TABLE `RTM`.`rtm_order_offline`
CHANGE COLUMN `receipt_date` `receipt_date` DATETIME NOT NULL COMMENT '离线订单时间' ;


ALTER TABLE `RTM`.`rtm_customer_score_list`
CHANGE COLUMN `order_datetime` `order_datetime` DATETIME NOT NULL ;

ALTER TABLE `rtm_promotion_info`
ADD COLUMN `is_admin`  tinyint(1) NULL DEFAULT 0 COMMENT '是否为管理员' AFTER `status`;
