-- Upgrade SQL for existing Product Option tables. Run once when the tables
-- already exist before the quantity/default settings were added.

ALTER TABLE `product_option_groups`
    ADD COLUMN `has_option_configuration` TINYINT(1) NOT NULL DEFAULT 0 AFTER `sort_order`;

ALTER TABLE `product_option_group_items`
    ADD COLUMN `is_default` TINYINT(1) NOT NULL DEFAULT 0 AFTER `sort_order`,
    ADD COLUMN `is_active` TINYINT(1) NOT NULL DEFAULT 1 AFTER `is_default`,
    ADD COLUMN `quantity_rule` VARCHAR(30) NOT NULL DEFAULT 'no_limit' AFTER `is_active`,
    ADD COLUMN `min_qty` INT UNSIGNED NULL DEFAULT NULL AFTER `quantity_rule`,
    ADD COLUMN `max_qty` INT UNSIGNED NULL DEFAULT NULL AFTER `min_qty`,
    ADD COLUMN `exact_qty` INT UNSIGNED NULL DEFAULT NULL AFTER `max_qty`;
