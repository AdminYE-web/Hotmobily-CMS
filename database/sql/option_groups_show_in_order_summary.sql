-- Run once for databases where option_groups already exists.
-- Controls whether an Option Group appears in the order-summary table.

ALTER TABLE `option_groups`
    ADD COLUMN `show_in_order_summary` TINYINT(1) NOT NULL DEFAULT 1
    AFTER `is_required`;
