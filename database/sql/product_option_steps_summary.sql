-- Product-specific step that receives the generated order-summary list.
-- Run this once after product_option_steps.sql on an existing database.

ALTER TABLE `product_option_steps`
    ADD COLUMN `is_summary_step` TINYINT(1) NOT NULL DEFAULT 0 AFTER `sort_order`;
