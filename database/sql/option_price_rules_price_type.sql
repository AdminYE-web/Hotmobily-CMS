-- Upgrade SQL for an existing option_price_rules table.
ALTER TABLE `option_price_rules`
    ADD COLUMN `price_type` VARCHAR(20) NOT NULL DEFAULT 'per_order' AFTER `rule_name`;
