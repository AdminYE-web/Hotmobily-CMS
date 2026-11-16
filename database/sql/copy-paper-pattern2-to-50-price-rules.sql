-- Copy rule 15 (00) to paper-pattern2 through paper-pattern50 in one run.
-- 1 = All products, 0 = keep the source rule's product scope.
-- Run this entire file in one database connection.
SET @source_rule_id = 15;
SET @apply_all_products = 1;

DROP TEMPORARY TABLE IF EXISTS tmp_paper_price_targets;
CREATE TEMPORARY TABLE tmp_paper_price_targets (
    option_id BIGINT UNSIGNED PRIMARY KEY,
    option_code VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    rule_id BIGINT UNSIGNED NULL
);

START TRANSACTION;

SET @destination_product_id = IF(@apply_all_products = 1, NULL, (
    SELECT product_id FROM option_price_rules WHERE id = @source_rule_id
));

INSERT INTO tmp_paper_price_targets (option_id, option_code)
SELECT target.id, target.option_code
FROM option_price_rules AS source
LEFT JOIN products AS product ON product.id = source.product_id
JOIN product_options AS original ON original.id = source.target_product_option_id
JOIN product_options AS target ON target.option_group_id = original.option_group_id
WHERE source.id = @source_rule_id
  AND (source.product_id IS NULL OR product.slug = 'acrylic')
  AND original.option_code = '00'
  AND target.option_code REGEXP '^paper-pattern([2-9]|[1-4][0-9]|50)$';

INSERT INTO option_price_rules
    (product_id, rule_name, price_type, target_product_option_id, tax_rate, created_at, updated_at)
SELECT @destination_product_id, LEFT(CONCAT(source.rule_name, '_', target.option_code), 255),
       source.price_type, target.option_id, source.tax_rate, NOW(), NOW()
FROM option_price_rules AS source
CROSS JOIN tmp_paper_price_targets AS target
WHERE source.id = @source_rule_id
  AND NOT EXISTS (
      SELECT 1 FROM option_price_rules AS existing
      WHERE existing.product_id <=> @destination_product_id
        AND existing.target_product_option_id = target.option_id
  );

UPDATE tmp_paper_price_targets AS target
JOIN option_price_rules AS source ON source.id = @source_rule_id
JOIN option_price_rules AS copied
  ON copied.target_product_option_id = target.option_id
 AND copied.product_id <=> @destination_product_id
 AND copied.rule_name = LEFT(CONCAT(source.rule_name, '_', target.option_code), 255)
SET target.rule_id = copied.id
WHERE NOT EXISTS (
    SELECT 1 FROM option_price_rules AS duplicate_rule
    WHERE duplicate_rule.product_id <=> copied.product_id
      AND duplicate_rule.target_product_option_id = copied.target_product_option_id
      AND duplicate_rule.rule_name = copied.rule_name
      AND duplicate_rule.id <> copied.id
);

INSERT INTO option_price_rule_conditions
    (option_price_rule_id, product_option_id, created_at, updated_at)
SELECT target.rule_id,
       IF(condition_row.product_option_id = source.target_product_option_id,
          target.option_id, condition_row.product_option_id), NOW(), NOW()
FROM tmp_paper_price_targets AS target
JOIN option_price_rules AS source ON source.id = @source_rule_id
JOIN option_price_rule_conditions AS condition_row ON condition_row.option_price_rule_id = source.id
WHERE target.rule_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM option_price_rule_conditions AS existing_condition
      WHERE existing_condition.option_price_rule_id = target.rule_id
        AND existing_condition.product_option_id = IF(condition_row.product_option_id = source.target_product_option_id,
            target.option_id, condition_row.product_option_id)
  );

INSERT INTO option_price_rule_tiers
    (option_price_rule_id, quantity, additional_price, additional_price_with_tax, created_at, updated_at)
SELECT target.rule_id, source_tier.quantity, source_tier.additional_price,
       source_tier.additional_price_with_tax, NOW(), NOW()
FROM tmp_paper_price_targets AS target
JOIN option_price_rule_tiers AS source_tier ON source_tier.option_price_rule_id = @source_rule_id
WHERE target.rule_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM option_price_rule_tiers AS existing_tier
      WHERE existing_tier.option_price_rule_id = target.rule_id
        AND existing_tier.quantity = source_tier.quantity
  );

COMMIT;

SELECT option_code, rule_id,
       IF(@destination_product_id IS NULL, 'All products', CONCAT('Product ', @destination_product_id)) AS applies_to,
       IF(rule_id IS NULL, 'Skipped: another or ambiguous rule exists', 'Copied or completed successfully') AS result
FROM tmp_paper_price_targets
ORDER BY CAST(SUBSTRING(option_code, 14) AS UNSIGNED);

SELECT COUNT(*) AS matched_options, COUNT(rule_id) AS ready_rules,
       49 - COUNT(*) AS missing_options
FROM tmp_paper_price_targets;

DROP TEMPORARY TABLE tmp_paper_price_targets;
