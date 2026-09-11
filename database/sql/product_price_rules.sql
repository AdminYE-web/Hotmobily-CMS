-- Product base-price rules with option conditions and quantity price tiers.

CREATE TABLE `product_price_rules` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `product_id` BIGINT UNSIGNED NOT NULL,
    `rule_name` VARCHAR(255) NOT NULL,
    `tax_rate` DECIMAL(5,2) NOT NULL DEFAULT 10.00,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `product_price_rules_product_id_index` (`product_id`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `product_price_rule_conditions` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `product_price_rule_id` BIGINT UNSIGNED NOT NULL,
    `product_option_id` BIGINT UNSIGNED NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `product_price_rule_conditions_rule_option_unique` (`product_price_rule_id`, `product_option_id`),
    KEY `product_price_rule_conditions_option_id_index` (`product_option_id`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `product_price_rule_tiers` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `product_price_rule_id` BIGINT UNSIGNED NOT NULL,
    `quantity` INT UNSIGNED NOT NULL,
    `unit_price` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `unit_price_with_tax` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `is_display` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `product_price_rule_tiers_rule_quantity_unique` (`product_price_rule_id`, `quantity`),
    KEY `product_price_rule_tiers_rule_quantity_index` (`product_price_rule_id`, `quantity`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;
