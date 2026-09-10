-- Individual Product Options enabled within each product Option Group.
-- Run this once after product_option_groups.sql.

CREATE TABLE `product_option_group_items` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `product_option_group_id` BIGINT UNSIGNED NOT NULL,
    `product_option_id` BIGINT UNSIGNED NOT NULL,
    `sort_order` INT UNSIGNED NOT NULL DEFAULT 0,
    `is_default` TINYINT(1) NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `quantity_rule` VARCHAR(30) NOT NULL DEFAULT 'no_limit',
    `min_qty` INT UNSIGNED NULL DEFAULT NULL,
    `max_qty` INT UNSIGNED NULL DEFAULT NULL,
    `exact_qty` INT UNSIGNED NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `product_option_group_items_assignment_option_unique` (`product_option_group_id`, `product_option_id`),
    KEY `product_option_group_items_assignment_sort_index` (`product_option_group_id`, `sort_order`),
    KEY `product_option_group_items_option_id_index` (`product_option_id`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;
