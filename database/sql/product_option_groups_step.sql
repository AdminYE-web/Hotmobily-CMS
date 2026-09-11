-- Upgrade SQL for an existing product_option_groups table.
ALTER TABLE `product_option_groups`
    ADD COLUMN `product_option_step_id` BIGINT UNSIGNED NULL DEFAULT NULL AFTER `option_group_id`,
    ADD KEY `product_option_groups_step_sort_index` (`product_option_step_id`, `sort_order`);
