-- Optional product-specific labels shown in the storefront order summary.
-- Run this once after product_option_group_summaries.sql.

ALTER TABLE `product_option_groups`
    ADD COLUMN `summary_label` VARCHAR(255) NULL AFTER `show_in_order_summary`;
