-- Product-specific configuration for the Complete page email/template.
-- This keeps the Complete page Product specification and Production charges
-- independent from the storefront, PDF export, and Confirm page settings.
-- Run this once after product_option_confirm_price_summaries.sql and
-- products_notice.sql.

ALTER TABLE `products`
    ADD COLUMN `complete_head_text` TEXT NULL AFTER `notice_text`;

ALTER TABLE `product_option_groups`
    ADD COLUMN `show_in_complete_summary` TINYINT(1) NOT NULL DEFAULT 0 AFTER `confirm_price_summary_option_id`,
    ADD COLUMN `complete_summary_label` VARCHAR(255) NULL AFTER `show_in_complete_summary`,
    ADD COLUMN `complete_summary_sort_order` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `complete_summary_label`,
    ADD COLUMN `show_in_complete_price_summary` TINYINT(1) NOT NULL DEFAULT 0 AFTER `complete_summary_sort_order`,
    ADD COLUMN `complete_price_summary_label` VARCHAR(255) NULL AFTER `show_in_complete_price_summary`,
    ADD COLUMN `complete_price_summary_sort_order` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `complete_price_summary_label`,
    ADD COLUMN `complete_price_summary_option_id` BIGINT UNSIGNED NULL DEFAULT NULL AFTER `complete_price_summary_sort_order`,
    ADD KEY `product_option_groups_complete_summary_index`
        (`product_id`, `show_in_complete_summary`, `complete_summary_sort_order`),
    ADD KEY `product_option_groups_complete_price_summary_index`
        (`product_id`, `show_in_complete_price_summary`, `complete_price_summary_sort_order`);

ALTER TABLE `product_option_group_items`
    ADD COLUMN `show_in_complete_summary` TINYINT(1) NOT NULL DEFAULT 0 AFTER `confirm_price_summary_option_id`,
    ADD COLUMN `complete_summary_label` VARCHAR(255) NULL AFTER `show_in_complete_summary`,
    ADD COLUMN `complete_summary_sort_order` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `complete_summary_label`,
    ADD COLUMN `show_in_complete_price_summary` TINYINT(1) NOT NULL DEFAULT 0 AFTER `complete_summary_sort_order`,
    ADD COLUMN `complete_price_summary_label` VARCHAR(255) NULL AFTER `show_in_complete_price_summary`,
    ADD COLUMN `complete_price_summary_sort_order` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `complete_price_summary_label`,
    ADD COLUMN `complete_price_summary_option_id` BIGINT UNSIGNED NULL DEFAULT NULL AFTER `complete_price_summary_sort_order`,
    ADD KEY `product_option_group_items_complete_summary_index`
        (`product_option_group_id`, `show_in_complete_summary`, `complete_summary_sort_order`),
    ADD KEY `product_option_group_items_complete_price_summary_index`
        (`product_option_group_id`, `show_in_complete_price_summary`, `complete_price_summary_sort_order`);

-- Keep the current Confirm page layout as the initial Complete page layout.
-- The two configurations can be changed independently afterwards.
UPDATE `product_option_groups`
SET `show_in_complete_summary` = `show_in_confirm_summary`,
    `complete_summary_label` = `confirm_summary_label`,
    `complete_summary_sort_order` = `confirm_summary_sort_order`,
    `show_in_complete_price_summary` = `show_in_confirm_price_summary`,
    `complete_price_summary_label` = `confirm_price_summary_label`,
    `complete_price_summary_sort_order` = `confirm_price_summary_sort_order`,
    `complete_price_summary_option_id` = `confirm_price_summary_option_id`;

UPDATE `product_option_group_items`
SET `show_in_complete_summary` = `show_in_confirm_summary`,
    `complete_summary_label` = `confirm_summary_label`,
    `complete_summary_sort_order` = `confirm_summary_sort_order`,
    `show_in_complete_price_summary` = `show_in_confirm_price_summary`,
    `complete_price_summary_label` = `confirm_price_summary_label`,
    `complete_price_summary_sort_order` = `confirm_price_summary_sort_order`,
    `complete_price_summary_option_id` = `confirm_price_summary_option_id`;

CREATE TABLE IF NOT EXISTS `product_complete_summary_custom_rows` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `product_id` BIGINT UNSIGNED NOT NULL,
    `sort_order` INT UNSIGNED NOT NULL DEFAULT 0,
    `label` VARCHAR(255) NOT NULL,
    `content` TEXT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `product_complete_summary_custom_rows_product_sort_index`
        (`product_id`, `sort_order`, `id`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;
