-- Product-option-specific summary selection, labels, and order.
-- Run this once after product_option_group_preview_summaries.sql.

ALTER TABLE `product_option_group_items`
    ADD COLUMN `show_in_order_summary` TINYINT(1) NOT NULL DEFAULT 0 AFTER `is_active`,
    ADD COLUMN `summary_label` VARCHAR(255) NULL AFTER `show_in_order_summary`,
    ADD COLUMN `summary_sort_order` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `summary_label`,
    ADD COLUMN `show_in_preview_summary` TINYINT(1) NOT NULL DEFAULT 0 AFTER `summary_sort_order`,
    ADD COLUMN `preview_summary_label` VARCHAR(255) NULL AFTER `show_in_preview_summary`,
    ADD COLUMN `preview_summary_sort_order` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `preview_summary_label`,
    ADD KEY `product_option_group_items_summary_index` (`product_option_group_id`, `show_in_order_summary`, `summary_sort_order`),
    ADD KEY `product_option_group_items_preview_summary_index` (`product_option_group_id`, `show_in_preview_summary`, `preview_summary_sort_order`);

-- Keep each option from the old group-level summary in both lists initially.
UPDATE `product_option_group_items` AS `item`
INNER JOIN `product_option_groups` AS `assignment`
    ON `assignment`.`id` = `item`.`product_option_group_id`
SET `item`.`show_in_order_summary` = `assignment`.`show_in_order_summary`,
    `item`.`summary_sort_order` = (`assignment`.`summary_sort_order` * 1000) + `item`.`sort_order`,
    `item`.`show_in_preview_summary` = `assignment`.`show_in_preview_summary`,
    `item`.`preview_summary_sort_order` = (`assignment`.`preview_summary_sort_order` * 1000) + `item`.`sort_order`;
