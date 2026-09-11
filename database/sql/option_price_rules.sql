-- Product-specific Option Price Rules.
-- Run this SQL after products, option_groups, product_options, and
-- product_option_group_items have been created.

CREATE TABLE `option_price_rules` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `product_id` BIGINT UNSIGNED NOT NULL,
    `rule_name` VARCHAR(255) NOT NULL,
    `price_type` VARCHAR(20) NOT NULL DEFAULT 'per_order',
    `target_product_option_id` BIGINT UNSIGNED NOT NULL,
    `tax_rate` DECIMAL(5,2) NOT NULL DEFAULT 10.00,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `option_price_rules_product_id_index` (`product_id`),
    KEY `option_price_rules_target_option_index` (`target_product_option_id`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `option_price_rule_conditions` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `option_price_rule_id` BIGINT UNSIGNED NOT NULL,
    `product_option_id` BIGINT UNSIGNED NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `option_price_rule_conditions_rule_option_unique` (`option_price_rule_id`, `product_option_id`),
    KEY `option_price_rule_conditions_option_id_index` (`product_option_id`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `option_price_rule_tiers` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `option_price_rule_id` BIGINT UNSIGNED NOT NULL,
    `quantity` INT UNSIGNED NOT NULL,
    `additional_price` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `additional_price_with_tax` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `option_price_rule_tiers_rule_quantity_unique` (`option_price_rule_id`, `quantity`),
    KEY `option_price_rule_tiers_rule_quantity_index` (`option_price_rule_id`, `quantity`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;
