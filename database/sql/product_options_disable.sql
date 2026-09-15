-- Add the optional disabled state and notice for Product Options.
-- Run this once for databases where product_options already exists.

ALTER TABLE `product_options`
    ADD COLUMN `disable_text` TEXT NULL AFTER `option_detail`,
    ADD COLUMN `is_disabled` TINYINT(1) NOT NULL DEFAULT 0 AFTER `option_images`;
