-- Product Options (currently linked to Option Groups only)
-- Run this once after database/sql/option_groups.sql.

CREATE TABLE `product_options` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `option_group_id` BIGINT UNSIGNED NOT NULL,
    `option_code` VARCHAR(100) NOT NULL,
    `option_name` VARCHAR(255) NOT NULL,
    `color_code` VARCHAR(20) NULL,
    `option_detail` TEXT NULL,
    `disable_text` TEXT NULL,
    `option_images` TEXT NULL,
    `is_disabled` TINYINT(1) NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `product_options_group_code_unique` (`option_group_id`, `option_code`),
    KEY `product_options_option_group_id_index` (`option_group_id`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;
