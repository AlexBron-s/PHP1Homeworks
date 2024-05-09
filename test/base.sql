CREATE TABLE IF NOT EXISTS `test`.`img` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `path` VARCHAR(255) CHARACTER SET 'latin1' NOT NULL,
  `title` VARCHAR(125) CHARACTER SET 'latin1' NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

ALTER TABLE `test`.`img`
    ADD COLUMN `views` INT NOT NULL DEFAULT 0 AFTER `title`;

INSERT INTO `test`.`img` (`id`, `path`, `title`, `views`) VALUES ('1', 'img/img.png', 'test1', '0');
INSERT INTO `test`.`img` (`id`, `path`, `title`, `views`) VALUES ('2', 'img/img_1.png', 'test2', '0');
INSERT INTO `test`.`img` (`id`, `path`, `title`, `views`) VALUES ('3', 'img/img_2.png', 'test3', '0');

CREATE TABLE IF NOT EXISTS `test`.`product` (
                                                `id` INT NOT NULL AUTO_INCREMENT,
                                                `img_id` INT(11) NULL DEFAULT NULL,
    `title` VARCHAR(45) NULL DEFAULT NULL,
    `price` INT NOT NULL DEFAULT 0,
    `description` VARCHAR(255) NULL,
    PRIMARY KEY (`id`))
    ENGINE = InnoDB;

INSERT INTO `test`.`product` (`id`, `img_id`, `title`, `price`, `description`) VALUES ('1', '1', 'test1', '10', 'test test test');
INSERT INTO `test`.`product` (`id`, `img_id`, `title`, `price`, `description`) VALUES ('2', '2', 'test2', '100', 'testtesttest');

CREATE TABLE `test`.`user` (
                               `id` INT NOT NULL AUTO_INCREMENT,
                               `login` VARCHAR(255) NOT NULL,
                               `password` VARCHAR(255) NOT NULL,
                               PRIMARY KEY (`id`));
