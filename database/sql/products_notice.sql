-- Product-level notice displayed on the storefront when enabled.
ALTER TABLE `products`
    ADD COLUMN `show_notice` TINYINT(1) NOT NULL DEFAULT 0,
    ADD COLUMN `notice_text` TEXT NULL;
