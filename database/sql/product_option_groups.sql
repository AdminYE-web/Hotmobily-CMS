-- Product-to-Option-Group assignments and their display order.
-- Run this once after option_groups.sql and product_options.sql.

CREATE TABLE `product_option_groups` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `product_id` BIGINT UNSIGNED NOT NULL,
    `option_group_id` BIGINT UNSIGNED NOT NULL,
    `product_option_step_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `sort_order` INT UNSIGNED NOT NULL DEFAULT 0,
    `has_option_configuration` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `product_option_groups_product_group_unique` (`product_id`, `option_group_id`),
    KEY `product_option_groups_product_sort_index` (`product_id`, `sort_order`),
    KEY `product_option_groups_step_sort_index` (`product_option_step_id`, `sort_order`),
    KEY `product_option_groups_option_group_id_index` (`option_group_id`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;
