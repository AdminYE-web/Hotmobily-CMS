-- Product-specific selection, labels, and order for the summary shown above the steps.
-- Run this once after product_option_group_summary_labels.sql.

ALTER TABLE `product_option_groups`
    ADD COLUMN `show_in_preview_summary` TINYINT(1) NOT NULL DEFAULT 0 AFTER `summary_sort_order`,
    ADD COLUMN `preview_summary_label` VARCHAR(255) NULL AFTER `show_in_preview_summary`,
    ADD COLUMN `preview_summary_sort_order` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `preview_summary_label`,
    ADD KEY `product_option_groups_product_preview_summary_index` (`product_id`, `show_in_preview_summary`, `preview_summary_sort_order`);

-- Preserve the previous behaviour until the two lists are configured separately.
UPDATE `product_option_groups`
SET `show_in_preview_summary` = `show_in_order_summary`,
    `preview_summary_label` = `summary_label`,
    `preview_summary_sort_order` = `summary_sort_order`;
