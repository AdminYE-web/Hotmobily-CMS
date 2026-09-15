-- Product-specific custom rows for the Product Specification table in the
-- exported PDF. Run this once after product_option_pdf_summaries.sql.

CREATE TABLE IF NOT EXISTS `product_pdf_summary_custom_rows` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `product_id` BIGINT UNSIGNED NOT NULL,
    `sort_order` INT UNSIGNED NOT NULL DEFAULT 0,
    `label` VARCHAR(255) NOT NULL,
    `content` TEXT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `product_pdf_summary_custom_rows_product_sort_index`
        (`product_id`, `sort_order`, `id`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;
