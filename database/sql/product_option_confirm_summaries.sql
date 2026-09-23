-- Product-specific selection, labels, and order for the Product Specification
-- table on the final Confirm page. This is intentionally independent from
-- the storefront summaries and the exported PDF specification.
-- Run this once after product_option_pdf_summaries.sql.

ALTER TABLE `product_option_groups`
    ADD COLUMN `show_in_confirm_summary` TINYINT(1) NOT NULL DEFAULT 0 AFTER `pdf_summary_sort_order`,
    ADD COLUMN `confirm_summary_label` VARCHAR(255) NULL AFTER `show_in_confirm_summary`,
    ADD COLUMN `confirm_summary_sort_order` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `confirm_summary_label`,
    ADD KEY `product_option_groups_product_confirm_summary_index`
        (`product_id`, `show_in_confirm_summary`, `confirm_summary_sort_order`);

ALTER TABLE `product_option_group_items`
    ADD COLUMN `show_in_confirm_summary` TINYINT(1) NOT NULL DEFAULT 0 AFTER `pdf_summary_sort_order`,
    ADD COLUMN `confirm_summary_label` VARCHAR(255) NULL AFTER `show_in_confirm_summary`,
    ADD COLUMN `confirm_summary_sort_order` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `confirm_summary_label`,
    ADD KEY `product_option_group_items_confirm_summary_index`
        (`product_option_group_id`, `show_in_confirm_summary`, `confirm_summary_sort_order`);

-- Start with the current Product Specification configuration. Future changes
-- in the Confirm section are stored independently.
UPDATE `product_option_groups`
SET `show_in_confirm_summary` = `show_in_order_summary`,
    `confirm_summary_label` = `summary_label`,
    `confirm_summary_sort_order` = `summary_sort_order`;

UPDATE `product_option_group_items`
SET `show_in_confirm_summary` = `show_in_order_summary`,
    `confirm_summary_label` = `summary_label`,
    `confirm_summary_sort_order` = `summary_sort_order`;

CREATE TABLE IF NOT EXISTS `product_confirm_summary_custom_rows` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `product_id` BIGINT UNSIGNED NOT NULL,
    `sort_order` INT UNSIGNED NOT NULL DEFAULT 0,
    `label` VARCHAR(255) NOT NULL,
    `content` TEXT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `product_confirm_summary_custom_rows_product_sort_index`
        (`product_id`, `sort_order`, `id`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;
