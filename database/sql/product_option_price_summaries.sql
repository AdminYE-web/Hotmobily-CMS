-- Product-specific configuration for the Production Charges table.
-- Per-option rows are used only for Option Groups with display_type = 'switch'.
-- Run this once after product_option_item_summaries.sql.

ALTER TABLE `product_option_groups`
    ADD COLUMN `show_in_price_summary` TINYINT(1) NOT NULL DEFAULT 0 AFTER `preview_summary_sort_order`,
    ADD COLUMN `price_summary_label` VARCHAR(255) NULL AFTER `show_in_price_summary`,
    ADD COLUMN `price_summary_sort_order` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `price_summary_label`,
    ADD COLUMN `price_summary_option_id` BIGINT UNSIGNED NULL DEFAULT NULL AFTER `price_summary_sort_order`,
    ADD KEY `product_option_groups_product_price_summary_index` (`product_id`, `show_in_price_summary`, `price_summary_sort_order`);

ALTER TABLE `product_option_group_items`
    ADD COLUMN `show_in_price_summary` TINYINT(1) NOT NULL DEFAULT 0 AFTER `preview_summary_sort_order`,
    ADD COLUMN `price_summary_label` VARCHAR(255) NULL AFTER `show_in_price_summary`,
    ADD COLUMN `price_summary_sort_order` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `price_summary_label`,
    ADD COLUMN `price_summary_option_id` BIGINT UNSIGNED NULL DEFAULT NULL AFTER `price_summary_sort_order`,
    ADD KEY `product_option_group_items_price_summary_index` (`product_option_group_id`, `show_in_price_summary`, `price_summary_sort_order`);

-- Preserve the existing Production Charges rows and use the option itself as
-- the default source for switch rows.
UPDATE `product_option_groups`
SET `show_in_price_summary` = `show_in_order_summary`,
    `price_summary_label` = `summary_label`,
    `price_summary_sort_order` = `summary_sort_order`;

UPDATE `product_option_group_items`
SET `show_in_price_summary` = `show_in_order_summary`,
    `price_summary_label` = `summary_label`,
    `price_summary_sort_order` = `summary_sort_order`,
    `price_summary_option_id` = `product_option_id`;
