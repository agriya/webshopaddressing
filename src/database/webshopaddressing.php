CREATE TABLE `addresses`(
	 `id` INT NOT NULL AUTO_INCREMENT ,
	 `user_id` INT ,
	 `address_line1` VARCHAR(255) ,
	 `address_line2` VARCHAR(255) ,
	 `street` VARCHAR(255) ,
	 `city` VARCHAR(255) ,
	 `state` VARCHAR(255) ,
	 `country` VARCHAR(255) ,
	 `country_id` INT ,
	 PRIMARY KEY (`id`)  );