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
