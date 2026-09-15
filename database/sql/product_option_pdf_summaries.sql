-- Product-specific selection, labels, and order for the Product Specification
-- table in the exported PDF. This is intentionally separate from the
-- storefront preview and detailed-summary settings.
-- Run this once after product_option_price_summaries.sql.

ALTER TABLE `product_option_groups`
    ADD COLUMN `show_in_pdf_summary` TINYINT(1) NOT NULL DEFAULT 0 AFTER `price_summary_option_id`,
    ADD COLUMN `pdf_summary_label` VARCHAR(255) NULL AFTER `show_in_pdf_summary`,
    ADD COLUMN `pdf_summary_sort_order` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `pdf_summary_label`,
    ADD KEY `product_option_groups_product_pdf_summary_index`
        (`product_id`, `show_in_pdf_summary`, `pdf_summary_sort_order`);

ALTER TABLE `product_option_group_items`
    ADD COLUMN `show_in_pdf_summary` TINYINT(1) NOT NULL DEFAULT 0 AFTER `price_summary_option_id`,
    ADD COLUMN `pdf_summary_label` VARCHAR(255) NULL AFTER `show_in_pdf_summary`,
    ADD COLUMN `pdf_summary_sort_order` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `pdf_summary_label`,
    ADD KEY `product_option_group_items_pdf_summary_index`
        (`product_option_group_id`, `show_in_pdf_summary`, `pdf_summary_sort_order`);

-- Preserve the current PDF Product Specification rows until the new PDF list
-- is configured separately in Admin.
UPDATE `product_option_groups`
SET `show_in_pdf_summary` = `show_in_order_summary`,
    `pdf_summary_label` = `summary_label`,
    `pdf_summary_sort_order` = `summary_sort_order`;

UPDATE `product_option_group_items`
SET `show_in_pdf_summary` = `show_in_order_summary`,
    `pdf_summary_label` = `summary_label`,
    `pdf_summary_sort_order` = `summary_sort_order`;
