CREATE DATABASE IF NOT EXISTS `php_ii_module6`;

use php_ii_module6;

CREATE TABLE IF NOT EXISTS `products` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NULL DEFAULT NULL,
    `price` INT NULL DEFAULT NULL,
    `description` TEXT NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
)
ENGINE=InnoDB;

REPLACE INTO `products` VALUES
(1, 'Clean Code', 3199, 'A handbook of agile software craftmanship'),
(2, 'Patterns of Enterprise Application Architecture', 4500, 'Armed with this book, you will have the knowledge necessary to make important architectural decisions.'),
(3, 'Domain-driven Design', 2499, 'Tackling Complexity in the Heart of Software');