-- Product-specific order-summary selection and order.
-- Run this once after product_option_groups.sql on an existing database.

ALTER TABLE `product_option_groups`
    ADD COLUMN `show_in_order_summary` TINYINT(1) NOT NULL DEFAULT 0 AFTER `has_option_configuration`,
    ADD COLUMN `summary_sort_order` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `show_in_order_summary`,
    ADD KEY `product_option_groups_product_summary_index` (`product_id`, `show_in_order_summary`, `summary_sort_order`);
