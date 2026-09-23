-- Product-specific configuration for the Production Charges table on the
-- final Confirm page. This is intentionally independent from the storefront
-- Production Charges and the exported PDF price rows.
-- Run this once after product_option_confirm_summaries.sql.

ALTER TABLE `product_option_groups`
    ADD COLUMN `show_in_confirm_price_summary` TINYINT(1) NOT NULL DEFAULT 0 AFTER `confirm_summary_sort_order`,
    ADD COLUMN `confirm_price_summary_label` VARCHAR(255) NULL AFTER `show_in_confirm_price_summary`,
    ADD COLUMN `confirm_price_summary_sort_order` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `confirm_price_summary_label`,
    ADD COLUMN `confirm_price_summary_option_id` BIGINT UNSIGNED NULL DEFAULT NULL AFTER `confirm_price_summary_sort_order`,
    ADD KEY `product_option_groups_confirm_price_summary_index`
        (`product_id`, `show_in_confirm_price_summary`, `confirm_price_summary_sort_order`);

ALTER TABLE `product_option_group_items`
    ADD COLUMN `show_in_confirm_price_summary` TINYINT(1) NOT NULL DEFAULT 0 AFTER `confirm_summary_sort_order`,
    ADD COLUMN `confirm_price_summary_label` VARCHAR(255) NULL AFTER `show_in_confirm_price_summary`,
    ADD COLUMN `confirm_price_summary_sort_order` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `confirm_price_summary_label`,
    ADD COLUMN `confirm_price_summary_option_id` BIGINT UNSIGNED NULL DEFAULT NULL AFTER `confirm_price_summary_sort_order`,
    ADD KEY `product_option_group_items_confirm_price_summary_index`
        (`product_option_group_id`, `show_in_confirm_price_summary`, `confirm_price_summary_sort_order`);

-- Preserve the current Production Charges rows as the initial Confirm price
-- configuration. Future changes can then be made independently.
UPDATE `product_option_groups`
SET `show_in_confirm_price_summary` = `show_in_price_summary`,
    `confirm_price_summary_label` = `price_summary_label`,
    `confirm_price_summary_sort_order` = `price_summary_sort_order`,
    `confirm_price_summary_option_id` = `price_summary_option_id`;

UPDATE `product_option_group_items`
SET `show_in_confirm_price_summary` = `show_in_price_summary`,
    `confirm_price_summary_label` = `price_summary_label`,
    `confirm_price_summary_sort_order` = `price_summary_sort_order`,
    `confirm_price_summary_option_id` = `price_summary_option_id`;
