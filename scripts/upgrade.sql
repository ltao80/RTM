ALTER TABLE `RTM`.`rtm_customer_delivery_info`
DROP INDEX `unique_customer_id_is_default` ;

ALTER TABLE `rtm_promotion_info`
ADD COLUMN `is_admin`  tinyint(1) NULL DEFAULT 0 COMMENT '是否为管理员' AFTER `status`;