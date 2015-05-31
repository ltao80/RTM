ALTER TABLE `RTM`.`rtm_customer_delivery_info`
DROP INDEX `unique_customer_id_is_default` ;

ALTER TABLE `rtm_promotion_info`
ADD COLUMN `is_admin`  tinyint(1) NULL DEFAULT 0 COMMENT '是否为管理员' AFTER `status`;


ALTER TABLE `LP`.`lp_user_roles`
DROP FOREIGN KEY `fk_lp_user_roles_1`,
DROP FOREIGN KEY `fk_lp_user_roles_2`;
ALTER TABLE `LP`.`lp_user_roles`
ADD CONSTRAINT `fk_lp_user_roles_1`
  FOREIGN KEY (`user_id`)
  REFERENCES `LP`.`lp_promotion_info` (`id`)
  ON DELETE CASCADE
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_lp_user_roles_2`
  FOREIGN KEY (`role_id`)
  REFERENCES `LP`.`lp_role_info` (`id`)
  ON DELETE CASCADE
  ON UPDATE NO ACTION;
