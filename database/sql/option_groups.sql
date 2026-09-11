-- Option Groups (standalone; not linked to products yet)
-- Run this once on the application's MySQL database.

CREATE TABLE `option_groups` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `group_code` VARCHAR(100) NOT NULL,
    `group_name` VARCHAR(255) NOT NULL,
    `display_type` VARCHAR(50) NOT NULL DEFAULT 'button',
    `help_text` TEXT NULL,
    `is_main_price_group` TINYINT(1) NOT NULL DEFAULT 0,
    `is_required` TINYINT(1) NOT NULL DEFAULT 0,
    `show_in_order_summary` TINYINT(1) NOT NULL DEFAULT 1,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `option_groups_group_code_unique` (`group_code`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;
