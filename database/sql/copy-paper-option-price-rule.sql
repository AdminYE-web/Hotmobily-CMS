-- Copy the acrylic 00 price rule to one paper-pattern option.
-- Change only @target_code to reuse this script for another pattern.
-- 1 = All products (product_id = NULL), 0 = keep the source rule's product scope.
SET @source_rule_id = 15;
SET @target_code = 'paper-pattern1';
SET @apply_all_products = 1;

START TRANSACTION;

SET @destination_product_id = IF(@apply_all_products = 1, NULL, (
    SELECT product_id FROM option_price_rules WHERE id = @source_rule_id
));

SET @target_option_id = (
    SELECT target.id
    FROM option_price_rules AS source
    LEFT JOIN products AS product ON product.id = source.product_id
    JOIN product_options AS original ON original.id = source.target_product_option_id
    JOIN product_options AS target ON target.option_group_id = original.option_group_id
    WHERE source.id = @source_rule_id
      AND (source.product_id IS NULL OR product.slug = 'acrylic')
      AND original.option_code = '00'
      AND target.option_code = @target_code
      AND target.id <> original.id
);

INSERT INTO option_price_rules
    (product_id, rule_name, price_type, target_product_option_id, tax_rate, created_at, updated_at)
SELECT @destination_product_id, LEFT(CONCAT(source.rule_name, '_', @target_code), 255),
       source.price_type, @target_option_id, source.tax_rate, NOW(), NOW()
FROM option_price_rules AS source
WHERE source.id = @source_rule_id
  AND @target_option_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM option_price_rules AS existing
      WHERE existing.product_id <=> @destination_product_id
        AND existing.target_product_option_id = @target_option_id
  );

SET @new_rule_id = IF(ROW_COUNT() = 1, LAST_INSERT_ID(), (
    SELECT MIN(existing.id)
    FROM option_price_rules AS existing
    JOIN option_price_rules AS original_rule ON original_rule.id = @source_rule_id
    WHERE existing.product_id <=> @destination_product_id
      AND existing.target_product_option_id = @target_option_id
      AND existing.rule_name = LEFT(CONCAT(original_rule.rule_name, '_', @target_code), 255)
    HAVING COUNT(*) = 1
));

INSERT INTO option_price_rule_conditions
    (option_price_rule_id, product_option_id, created_at, updated_at)
SELECT @new_rule_id,
       IF(condition_row.product_option_id = source.target_product_option_id,
          @target_option_id, condition_row.product_option_id), NOW(), NOW()
FROM option_price_rule_conditions AS condition_row
JOIN option_price_rules AS source ON source.id = condition_row.option_price_rule_id
WHERE source.id = @source_rule_id AND @new_rule_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM option_price_rule_conditions AS existing_condition
      WHERE existing_condition.option_price_rule_id = @new_rule_id
        AND existing_condition.product_option_id = IF(condition_row.product_option_id = source.target_product_option_id,
            @target_option_id, condition_row.product_option_id)
  );

INSERT INTO option_price_rule_tiers
    (option_price_rule_id, quantity, additional_price, additional_price_with_tax, created_at, updated_at)
SELECT @new_rule_id, source_tier.quantity, source_tier.additional_price, source_tier.additional_price_with_tax, NOW(), NOW()
FROM option_price_rule_tiers AS source_tier
WHERE source_tier.option_price_rule_id = @source_rule_id AND @new_rule_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM option_price_rule_tiers AS existing_tier
      WHERE existing_tier.option_price_rule_id = @new_rule_id
        AND existing_tier.quantity = source_tier.quantity
  );

COMMIT;

SELECT @target_code AS target_option_code, @new_rule_id AS created_rule_id,
       IF(@destination_product_id IS NULL, 'All products', CONCAT('Product ', @destination_product_id)) AS applies_to,
       CASE
           WHEN @target_option_id IS NULL THEN 'Source or target option not found'
           WHEN @new_rule_id IS NULL THEN 'Skipped: another price rule already exists for this option'
           ELSE 'Copied or completed successfully'
       END AS result;
