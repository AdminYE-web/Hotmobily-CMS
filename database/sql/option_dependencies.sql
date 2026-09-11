-- Option-to-option and option-to-group storefront dependency settings.

CREATE TABLE `option_dependencies` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `trigger_product_option_id` BIGINT UNSIGNED NOT NULL,
    `target_type` VARCHAR(20) NOT NULL,
    `target_product_option_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `target_option_group_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `action_type` VARCHAR(20) NOT NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `option_dependencies_trigger_option_index` (`trigger_product_option_id`),
    KEY `option_dependencies_target_option_index` (`target_product_option_id`),
    KEY `option_dependencies_target_group_index` (`target_option_group_id`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;
