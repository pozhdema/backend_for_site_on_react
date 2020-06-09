DROP TABLE IF EXISTS categories;
CREATE TABLE `php_course`.`categories` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title_ua` VARCHAR(45) NOT NULL,
  `title_en` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

DROP TABLE IF EXISTS photo;
CREATE TABLE `php_course`.`photo` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `path` VARCHAR(200) NOT NULL,
  `name` VARCHAR(200) NOT NULL,
  `is_visible` INT NOT NULL DEFAULT 1,
  `slider_home` INT NOT NULL DEFAULT 0,
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`));

DROP TABLE IF EXISTS photo_category;
CREATE TABLE `php_course`.`photo_category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_photo` INT NOT NULL,
  `id_category` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `FK_photo_idx` (`id_photo` ASC),
  INDEX `FK_category_idx` (`id_category` ASC),
  CONSTRAINT `FK_photo`
    FOREIGN KEY (`id_photo`)
    REFERENCES `php_course`.`photo` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `FK_category`
    FOREIGN KEY (`id_category`)
    REFERENCES `php_course`.`categories` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE);

DROP TABLE IF EXISTS roles;
CREATE TABLE `php_course`.`roles` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`));

DROP TABLE IF EXISTS users;
CREATE TABLE `php_course`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(200) NOT NULL,
  `username` VARCHAR(200) NOT NULL,
  `password` VARCHAR(400) NOT NULL,
  `role_id` INT NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_agent` TEXT NOT NULL,
  `ip` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `FK_role_1_idx` (`role_id` ASC),
  CONSTRAINT `FK_role_1`
    FOREIGN KEY (`role_id`)
    REFERENCES `php_course`.`roles` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE);

DROP TABLE IF EXISTS resources;
CREATE TABLE `php_course`.`resources` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `resource` VARCHAR(100) NOT NULL,
  `permission` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`));

DROP TABLE IF EXISTS permissions;
CREATE TABLE `php_course`.`permissions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `role_id` INT NOT NULL,
  `resource_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `FK_role_idx` (`role_id` ASC),
  INDEX `FK_resource_idx` (`resource_id` ASC),
  CONSTRAINT `FK_role`
    FOREIGN KEY (`role_id`)
    REFERENCES `php_course`.`roles` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `FK_resource`
    FOREIGN KEY (`resource_id`)
    REFERENCES `php_course`.`resources` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE);

ALTER TABLE `php_course`.`photo`
ADD COLUMN `title_ua` TEXT NOT NULL AFTER `created`,
ADD COLUMN `title_en` TEXT NOT NULL AFTER `title_ua`,
ADD COLUMN `description_ua` TEXT NOT NULL AFTER `title_en`,
ADD COLUMN `description_en` TEXT NOT NULL AFTER `description_ua`;

INSERT INTO `php_course`.`roles` (`id`, `name`) VALUES (1,'public');
INSERT INTO `php_course`.`roles` (`id`, `name`) VALUES (2,'admin');
INSERT INTO `php_course`.`roles` (`id`, `name`) VALUES (3,'user');

ALTER TABLE `php_course`.`users`
ADD UNIQUE INDEX `email_UNIQUE` (`email` ASC);

INSERT INTO `php_course`.`resources` (`resource`, `permission`) VALUES ('index', 'index');
INSERT INTO `php_course`.`resources` (`resource`, `permission`) VALUES ('categories', 'add');

INSERT INTO `php_course`.`permissions` (`role_id`, `resource_id`) VALUES ('1', '1');
INSERT INTO `php_course`.`permissions` (`role_id`, `resource_id`) VALUES ('2', '2');
